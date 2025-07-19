<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use App\Models\PageVisit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Throwable;
use Illuminate\Http\Client\ConnectionException;

class RecordStatistikPengunjung
{

	protected array $blockedCloudDomains = [
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
		'google.com',
		'colocatel.com',
		'jetcyber.co.id',
		'chinatelecom.cn',
		
	];


	public function handle(Request $request, Closure $next): Response
	{
		if ((new CrawlerDetect())->isCrawler($request->userAgent())) {
			return $next($request);
		}

		try {
			$token = env('IPINFO_TOKEN');
			if ($token) {
				$url = "https://api.ipinfo.io/lite/{$request->ip()}?token={$token}";
				$response = Http::timeout(30)
					->retry(2, 1000)
					->get($url);

				if ($response->successful()) {
					$asDomain = strtolower($response->json('as_domain') ?? '');
					Log::info('IPInfo lookup result', [
						'url' => $url,
						'ip' => $request->ip(),
						'as_domain' => $asDomain,
						'response' => $response->json(),
					]);

					if ($asDomain && in_array($asDomain, $this->blockedCloudDomains, true)) {
						Log::info('Blocked cloud provider detected', [
							'ip' => $request->ip(),
							'as_domain' => $asDomain,
						]);
						return $next($request);
					}
				}
			}
		}
		// Tangani khusus koneksi/timeout Http client
		catch (ConnectionException $e) {
			Log::warning('IPInfo API connection/timeout error: ' . $e->getMessage());
			return $next($request);
		}
		// Tangani exception lain tanpa memblokir request
		catch (Throwable $e) {
			Log::warning('IPInfo API check failed: ' . $e->getMessage());
		}

		$visitorId = $_COOKIE['visitor_id'] ?? null;
		if (!$visitorId || strlen($visitorId) > 64) {
			$visitorId = (string) Str::uuid();
			setcookie('visitor_id', $visitorId, time() + (60 * 60 * 24 * 365), '/');
		}

		Visitor::firstOrCreate(
			['visitor_id' => $visitorId],
			[
				'ip_address' => $request->ip(),
				'user_agent' => $request->userAgent(),
				'first_visit_at' => now(),
			]
		);

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

		$response = $next($request);

		return $response;
	}
}