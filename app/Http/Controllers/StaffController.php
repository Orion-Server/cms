<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function index(): View
    {
        $staffs = Permission::forIndex();

        return view('pages.community.staff.index', compact('staffs'));
    }
}
