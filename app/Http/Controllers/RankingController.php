<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use App\Enums\CurrencyType;
use App\Models\UserSetting;
use App\Models\UserCurrency;
use Illuminate\Http\Request;
use App\Services\CacheTimeService;
use Illuminate\Support\Facades\Cache;

class RankingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $rankings = Cache::remember('rankings_data', CacheTimeService::getForRankings(), function () {
            $staffIds = User::getAllStaffsId();

            return [
                'diamonds' => UserCurrency::getRankingFor(CurrencyType::Diamonds, $staffIds)->get(),
                'respects' => UserSetting::getRanking('respects_received', $staffIds)->get(),
                'duckets' => UserCurrency::getRankingFor(CurrencyType::Duckets, $staffIds)->get(),
                'coins' => User::getCreditsRanking()->get(),
                'points' => UserCurrency::getRankingFor(CurrencyType::Points, $staffIds)->get(),
                'online-time' => UserSetting::getRanking('online_time', $staffIds)->get()
            ];
        });

        return view('pages.community.rankings.index', [
            'rankings' => $rankings
        ]);
    }
}
