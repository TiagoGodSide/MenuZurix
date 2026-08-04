<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BusinessStatus;
use App\Enums\BusinessType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateBusinessRequest;
use App\Models\Business;
use App\Services\BusinessService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Throwable;

class BusinessController extends Controller
{
    public function __construct(
        private readonly BusinessService $businessService
    ) {
    }

    public function edit(): View
    {
        $business = $this->currentBusiness();

        return view('admin.business.edit', [
            'business' => $business,
            'businessTypes' => BusinessType::cases(),
            'businessStatuses' => BusinessStatus::cases(),
        ]);
    }

    /**
     * @throws Throwable
     */
    
    /**
 * @throws Throwable
 */
public function update(
    UpdateBusinessRequest $request
): RedirectResponse {
    $business = $this->currentBusiness();

    $this->businessService->update(
        $business,
        $request->safe()->except([
            'logo',
            'banner',
        ]),
        $request->file('logo'),
        $request->file('banner')
    );

    return redirect()
        ->route('admin.business.edit')
        ->with(
            'success',
            'Configurações do negócio atualizadas com sucesso.'
        );
}
    

    private function currentBusiness(): Business
    {
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