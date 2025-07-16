<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\StatistikPengunjung;

class RecordStatistikPengunjung
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $url = $request->path();

        $today = now()->toDateString();

        $exists = StatistikPengunjung::where('ip_address', $ip)
            ->whereDate('created_at', $today)
            ->where('url', $url)
            ->exists();

        if (!$exists) {
            StatistikPengunjung::create([
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'url' => $url,
            ]);
        }

        return $next($request);
    }
}
