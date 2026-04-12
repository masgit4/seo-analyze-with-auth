<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function attemptUpdateOnlyPassword(Request $request, $user, $callBack)
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'confirmed',
                'different:current_password',
            ],
        ], [
            'password.regex' => 'Password baru harus mengandung huruf kecil, huruf besar, dan angka.',
            'password.different' => 'Password baru harus berbeda dari password lama.',
        ]);

        $has = Hash::check($validated['current_password'], $user->password);

        $update = function ($request, $callBack, $user, $validated, $has) {
            if (!$has) {
                return;
            }

            $user->update([
                'password' => Hash::make($validated['password']),
            ]);

            return $callBack($request);
        };

        return [
            'has' => $has,
            'update' => $update($request, $callBack, $user, $validated, $has),
        ];
    }

    public function attemptUpdateWithoutPassword(Request $request, $user)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'alpha_dash',
                'not_in:auth,me,signin,signup,signout,dashboard,admin,profile,editprofile,changepassword',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
            'bio' => ['nullable', 'string', 'max:255'],
        ], [
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip, dan underscore.',
            'username.min' => 'Username minimal 6 karakter.',
        ]);

        $user->update([
            'name' => trim($validated['name']),
            'username' => strtolower(trim($validated['username'])),
            'email' => strtolower(trim($validated['email'])),
            'bio' => $validated['bio'] ?? null,
        ]);

        return $user;
    }

    public function attemptRegister(Request $request): User
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'alpha_dash',
                'unique:users,username',
                'not_in:auth,me,signin,signup,signout,dashboard,admin,profile,editprofile,changepassword',
            ],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'confirmed',
            ],
        ], [
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip, dan underscore.',
            'username.min' => 'Username minimal 6 karakter.',
            'password.regex' => 'Password harus mengandung huruf kecil, huruf besar, dan angka.',
        ]);

        return User::create([
            'name' => trim($validated['name']),
            'username' => strtolower(trim($validated['username'])),
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
        ]);
    }

    public function attemptLogin(Request $request): User
    {
        $validate = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $this->ensureNotRateLimited($request);

        $loginInput = strtolower(trim($validate['login']));

        $loginType = filter_var($loginInput, FILTER_VALIDATE_EMAIL,) ? 'email' : 'username';

        $credentials = [
            $loginType => $loginInput,
            'password' => $validate['password'],
        ];

        if (!Auth::attempt($credentials)) {
            RateLimiter::hit($this->throttleKey($request, $loginInput), 60);

            throw ValidationException::withMessages([
                'login' => ['Login atau password salah.'],
            ]);
        }

        RateLimiter::clear($this->throttleKey($request, $loginInput));

        $user = User::where($loginType, $loginInput)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'login' => ['User tidak ditemukan.'],
            ]);
        }

        return $user;
    }

    protected function ensureNotRateLimited(Request $request): void
    {
        $loginInput = strtolower(trim($request->input('login')));

        if (!RateLimiter::tooManyAttempts($this->throttleKey($request, $loginInput), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request, $loginInput));

        throw ValidationException::withMessage([
            'login' => ["Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik"],
        ]);
    }

    protected function throttleKey(Request $request, string $loginInput): string
    {
        return Str::lower($loginInput) . '|' . $request->ip();
    }
}
