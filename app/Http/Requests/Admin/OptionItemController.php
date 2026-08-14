<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreOptionItemRequest;
use App\Http\Requests\Admin\UpdateOptionItemRequest;
use App\Models\Business;
use App\Models\OptionGroup;
use App\Models\OptionItem;
use App\Services\OptionItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class OptionItemController extends BaseAdminController
{
    public function __construct(
        private readonly OptionItemService $optionItemService
    ) {
    }

    public function index(
        Request $request,
        OptionGroup $optionGroup
    ): View {
        $business = $this->currentBusiness();

        $optionGroup = $this->ownedOptionGroup(
            $business,
            $optionGroup
        );

        $search = trim(
            (string) $request->input('search')
        );

        $status = (string) $request->input('status');

        $items = $optionGroup->items()
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
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.option-groups.items.index',
            compact(
                'optionGroup',
                'items',
                'search',
                'status'
            )
        );
    }

    public function create(
        OptionGroup $optionGroup
    ): View {
        $business = $this->currentBusiness();

        $optionGroup = $this->ownedOptionGroup(
            $business,
            $optionGroup
        );

        return view(
            'admin.option-groups.items.create',
            compact('optionGroup')
        );
    }

    /**
     * @throws Throwable
     */
    public function store(
        StoreOptionItemRequest $request,
        OptionGroup $optionGroup
    ): RedirectResponse {
        $business = $this->currentBusiness();

        $optionGroup = $this->ownedOptionGroup(
            $business,
            $optionGroup
        );

        $this->optionItemService->create(
            $optionGroup,
            $request->safe()->all()
        );

        return redirect()
            ->route(
                'admin.option-groups.items.index',
                $optionGroup
            )
            ->with(
                'success',
                'Item cadastrado com sucesso.'
            );
    }

    public function edit(
        OptionGroup $optionGroup,
        OptionItem $optionItem
    ): View {
        $business = $this->currentBusiness();

        $optionGroup = $this->ownedOptionGroup(
            $business,
            $optionGroup
        );

        $optionItem = $this->ownedOptionItem(
            $optionGroup,
            $optionItem
        );

        return view(
            'admin.option-groups.items.edit',
            compact(
                'optionGroup',
                'optionItem'
            )
        );
    }

    /**
     * @throws Throwable
     */
    public function update(
        UpdateOptionItemRequest $request,
        OptionGroup $optionGroup,
        OptionItem $optionItem
    ): RedirectResponse {
        $business = $this->currentBusiness();

        $optionGroup = $this->ownedOptionGroup(
            $business,
            $optionGroup
        );

        $optionItem = $this->ownedOptionItem(
            $optionGroup,
            $optionItem
        );

        $this->optionItemService->update(
            $optionItem,
            $request->safe()->all()
        );

        return redirect()
            ->route(
                'admin.option-groups.items.index',
                $optionGroup
            )
            ->with(
                'success',
                'Item atualizado com sucesso.'
            );
    }

    public function destroy(
        OptionGroup $optionGroup,
        OptionItem $optionItem
    ): RedirectResponse {
        $business = $this->currentBusiness();

        $optionGroup = $this->ownedOptionGroup(
            $business,
            $optionGroup
        );

        $optionItem = $this->ownedOptionItem(
            $optionGroup,
            $optionItem
        );

        $this->optionItemService->delete(
            $optionItem
        );

        return back()->with(
            'success',
            'Item excluído com sucesso.'
        );
    }

    public function toggleStatus(
        OptionGroup $optionGroup,
        OptionItem $optionItem
    ): RedirectResponse {
        $business = $this->currentBusiness();

        $optionGroup = $this->ownedOptionGroup(
            $business,
            $optionGroup
        );

        $optionItem = $this->ownedOptionItem(
            $optionGroup,
            $optionItem
        );

        $this->optionItemService->toggleStatus(
            $optionItem
        );

        return back()->with(
            'success',
            $optionItem->is_active
                ? 'Item ativado com sucesso.'
                : 'Item desativado com sucesso.'
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

    private function ownedOptionItem(
        OptionGroup $optionGroup,
        OptionItem $optionItem
    ): OptionItem {
        abort_unless(
            $optionItem->option_group_id === $optionGroup->id,
            404
        );

        return $optionItem;
    }
}