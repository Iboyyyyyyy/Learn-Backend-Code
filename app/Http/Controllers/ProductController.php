<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Categories;
use App\Models\Order;
use App\Models\Customers;
use App\Models\OrderDetails;
// use App\Models\User;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{

    public function indexView()
    {
        $orders = Order::all();
        $customers = Customers::all();
        $orderDetails = OrderDetails::all();
        $categories = Categories::all();
        $products = Product::paginate(9);
        return view('welcome', compact('products', 'categories', 'orders', 'customers', 'orderDetails'));
    }

    public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric',
            'images' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);


        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);

            $images = 'images/' . $fileName;
        }

        $validatedData['images'] = $images;

        Product::create($validatedData);

        return redirect()->back()->with('success', 'Product created successfully!');


    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to create product: ' . $e->getMessage()
        ]);
    }
}

public function update(Request $request)
{
    $validatedData = $request->validate([
        'product_id' => 'required|integer|exists:products,product_id',
        'product_name' => 'required|string|max:255',
        'category_id' => 'required|integer',
        'unit' => 'required|string|max:50',
        'price' => 'required|numeric',
        'images' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $product = Product::where('product_id', $request->product_id)->first();

    if (!$product) {
        return back()->with('error', 'Product not found');
    }

    // ✅ Handle image
    if ($request->hasFile('images')) {

        // delete old image
        if ($product->images && file_exists(public_path($product->images))) {
            unlink(public_path($product->images));
        }

        $file = $request->file('images');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $fileName);

        $validatedData['images'] = 'images/' . $fileName;
    } else {
        $validatedData['images'] = $product->images;
    }

    // ✅ Update using WHERE (product_id)
    Product::where('product_id', $request->product_id)
        ->update([
            'product_name' => $validatedData['product_name'],
            // 'category_id' => $validatedData['category_id'],
            'unit' => $validatedData['unit'],
            'price' => $validatedData['price'],
            'images' => $validatedData['images']
        ]);

    return back()->with('success', 'Product updated successfully!');
}

    public function search(Request $request)
    {
        $searchTerm = $request->input('product_name');
        $products = Product::where('product_name', 'like', '%' . $searchTerm . '%')->paginate(9);
        $orders = Order::all();
        $customers = Customers::all();
        $orderDetails = OrderDetails::all();
        $categories = Categories::all();
        return view('welcome', compact('products', 'categories', 'orders', 'customers', 'orderDetails'));
    }
    // public function update(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'product_name' => 'required|string|max:255',
    //         'category_id' => 'required|integer',
    //         'unit' => 'required|string|max:50',
    //         'price' => 'required|numeric',
    //     ]);
    //     $product = Product::findOrFail($request->txtEid);
    //     $product->update($validatedData);

    //     return redirect()->back()->with('success', 'Product updated successfully!');
    // }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }





}
