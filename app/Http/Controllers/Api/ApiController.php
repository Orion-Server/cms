<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function getOnlineCount(): JsonResponse
    {
        return response()->json([
            'onlineCount' => User::whereOnline('1')->count()
        ]);
    }
}
