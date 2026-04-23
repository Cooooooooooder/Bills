<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // 1. صلاحية العرض
            new Middleware('permission:المنتجات', only: ['index','show']),  ////

            // 2. صلاحية الإضافة
            new Middleware('permission:اضافة منتج', only: ['create', 'store']), ////

            // 3. صلاحية التعديل
            new Middleware('permission:تعديل منتج', only: ['edit', 'update']),

            // 4. صلاحية الحذف
            new Middleware('permission:حذف منتج', only: ['destroy']),   ////

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections::select('id', 'section_name')->get();

        // $products = Product::with('sections')->latest()->get();
        $products = Product::all();
        return view('products.index', compact('products', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product;

        $product->product_name = $request->product_name;
        $product->description = $request->description;
        $product->section_id = $request->section_id;

        $product->save();
        return redirect(route('products.index'))->with('success', 'تم حفظ المنتج بنجاح !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $sections = sections::select('id', 'section_name')->get();
        return view('products.edit', compact('product', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $products = Product::findOrFail($product->id);

        $products->product_name = $request->product_name;
        $products->description = $request->description;
        $products->section_id = $request->section_id;

        $products->save();
        return redirect(route('products.index'))->with('update', 'تم تعدبل المنتج بنجاح !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $products = Product::find($product->id);

        $products->delete();
        return redirect(route('products.index'))->with('delete', 'تم حذف المنتج بنجاح !');
    }
}
