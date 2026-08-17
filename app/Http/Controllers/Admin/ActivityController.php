<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index(): View
    {
        $activities = Activity::query()
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.activity.index', ['activities' => $activities]);
    }
}
