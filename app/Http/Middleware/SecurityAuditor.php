<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SecurityLog;

class SecurityAuditor
{
    public function handle(Request $request, Closure $next)
    {
        $inputs = json_encode($request->all());

        // Basic signatures for hacking attempts (SQLi / XSS scripts)
        $threatPatterns = [
            '/union\s+select/i',
            '/<script\b[^>]*>(.*?)<\/script>/is',
            '/drop\s+table/i',
            '/exec\s*\(.*\)/i',
            '/\.\.\/\.\.\//', // Path traversal
        ];

        foreach ($threatPatterns as $pattern) {
            if (preg_match($pattern, $inputs)) {
                SecurityLog::create([
                    'user_id' => auth()->id(),
                    'type' => 'hacking_attempt',
                    'level' => 'critical',
                    'message' => 'Potential attack signature detected: ' . $pattern,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'payload' => $request->all(),
                ]);

                abort(403, 'Unauthorized security violation detected.');
            }
        }

        return $next($request);
    }
}
