<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisit
{
    /**
     * Record a visit for public frontend page views only.
     *
     * Admin, asset, sitemap, download and API/JSON requests are ignored.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->getStatusCode() === 200
            && $request->method() === 'GET'
            && $this->shouldTrack($request)) {
            Visit::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
            ]);
        }

        return $response;
    }

    protected function shouldTrack(Request $request): bool
    {
        if ($request->ajax() || $request->expectsJson()) {
            return false;
        }

        if ($request->is('admin/*', 'storage/*', 'build/*', 'vendor/*', 'sitemap.xml')) {
            return false;
        }

        return ! str_contains($request->path(), 'download');
    }
}
