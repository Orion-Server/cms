<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use Illuminate\Http\Request;

class CameraController extends Controller
{
    public function index(Request $request)
    {
        $photos = Camera::latestWith(true);

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

    public function getFilterData(string $name)
    {
        return match($name) {
            'periods' => [
                'all' => 'All',
                'today' => 'Today',
                'last_week' => 'Last week',
                'last_month' => 'Last month',
            ],
            'rules' => [
                'only_my_friends' => 'Only my friends',
                'liked_by_me' => 'Liked by me',
            ]
        };
    }
}
