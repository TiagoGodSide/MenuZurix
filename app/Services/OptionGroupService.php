<?php

namespace App\Services;

use App\Models\Business;
use App\Models\OptionGroup;
use Illuminate\Support\Facades\DB;
use Throwable;

class OptionGroupService
{
    /**
     * @throws Throwable
     */
    public function create(
        Business $business,
        array $data
    ): OptionGroup {
        return DB::transaction(function () use (
            $business,
            $data
        ): OptionGroup {
            $data['business_id'] = $business->id;

            return OptionGroup::create($data);
        });
    }

    /**
     * @throws Throwable
     */
    public function update(
        OptionGroup $optionGroup,
        array $data
    ): OptionGroup {
        return DB::transaction(function () use (
            $optionGroup,
            $data
        ): OptionGroup {
            $optionGroup->update($data);

            return $optionGroup->refresh();
        });
    }

    /**
     * Exclui o grupo de opções.
     *
     * Os itens e vínculos com produtos serão removidos
     * conforme as regras de cascade definidas no banco.
     *
     * @throws Throwable
     */
    public function delete(OptionGroup $optionGroup): void
    {
        DB::transaction(function () use ($optionGroup): void {
            $optionGroup->delete();
        });
    }

    /**
     * Ativa ou desativa o grupo de opções.
     */
    public function toggleStatus(
        OptionGroup $optionGroup
    ): OptionGroup {
        $optionGroup->update([
            'is_active' => ! $optionGroup->is_active,
        ]);

        return $optionGroup->refresh();
    }
}