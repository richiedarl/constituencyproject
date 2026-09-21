<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Application;
use App\Models\Contributor;

class ContributorController extends Controller
{
    public function adminIndex()
    {
        $contributors = Contributor::with('user')
            ->withSum('donations', 'amount')
            ->latest()
            ->paginate(20);

        return view('user.contributors.index', compact('contributors'));
    }
}
