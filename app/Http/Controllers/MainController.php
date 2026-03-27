<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categories;
use App\Models\Order;
use App\Models\Customers;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function indexView()
    {
        $orders = Order::all();
        $customers = Customers::all();
        $orderDetails = OrderDetails::paginate(9);
        $categories = Categories::all();
        $product_lists = Product::all();
        $products = Product::all();
        return view('welcome', compact('products', 'categories', 'orders', 'customers', 'orderDetails', 'product_lists'));
    }


    // public function indexView()
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


    public function storeOrder(Request $request)
{
    $request->validate([
        'customer_id' => 'required|exists:customers,customer_id',
        'product_id'  => 'required|exists:products,product_id',
        'quantity'    => 'required|integer|min:1',
    ]);

    DB::beginTransaction();

    try {
        // 1. Create Order
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'order_date' => now(),
        ]);

        // 2. Get product
        $product = Product::findOrFail($request->product_id);

        // 3. Insert order detail
        OrderDetails::create([
            'order_id' => $order->order_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        DB::commit();

        return back()->with('success', 'Order created');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}
}
