<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
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

    public function getBBCodePreview(Request $request): JsonResponse
    {
        $data = $request->validate([
            'content' => 'required|string'
        ]);

        return response()->json([
            'success' => true,
            'content' => strip_tags(renderBBCodeText($data['content'], true))
        ]);
    }
}
