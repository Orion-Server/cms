<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\View\View;
use App\Models\WriteableBox;

class TeamController extends Controller
{
    public function index(): View
    {
        $teams = Team::forIndex();
        $writeableBoxes = WriteableBox::getForPage('teams');

        return view('pages.community.teams.index', compact('teams', 'writeableBoxes'));
    }
}
