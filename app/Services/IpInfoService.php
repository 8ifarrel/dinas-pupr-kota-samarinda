<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IpInfoService
{
    public static function getIpInfo()
    {
        try {
            $response = Http::timeout(3)->get("https://free.freeipapi.com/api/json");

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("Failed to fetch IP info. Status: " . $response->status());
            return null;
        } catch (\Exception $e) {
            Log::error("IP info service error: " . $e->getMessage());
            return null;
        }
    }
}
