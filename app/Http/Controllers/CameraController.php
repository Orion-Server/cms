<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use Illuminate\Http\Request;

class CameraController extends Controller
{
    public function index(Request $request)
    {
        $photos = Camera::latestWith(includesRoom: true);

        $period = $request->get('period', null);
        $rule = $request->get('rule', null);

        if($period && in_array($period, array_keys($this->getFilterData('periods')))) {
            $photos->period($period);
        }

        if($rule && in_array($rule, array_keys($this->getFilterData('rules')))) {
            $photos->filter($rule);
        }

        $photos = $photos->paginate(32);

        return view('pages.community.photos.index', [
            'photos' => $photos,
            'rule' => $rule,
            'period' => $period,
            'filters' => [
                'periods' => $this->getFilterData('periods'),
                'rules' => $this->getFilterData('rules')
            ]
        ]);
    }

    public function toggleLike(Request $request, Camera $camera)
    {
        $userId = \Auth::id();

        $like = $camera->likes()
            ->where('user_id', $userId)
            ->first();

        if($like) {
            $like->update([
                'liked' => ! $like->liked
            ]);
        } else {
            $like = $camera->likes()->create([
                'user_id' => $userId,
                'liked' => true
            ]);
        }

        return response()->json([
            'status' => $like->liked,
            'likes' => $camera->likes()->whereLiked(true)->count()
        ]);
    }

    public function getFilterData(string $name)
    {
        return match($name) {
            'periods' => [
                null => __('All'),
                'today' => __('Today'),
                'last_week' => __('Last week'),
                'last_month' => __('Last month'),
            ],
            'rules' => [
                'only_my_friends' => __('Only my friends'),
                'liked_by_me' => __('Liked by me'),
            ]
        };
    }
}
