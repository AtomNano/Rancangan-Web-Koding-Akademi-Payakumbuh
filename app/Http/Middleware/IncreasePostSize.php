<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IncreasePostSize
{
    /**
     * Handle an incoming request.
     * Note: upload_max_filesize and post_max_size cannot be changed at runtime.
     * They must be set in php.ini and server must be restarted.
     * This middleware only increases settings that can be changed at runtime.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // These can be changed at runtime
        @ini_set('max_execution_time', '300');
        @ini_set('max_input_time', '300');
        @ini_set('memory_limit', '256M');
        
        // Log current settings for debugging
        if (app()->environment('local')) {
            \Log::debug('PHP Upload Settings', [
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
                'max_execution_time' => ini_get('max_execution_time'),
                'memory_limit' => ini_get('memory_limit'),
            ]);
        }

        return $next($request);
    }
}

