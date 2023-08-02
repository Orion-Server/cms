<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\PreventXssService;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function getOnlineCount(): JsonResponse
    {
        return response()->json([
            'onlineCount' => User::whereOnline('1')->count()
        ]);
    }

    public function getBBCodePreview(Request $request): JsonResponse
    {
        $data = $request->validate([
            'content' => 'required|string'
        ]);

        $content = PreventXssService::sanitize($data['content']);

        return response()->json([
            'success' => true,
            'content' => renderBBCodeText($content, true)
        ]);
    }
}
