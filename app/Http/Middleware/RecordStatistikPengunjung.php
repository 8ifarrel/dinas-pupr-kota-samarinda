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
	protected array $cloudAsn = [
		'AS16509',    // AWS
		'AS14618',    // AWS
		'AS15169',    // Google
		'AS36040',    // Google
		'AS43515',    // Google
		'AS36561',    // Google
		'AS19527',    // Google
		'AS139070',   // Google
		'AS396982',   // Google
		'AS8075',     // Microsoft Azure
		'AS16276',    // OVH
		'AS14061',    // DigitalOcean
		'AS63949',    // Linode
		'AS20473',    // Vultr
		'AS51167',    // Contabo
		'AS141995',   // Contabo
		'AS141995',   // IDCloudHost
		'AS31898',    // OCI
		'AS397227',   // OCI
		'AS45102',    // Alibaba
		'AS37963',    // Alibaba
		'AS45090',    // Tencent
		'AS132203',   // Tencent
		'AS36351',    // IBM
		'AS24940',    // Hetzner Online
	];

	public function handle(Request $request, Closure $next): Response
	{
		$ip = $request->ip();
		$userAgent = $request->userAgent();

		$crawlerDetect = new CrawlerDetect();
		if ($crawlerDetect->isCrawler($userAgent)) {
			return $next($request);
		}

		$asn = null;
		try {
			$token = env('IPINFO_TOKEN', '');
			if ($token) {
				$url = "https://api.ipinfo.io/lite/{$ip}?token={$token}";
				$response = @file_get_contents($url);
				if ($response) {
					$json = json_decode($response, true);
					if (isset($json['asn'])) {
						$asn = $json['asn'];
					}
				}
			}
		} catch (Throwable $e) {
		}

		if ($asn && in_array($asn, $this->cloudAsn, true)) {
			return $next($request);
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