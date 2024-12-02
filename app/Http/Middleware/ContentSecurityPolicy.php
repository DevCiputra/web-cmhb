<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Menambahkan Content-Security-Policy header
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; script-src 'self' https://cdn.jsdelivr.net https://code.jquery.com https://cdn.datatables.net https://cdnjs.cloudflare.com https://unpkg.com 'unsafe-inline'; style-src 'self' https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.datatables.net https://unpkg.com https://code.jquery.com 'unsafe-inline'; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data: https://cdn.jsdelivr.net https://cdn.datatables.net; object-src 'none'; frame-src 'none';"
        );

        // Menambahkan X-Frame-Options header untuk mencegah ClickJacking
        $response->headers->set('X-Frame-Options', 'DENY');

        // Menambahkan X-Content-Type-Options header untuk mencegah MIME sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Menambahkan Referrer-Policy header untuk mengontrol pengiriman referer
        $response->headers->set('Referrer-Policy', 'no-referrer');

        // Menambahkan Strict-Transport-Security header untuk memastikan koneksi hanya melalui HTTPS
        $response->headers->set(
            'Strict-Transport-Security',
            'max-age=31536000; includeSubDomains'
        );

        return $response;
    }
}
