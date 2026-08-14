<?php

namespace App\Services;

use App\Models\OptionGroup;
use App\Models\OptionItem;
use Illuminate\Support\Facades\DB;
use Throwable;

class OptionItemService
{
    /**
     * @throws Throwable
     */
    public function create(
        OptionGroup $optionGroup,
        array $data
    ): OptionItem {
        return DB::transaction(function () use (
            $optionGroup,
            $data
        ): OptionItem {
            $data['option_group_id'] = $optionGroup->id;

            $data['sort_order'] = $data['sort_order'] ?? 0;

            $data['is_default'] = (bool) (
                $data['is_default'] ?? false
            );

            $data['is_active'] = (bool) (
                $data['is_active'] ?? true
            );

            return OptionItem::create($data);
        });
    }

    /**
     * @throws Throwable
     */
    public function update(
        OptionItem $item,
        array $data
    ): OptionItem {
        return DB::transaction(function () use (
            $item,
            $data
        ): OptionItem {
            $data['sort_order'] = $data['sort_order'] ?? 0;

            $data['is_default'] = (bool) (
                $data['is_default'] ?? false
            );

            $data['is_active'] = (bool) (
                $data['is_active'] ?? false
            );

            $item->update($data);

            return $item->refresh();
        });
    }

    public function delete(OptionItem $item): void
    {
        $item->delete();
    }

    public function toggleStatus(
        OptionItem $item
    ): OptionItem {
        $item->update([
            'is_active' => ! $item->is_active,
        ]);

        return $item->refresh();
    }
}