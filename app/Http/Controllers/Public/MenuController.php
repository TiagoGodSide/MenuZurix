<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\PublicMenuService;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function __construct(
        private readonly PublicMenuService $menuService
    ) {
    }


    public function show(string $slug): View
    {
        $menu = $this->menuService
            ->findBySlug($slug);


        return view(
            'public.menu.show',
            compact('menu')
        );
    }
}