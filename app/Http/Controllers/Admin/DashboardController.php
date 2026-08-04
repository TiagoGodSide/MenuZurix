<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var Business|null $business */
        $business = Auth::user()
            ->businesses()
            ->orderBy('businesses.id')
            ->first();

        return view(
            'admin.dashboard',
            compact('business')
        );
    }
}