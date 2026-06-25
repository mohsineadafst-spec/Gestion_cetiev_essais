<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActionLog;
use Illuminate\Support\Facades\Auth;

class LogActionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Ne pas enregistrer les requêtes GET
        if ($request->method() !== 'GET') {
            $details = $request->only(['email', 'name', 'subject', 'message']);
            ActionLog::create([
                'action' => sprintf(
                    '%s %s [%s]',
                    $request->method(),
                    $request->path(),
                    $response->status()
                ),
                'details' => json_encode([
                    'payload' => $details,
                    'ip' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                ]),
                'user_id' => Auth::id(),
            ]);
        }

        return $response;
    }
}
