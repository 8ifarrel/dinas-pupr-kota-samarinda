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
use Illuminate\Support\Facades\Cache;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Illuminate\Http\Client\ConnectionException;
use Throwable;

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
		'cloudzy.com',
		'facebook.com',
		'ptbsti.com',
		'ntup.net',
		'tecnoveninternet.com',
		'mangohost.net',
		'ioh.co.id',
		'scalaxy.com',
		'bandwidth.co.uk',
		'ows-networks.com',
		'hivelocity.net',
		'smart.com.kh',
		'bage.dev',
		'akari.hk',
		'ldp.net.id',
	];

	public function handle(Request $request, Closure $next): Response
	{
		// Lewati crawler berdasarkan User-Agent
		if ((new CrawlerDetect())->isCrawler($request->userAgent())) {
			return $next($request);
		}

		try {
			$token = env('IPINFO_TOKEN');
			if ($token) {
				$ip = $request->ip();
				$url = "https://api.ipinfo.io/lite/{$ip}?token={$token}";
				$cacheKey = "ipinfo:{$ip}";

				// Ambil dari cache atau request baru jika belum ada / sudah expired
				$info = Cache::remember($cacheKey, now()->addHours(6), function () use ($url) {
					return Http::timeout(30)
						->retry(2, 1000)
						->get($url)
						->json();
				});

				// Jika JSON valid dan ada field as_domain
				$asDomain = strtolower($info['as_domain'] ?? '');
				Log::info('IPInfo lookup result (cached)', [
					'url' => $url,
					'ip' => $ip,
					'as_domain' => $asDomain,
					'response' => $info,
				]);

				if ($asDomain && in_array($asDomain, $this->blockedCloudDomains, true)) {
					Log::info('Blocked cloud provider detected', [
						'ip' => $ip,
						'as_domain' => $asDomain,
					]);
					// Jangan catat, langsung lanjut request
					return $next($request);
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

		// Proses visitor_id cookie
		$visitorId = $request->cookie('visitor_id');
		if (!$visitorId || strlen($visitorId) > 64) {
			$visitorId = (string) Str::uuid();
			cookie()->queue('visitor_id', $visitorId, 60 * 24 * 365); // menit * hari * tahun
		}

		// Simpan atau update record Visitor
		Visitor::firstOrCreate(
			['visitor_id' => $visitorId],
			[
				'ip_address' => $request->ip(),
				'user_agent' => $request->userAgent(),
				'first_visit_at' => now(),
			]
		);

		// Simpan PageVisit jika controller punya properti page_context
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

		return $next($request);
	}
}
