<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserLog;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;

class LogUserAgent
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        $action = $request->method() . ' ' . $request->path();

        UserLog::create([
            'user_id'    => Auth::id(),
            'action'     => $action, 
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'browser'    => $agent->browser(),
            'platform'   => $agent->platform(),
        ]);

        return $response;
    }
}
