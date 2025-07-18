<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use App\Models\PageVisit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http; // <-- Gunakan HTTP Client
use Illuminate\Support\Facades\Log; // <-- Gunakan untuk logging error
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class RecordStatistikPengunjung
{
	// Pindahkan daftar ini ke file config, misal: config('statistics.blocked_domains')
	protected array $cloudDomains = [
		'digitalocean.com',
		'amazon.com',
		'microsoft.com',
		'ovhcloud.com',
		'linode.com',
		'constant.com',
		'contabo.com',
		'oracle.com',
		'alibabagroup.com',
		'tencent.com',
		'ibm.com',
		'hetzner.de',
		'hetzner.com',
		'sengked.com',
		'telin.net',
		'awandata.co.id',
		'mobifone.vn',
		'gthost.com',
		'pldt.com',
		'excelindo.co.id',
	];


	public function handle(Request $request, Closure $next): Response
	{
		// 1. Cek Crawler
		if ((new CrawlerDetect())->isCrawler($request->userAgent())) {
			return $next($request);
		}

		// 2. Cek domain cloud (opsional: bisa dipindah ke job)
		try {
			$token = env('IPINFO_TOKEN');
			if ($token) {
				$response = Http::timeout(2)->get("https://ipinfo.io/{$request->ip()}/json?token={$token}");
				if ($response->successful() && $response->json('org')) {
					$orgDomain = strtolower(explode(' ', $response->json('org'))[1] ?? '');
					if (in_array($orgDomain, $this->cloudDomains, true)) {
						return $next($request);
					}
				}
			}
		} catch (\Throwable $e) {
			// Log error tapi jangan blokir request
			Log::warning('IPInfo API check failed: ' . $e->getMessage());
		}

		$visitorId = $_COOKIE['visitor_id'] ?? null;
		if (!$visitorId || strlen($visitorId) > 64) {
			$visitorId = (string) Str::uuid();
			setcookie('visitor_id', $visitorId, time() + (60 * 60 * 24 * 365), '/');
		}

		// 4. Simpan data visitor menggunakan firstOrCreate (Atomik & Efisien)
		Visitor::firstOrCreate(
			['visitor_id' => $visitorId],
			[
				'ip_address' => $request->ip(),
				'user_agent' => $request->userAgent(),
				'first_visit_at' => now(),
			]
		);

		// 5. Ekstrak page context dan rekam kunjungan
		$route = $request->route();
		if ($route && method_exists($route, 'getController')) {
			$controller = $route->getController();
			$pageContext = $controller->page_context ?? null;

			if (is_string($pageContext) && $pageContext !== '') {
				PageVisit::create([
					'visitor_id' => $visitorId,
					'visited_page_context' => $pageContext,
					'visited_at' => now(),
				]);
			}
		}

		// 6. Jalankan request utama
		$response = $next($request);

		return $response;
	}
}