<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use App\Models\PageVisit;
use Illuminate\Support\Str;

class RecordStatistikPengunjung
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        $visitedPageContext = null;
        $route = $request->route();
        if ($route && method_exists($route, 'getController')) {
            $controller = $route->getController();
            if (
                property_exists($controller, 'page_context') &&
                is_string($controller->page_context) &&
                $controller->page_context !== ''
            ) {
                $visitedPageContext = $controller->page_context;
            }
        }

        $visitorId = $_COOKIE['visitor_id'] ?? null;
        if (!$visitorId || strlen($visitorId) > 64) {
            $visitorId = (string) Str::uuid();
            setcookie('visitor_id', $visitorId, time() + (60 * 60 * 24 * 365), '/');
        }

        if (!Visitor::where('visitor_id', $visitorId)->exists()) {
            Visitor::create([
                'visitor_id' => $visitorId,
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'first_visit_at' => now(),
            ]);
        }

        if ($visitedPageContext) {
            PageVisit::create([
                'visitor_id' => $visitorId,
                'visited_page_context' => $visitedPageContext,
                'visited_at' => now(),
            ]);
        }

        return $next($request);
    }
}