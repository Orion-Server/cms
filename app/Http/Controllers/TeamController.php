<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $teams = Team::forIndex();

        return view('pages.community.teams.index', compact('teams'));
    }
}
