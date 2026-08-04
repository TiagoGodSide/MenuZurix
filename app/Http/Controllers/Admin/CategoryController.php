<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;
use App\Models\Business;



class CategoryController extends BaseAdminController
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {
    }

    public function index(Request $request): View
{
    $business = $this->currentBusiness();

    $search = trim(
        (string) $request->string('search')
    );

    $status = $request->string('status')->toString();

    $categories = Category::query()
        ->where('business_id', $business->id)
        ->when(
            $search !== '',
            fn ($query) => $query->where(
                fn ($subquery) => $subquery
                    ->where('name', 'like', "%{$search}%")
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
        ->ordered()
        ->paginate(10)
        ->withQueryString();

    return view(
        'admin.categories.index',
        compact('categories', 'search', 'status')
    );
}
    public function create(): View
    {
        return view('admin.categories.create');
    }

   /**
 * @throws Throwable
 */
        public function store(
            StoreCategoryRequest $request
        ): RedirectResponse {
            $business = $this->currentBusiness();

            $data = $request->safe()->except('banner_image');

            $data['business_id'] = $business->id;

            $this->categoryService->create(
                $data,
                $request->file('banner_image')
            );

            return redirect()
                ->route('admin.categories.index')
                ->with(
                    'success',
                    'Categoria cadastrada com sucesso.'
                );
        }

        public function edit(Category $category): View
        {
            $business = $this->currentBusiness();

            $category = $this->ownedCategory(
                $business,
                $category
            );

            return view(
                'admin.categories.edit',
                compact('category')
            );
        }

    /**
 * @throws Throwable
 */
/**
 * @throws Throwable
 */
    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ): RedirectResponse {
        $business = $this->currentBusiness();

        $category = $this->ownedCategory(
            $business,
            $category
        );

        $this->categoryService->update(
            $category,
            $request->safe()->except('banner_image'),
            $request->file('banner_image')
        );

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Categoria atualizada com sucesso.'
            );
    }


        /**
         * @throws Throwable
         */
        public function destroy(
            Category $category
        ): RedirectResponse {
            $business = $this->currentBusiness();

            $category = $this->ownedCategory(
                $business,
                $category
            );

            try {
                $this->categoryService->delete($category);

                return redirect()
                    ->route('admin.categories.index')
                    ->with(
                        'success',
                        'Categoria excluída com sucesso.'
                    );
            } catch (Throwable $exception) {
                report($exception);

                return back()->with(
                    'error',
                    'Não foi possível excluir a categoria.'
                );
            }
        }

        public function toggleStatus(
            Category $category
        ): RedirectResponse {
            $business = $this->currentBusiness();

            $category = $this->ownedCategory(
                $business,
                $category
            );

            $category = $this->categoryService
                ->toggleStatus($category);

            $message = $category->is_active
                ? 'Categoria ativada com sucesso.'
                : 'Categoria desativada com sucesso.';

            return back()->with('success', $message);
        }

        
    private function ownedCategory(
        Business $business,
        Category $category
    ): Category {
        abort_unless(
            $category->business_id === $business->id,
            404
        );

        return $category;
    }
}