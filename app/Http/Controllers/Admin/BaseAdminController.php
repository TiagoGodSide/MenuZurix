<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;

abstract class BaseAdminController extends Controller
{
    protected function currentBusiness(): Business
    {
        /** @var Business|null $business */
        $business = Auth::user()
            ->businesses()
            ->orderBy('businesses.id')
            ->first();

        abort_if(
            $business === null,
            403,
            'Este usuário não está vinculado a um negócio.'
        );

        return $business;
    }
}