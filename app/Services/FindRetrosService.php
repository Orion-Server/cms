<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\{
    Request,
    Client\Response
};
use Illuminate\Support\{
    Facades\Http,
    Facades\Cache
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FindRetrosService
{
    /**
     * The bypass addresses.
     */
    private array $bypassAddresses = [
        '127.0.0.1',
        'localhost'
    ];

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
            'timeout' => 5
        ]);
    }

    public function checkIpVote(Request $request): bool
    {
        if (!getSetting('findretros_enabled', false)) return true;

        $key = sprintf(
            config('services.findretros.session_key'),
            $request->ip()
        );

        $minRankToBypass = getSetting('min_rank_to_bypass_findretros_vote', null);

        if (Cache::has($key) || $request->has('novote')) return true;

        if (in_array($request->ip(), $this->bypassAddresses)) return true;

        if(Auth::check() && is_numeric($minRankToBypass) && Auth::user()->rank >= $minRankToBypass) return true;

        if (!$name = getSetting('findretros_name', false)) {
            throw new \Exception('The FindRetros name is not set.');
            return false;
        }

        $completeEndpoint = sprintf(
            config('services.findretros.verify_vote_uri'),
            $name,
            $request->ip()
        );

        $request = null;

        try {
            $request = $this->client->get($completeEndpoint);
        } catch (\Throwable $error) {
            Log::error("[FINDRETROS] - " . $error->getMessage());
            return false;
        }

        if (is_null($request) || $request->getStatusCode() !== 200) return false;

        $response = (int) $request->getBody()->getContents();

        if (!in_array($response, [1, 2])) return false;

        Cache::put($key, true, now()->addMinutes(30));

        return true;
    }
}
