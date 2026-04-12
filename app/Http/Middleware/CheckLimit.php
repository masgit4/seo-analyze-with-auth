<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Analysis;

class CheckLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        $count = Analysis::where('user_id', $user->id)
            ->wheredate('created_at', today())->count();

        if ($count >= $user->limit) {
            return redirect()->route('home')->with('error', 'Limit harian tercapai (' . $user->limit . 'x)');
        }

        return $next($request);
    }
}
