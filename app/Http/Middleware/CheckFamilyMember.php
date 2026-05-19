<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckFamilyMember
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = Auth::user();

        if (!$user->member) {
            return redirect()->route('family.index')
                             ->with('warning', 'Vous devez rejoindre une famille d\'abord.');
        }

        return $next($request);
    }
}
