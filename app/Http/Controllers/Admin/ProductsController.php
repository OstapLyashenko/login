<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\Contracts\FileStorageServiceContract;
use App\Services\FileStorageService;
use App\Services\ImagesService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Illuminate\Http\Response;

class ProductsController extends Controller
{
    public function __construct(protected ProductRepositoryContract $productRepository) {}
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = Product::with('categories')->paginate(5);
        return view('admin/products/index', compact('products'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin/products/create', compact('categories'));
    }

    /**
     * @param CreateProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(CreateProductRequest $request): RedirectResponse
    {
        if ($product = $this->productRepository->create($request)) {
            return redirect()->route('admin.products.index')->with('status', "The product #{$product->id} was successfully created!");
        } else {
            return redirect()->back()->with('warn', 'Oops smth wrong. See logs')->withInput();
        }
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin/products/edit', compact('product', 'categories'));
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if ($this->productRepository->update($product, $request)) {
            return redirect()->route('admin.products.index')->with('status', "The product #{$product->id} was successfully updated!");
        } else {
            return redirect()->back()->with('warn', 'Oops smth wrong. See logs')->withInput();
        }
    }
}
