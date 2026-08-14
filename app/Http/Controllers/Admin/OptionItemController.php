<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreOptionItemRequest;
use App\Http\Requests\Admin\UpdateOptionItemRequest;
use App\Models\OptionGroup;
use App\Models\OptionItem;
use App\Services\OptionItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

        abort_unless(
            $optionGroup->business_id === $business->id,
            404
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

        abort_unless(
            $optionGroup->business_id === $business->id,
            404
        );

        return view(
            'admin.option-groups.items.create',
            compact('optionGroup')
        );
    }

    public function store(
        StoreOptionItemRequest $request,
        OptionGroup $optionGroup
    ): RedirectResponse {
        $business = $this->currentBusiness();

        abort_unless(
            $optionGroup->business_id === $business->id,
            404
        );

        $this->optionItemService->create(
            $optionGroup,
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.option-groups.items.index',
                $optionGroup
            )
            ->with(
                'success',
                'Item de opção cadastrado com sucesso.'
            );
    }

    public function edit(
        OptionGroup $optionGroup,
        OptionItem $optionItem
    ): View {
        $business = $this->currentBusiness();

        abort_unless(
            $optionGroup->business_id === $business->id,
            404
        );

        abort_unless(
            $optionItem->option_group_id === $optionGroup->id,
            404
        );

        return view(
            'admin.option-groups.items.edit',
            compact(
                'optionGroup',
                'optionItem'
            )
        );
    }

    public function update(
        UpdateOptionItemRequest $request,
        OptionGroup $optionGroup,
        OptionItem $optionItem
    ): RedirectResponse {
        $business = $this->currentBusiness();

        abort_unless(
            $optionGroup->business_id === $business->id,
            404
        );

        abort_unless(
            $optionItem->option_group_id === $optionGroup->id,
            404
        );

        $this->optionItemService->update(
            $optionItem,
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.option-groups.items.index',
                $optionGroup
            )
            ->with(
                'success',
                'Item de opção atualizado com sucesso.'
            );
    }

    public function destroy(
        OptionGroup $optionGroup,
        OptionItem $optionItem
    ): RedirectResponse {
        $business = $this->currentBusiness();

        abort_unless(
            $optionGroup->business_id === $business->id,
            404
        );

        abort_unless(
            $optionItem->option_group_id === $optionGroup->id,
            404
        );

        $this->optionItemService->delete(
            $optionItem
        );

        return redirect()
            ->route(
                'admin.option-groups.items.index',
                $optionGroup
            )
            ->with(
                'success',
                'Item de opção excluído com sucesso.'
            );
    }

    public function toggleStatus(
        OptionGroup $optionGroup,
        OptionItem $optionItem
    ): RedirectResponse {
        $business = $this->currentBusiness();

        abort_unless(
            $optionGroup->business_id === $business->id,
            404
        );

        abort_unless(
            $optionItem->option_group_id === $optionGroup->id,
            404
        );

        $this->optionItemService->toggleStatus(
            $optionItem
        );

        return redirect()
            ->route(
                'admin.option-groups.items.index',
                $optionGroup
            )
            ->with(
                'success',
                'Status do item atualizado com sucesso.'
            );
    }
}