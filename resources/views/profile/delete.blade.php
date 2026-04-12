@extends('layouts.app')

@section('content')
                <h2 class="text-2xl font-bold text-center mb-2">Delete Account</h2>
                <div class="mb-6">
                    <a
                        class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 p-3 rounded-lg transition"
                        href="{{ secure_route('profile.show', $user->username) }}"
                    >
                        ← Back to Profile
                    </a>
                </div>
                <div class="mb-6 flex items-center justify-center bg-red-300 p-3 rounded-lg text-black transition">
                    <strong>Warning:</strong> accounts that have been deleted cannot be restored.
                </div>
                <form action="{{ secure_route('profile.delete', $user->username) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <label>Enter the password to confirm</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                    />
                    <button
                        type="submit"
                        class="mt-4 w-full bg-red-500 hover:bg-red-600 p-3 rounded-lg font-semibold transition"
                    >
                        Delete Permanent Account
                    </button>
                </form>
@endsection