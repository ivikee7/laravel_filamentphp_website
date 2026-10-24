<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\SecurityAuditor;
use App\Models\SecurityLog;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register the security auditor middleware globally
        $middleware->append(SecurityAuditor::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Automatically log all application errors safely without looping
        $exceptions->report(function (Throwable $e) {
            try {
                \App\Models\SecurityLog::create([
                    'user_id' => auth()->id(),
                    'type' => 'application_error',
                    'level' => 'danger',
                    'message' => $e->getMessage(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->header('User-Agent'),
                    'method' => request()->method(),
                    'url' => request()->fullUrl(),
                    'payload' => [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ],
                ]);
            } catch (\Throwable $loggingException) {
                // Fallback to standard Laravel log if database logging fails
                \Illuminate\Support\Facades\Log::error($e->getMessage());
            }
        });
    })->create();
