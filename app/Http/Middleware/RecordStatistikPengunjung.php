<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use App\Models\PageVisit;
use Illuminate\Support\Str;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Throwable;

class RecordStatistikPengunjung
{
	// blocked cloud domains
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
	];

	public function handle(Request $request, Closure $next): Response
	{
		$ip = $request->ip();
		$userAgent = $request->userAgent();

		$crawlerDetect = new CrawlerDetect();
		if ($crawlerDetect->isCrawler($userAgent)) {
			return $next($request);
		}

		try {
			$token = env('IPINFO_TOKEN', '');
			if ($token) {
				$url = "https://api.ipinfo.io/lite/{$ip}?token={$token}";
				$response = @file_get_contents($url);
				if ($response) {
					$json = json_decode($response, true);
					if (isset($json['as_domain'])) {
						$asDomain = strtolower($json['as_domain']);
						if (in_array($asDomain, $this->cloudDomains, true)) {
							return $next($request);
						}
					}
				}
			}
		} catch (Throwable $e) {
			// ignore error, lanjutkan proses
		}

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