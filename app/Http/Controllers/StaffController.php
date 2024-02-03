<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Permission;
use App\Models\WriteableBox;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(): View
    {
        $staffs = Permission::forIndex();
        $writeableBoxes = WriteableBox::getForPage('staff');

        return view('pages.community.staff.index', compact('staffs', 'writeableBoxes'));
    }
}
