<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categories;
use App\Models\Order;
use App\Models\Customers;
use App\Models\OrderDetails;

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
        try{
            $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric',
        ]);

        Product::create($validatedData);

        return redirect()->back()->with('success', 'Product created successfully!');
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Failed to create product: ' . $e->getMessage()]);
        }

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
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric',
        ]);
        $product = Product::findOrFail($request->txtEid);
        $product->update($validatedData);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }





}
