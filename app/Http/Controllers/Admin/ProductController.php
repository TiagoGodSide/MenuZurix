<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Business;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class ProductController extends BaseAdminController
{
    public function __construct(
        private readonly ProductService $productService
    ) {
    }

    public function index(Request $request): View
    {
        $business = $this->currentBusiness();

        $search = trim((string) $request->input('search'));
        $categoryId = $request->integer('category_id');
        $status = (string) $request->input('status');
        $featured = (string) $request->input('featured');
        $promotion = (string) $request->input('promotion');

        $products = Product::query()
            ->where('business_id', $business->id)
            ->with([
                'category',
                'primaryImage',
            ])
            ->when(
                $search !== '',
                fn ($query) => $query->where(
                    fn ($subquery) => $subquery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhere(
                            'short_description',
                            'like',
                            "%{$search}%"
                        )
                )
            )
            ->when(
                $categoryId > 0,
                fn ($query) => $query->where(
                    'category_id',
                    $categoryId
                )
            )
            ->when(
                $status === 'active',
                fn ($query) => $query->where('is_active', true)
            )
            ->when(
                $status === 'inactive',
                fn ($query) => $query->where('is_active', false)
            )
            ->when(
                $status === 'available',
                fn ($query) => $query
                    ->where('is_available', true)
                    ->where('is_sold_out', false)
            )
            ->when(
                $status === 'sold_out',
                fn ($query) => $query->where('is_sold_out', true)
            )
            ->when(
                $featured === 'yes',
                fn ($query) => $query->where('is_featured', true)
            )
            ->when(
                $promotion === 'yes',
                fn ($query) => $query
                    ->whereNotNull('promotional_price')
                    ->whereColumn('promotional_price', '<', 'price')
            )
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->where('business_id', $business->id)
            ->ordered()
            ->get();

        return view('admin.products.index', compact(
            'products',
            'categories',
            'search',
            'categoryId',
            'status',
            'featured',
            'promotion'
        ));
    }

    public function create(): View
    {
        $business = $this->currentBusiness();

        $categories = Category::query()
            ->where('business_id', $business->id)
            ->active()
            ->ordered()
            ->get();

        return view(
            'admin.products.create',
            compact('categories')
        );
    }

    /**
     * @throws Throwable
     */
    public function store(
        StoreProductRequest $request
    ): RedirectResponse {
        $business = $this->currentBusiness();

        $product = $this->productService->create(
            $business,
            $request->safe()->except('images'),
            $request->file('images', [])
        );

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Produto cadastrado com sucesso.');
    }

    public function edit(Product $product): View
    {
        $business = $this->currentBusiness();
        $product = $this->ownedProduct($business, $product);

        $product->load([
            'category',
            'images',
            'optionGroups',
        ]);

        $categories = Category::query()
            ->where('business_id', $business->id)
            ->active()
            ->ordered()
            ->get();

        return view(
            'admin.products.edit',
            compact('product', 'categories')
        );
    }

    /**
     * @throws Throwable
     */
    public function update(
        UpdateProductRequest $request,
        Product $product
    ): RedirectResponse {
        $business = $this->currentBusiness();
        $product = $this->ownedProduct($business, $product);

        $this->productService->update(
            $product,
            $request->safe()->except('images'),
            $request->file('images', [])
        );

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(
        Product $product
    ): RedirectResponse {
        $business = $this->currentBusiness();
        $product = $this->ownedProduct($business, $product);

        $this->productService->delete($product);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produto arquivado com sucesso.');
    }

    public function toggleStatus(
        Product $product
    ): RedirectResponse {
        $business = $this->currentBusiness();
        $product = $this->ownedProduct($business, $product);

        $product = $this->productService
            ->toggleStatus($product);

        return back()->with(
            'success',
            $product->is_active
                ? 'Produto ativado com sucesso.'
                : 'Produto desativado com sucesso.'
        );
    }

    public function toggleAvailability(
        Product $product
    ): RedirectResponse {
        $business = $this->currentBusiness();
        $product = $this->ownedProduct($business, $product);

        $product = $this->productService
            ->toggleAvailability($product);

        return back()->with(
            'success',
            $product->is_available
                ? 'Produto disponibilizado para venda.'
                : 'Produto indisponível para venda.'
        );
    }

    public function toggleSoldOut(
        Product $product
    ): RedirectResponse {
        $business = $this->currentBusiness();
        $product = $this->ownedProduct($business, $product);

        $product = $this->productService
            ->toggleSoldOut($product);

        return back()->with(
            'success',
            $product->is_sold_out
                ? 'Produto marcado como esgotado.'
                : 'Produto disponível novamente.'
        );
    }

    /**
     * @throws Throwable
     */
    public function duplicate(
        Product $product
    ): RedirectResponse {
        $business = $this->currentBusiness();
        $product = $this->ownedProduct($business, $product);

        $copy = $this->productService->duplicate($product);

        return redirect()
            ->route('admin.products.edit', $copy)
            ->with(
                'success',
                'Produto duplicado. Revise os dados antes de ativá-lo.'
            );
    }

    /**
     * @throws Throwable
     */
    public function destroyImage(
        Product $product,
        ProductImage $image
    ): RedirectResponse {
        $business = $this->currentBusiness();
        $product = $this->ownedProduct($business, $product);

        $this->productService->deleteImage(
            $product,
            $image
        );

        return back()->with(
            'success',
            'Imagem excluída com sucesso.'
        );
    }

    public function setPrimaryImage(
        Product $product,
        ProductImage $image
    ): RedirectResponse {
        $business = $this->currentBusiness();
        $product = $this->ownedProduct($business, $product);

        $this->productService->setPrimaryImage(
            $product,
            $image
        );

        return back()->with(
            'success',
            'Imagem principal atualizada.'
        );
    }

    
    private function ownedProduct(
        Business $business,
        Product $product
    ): Product {
        abort_unless(
            $product->business_id === $business->id,
            404
        );

        return $product;
    }
}