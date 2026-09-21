<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $contractor = $user->contractor;

        if (! $contractor || $contractor->suspended) {
            abort(403, $contractor?->suspended ? 'This contractor account is suspended.' : 'Contractor access required.');
        }

        return $next($request);
    }
}
