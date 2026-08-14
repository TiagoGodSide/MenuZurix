<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreOptionGroupRequest;
use App\Http\Requests\Admin\UpdateOptionGroupRequest;
use App\Models\Business;
use App\Models\OptionGroup;
use App\Services\OptionGroupService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class OptionGroupController extends BaseAdminController
{
    public function __construct(
        private readonly OptionGroupService $optionGroupService
    ) {
    }

    public function index(Request $request): View
    {
        $business = $this->currentBusiness();

        $search = trim(
            (string) $request->string('search')
        );

        $status = $request->string('status')->toString();

        $optionGroups = OptionGroup::query()
            ->where('business_id', $business->id)
            ->withCount('items')
            ->when(
                $search !== '',
                fn ($query) => $query->where(
                    fn ($subquery) => $subquery
                        ->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'description',
                            'like',
                            "%{$search}%"
                        )
                )
            )
            ->when(
                $status === 'active',
                fn ($query) => $query->where(
                    'is_active',
                    true
                )
            )
            ->when(
                $status === 'inactive',
                fn ($query) => $query->where(
                    'is_active',
                    false
                )
            )
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.option-groups.index',
            compact(
                'optionGroups',
                'search',
                'status'
            )
        );
    }

    public function create(): View
    {
        return view(
            'admin.option-groups.create'
        );
    }

    /**
     * @throws Throwable
     */
    public function store(
        StoreOptionGroupRequest $request
    ): RedirectResponse {
        $business = $this->currentBusiness();

        $optionGroup = $this->optionGroupService->create(
            $business,
            $request->safe()->all()
        );

        return redirect()
            ->route(
                'admin.option-groups.edit',
                $optionGroup
            )
            ->with(
                'success',
                'Grupo de opções cadastrado com sucesso.'
            );
    }

    public function edit(
        OptionGroup $optionGroup
    ): View {
        $business = $this->currentBusiness();

        $optionGroup = $this->ownedOptionGroup(
            $business,
            $optionGroup
        );

        $optionGroup->loadCount('items');

        return view(
            'admin.option-groups.edit',
            compact('optionGroup')
        );
    }

    /**
     * @throws Throwable
     */
    public function update(
        UpdateOptionGroupRequest $request,
        OptionGroup $optionGroup
    ): RedirectResponse {
        $business = $this->currentBusiness();

        $optionGroup = $this->ownedOptionGroup(
            $business,
            $optionGroup
        );

        $this->optionGroupService->update(
            $optionGroup,
            $request->safe()->all()
        );

        return redirect()
            ->route(
                'admin.option-groups.edit',
                $optionGroup
            )
            ->with(
                'success',
                'Grupo de opções atualizado com sucesso.'
            );
    }

    /**
     * @throws Throwable
     */
    public function destroy(
        OptionGroup $optionGroup
    ): RedirectResponse {
        $business = $this->currentBusiness();

        $optionGroup = $this->ownedOptionGroup(
            $business,
            $optionGroup
        );

        $this->optionGroupService->delete(
            $optionGroup
        );

        return redirect()
            ->route('admin.option-groups.index')
            ->with(
                'success',
                'Grupo de opções excluído com sucesso.'
            );
    }

    public function toggleStatus(
        OptionGroup $optionGroup
    ): RedirectResponse {
        $business = $this->currentBusiness();

        $optionGroup = $this->ownedOptionGroup(
            $business,
            $optionGroup
        );

        $optionGroup = $this->optionGroupService
            ->toggleStatus($optionGroup);

        $message = $optionGroup->is_active
            ? 'Grupo de opções ativado com sucesso.'
            : 'Grupo de opções desativado com sucesso.';

        return back()->with(
            'success',
            $message
        );
    }

    private function ownedOptionGroup(
        Business $business,
        OptionGroup $optionGroup
    ): OptionGroup {
        abort_unless(
            $optionGroup->business_id === $business->id,
            404
        );

        return $optionGroup;
    }
}