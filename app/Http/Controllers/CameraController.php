<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use Illuminate\Http\Request;

class CameraController extends Controller
{
    public array $filters = [
        'only_my_friends',
        'liked_by_me'
    ];

    public array $periods = [
        'all',
        'today',
        'last_week',
        'last_month'
    ];

    public function index(Request $request)
    {
        $photos = Camera::latestWith(true);

        $filter = $request->get('filter', null);
        $period = $request->get('period', null);

        if($filter && in_array($filter, $this->filters)) {
            $photos->filter($filter);
        }

        if($period && in_array($period, $this->periods)) {
            $photos->period($period);
        }

        $photos = $photos->paginate(32);

        return view('pages.community.photos.index', compact('photos'));
    }
}
