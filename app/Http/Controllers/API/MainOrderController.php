<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetails;
use App\Models\Customers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
// use Symfony\Component\Mime\Message;

// use App\Models\Categories;

class MainOrderController extends Controller
{
    public function getdata()
    {
        $orders = Order::all();
        $orderdetails = OrderDetails::all();
        $customers = Customers::all();


        // Get all product_ids from orderdetails
        $product_ids = $orderdetails->pluck('product_id')->unique();
        $getnamecustomer = $customers->pluck('customer_name', 'customer_id');

        // Get only product names that exist in orderdetails
        $products = Product::whereIn('product_id', $product_ids)->pluck('product_name', 'product_id');
        $productPrices = Product::whereIn('product_id', $product_ids)->pluck('price', 'product_id');
        $final = $orders->map(function ($order) use ($orderdetails, $products, $getnamecustomer, $productPrices) {
            $details = $orderdetails->where('order_id', $order->order_id)->map(function ($detail) use ($products, $productPrices) {
                $product_name = $products->get($detail->product_id);
                $product_price = $productPrices->get($detail->product_id);
                $total_price = $product_price * $detail->quantity;
                return [
                    'product_name' => $product_name,
                    'quantity' => $detail->quantity,
                    'price' => $product_price,
                    'total price' => $total_price
                ];
            });
            return [
                'order_id' => $order->order_id,
                'customer_name' => $getnamecustomer->get($order->customer_id),
                'order_date' => $order->order_date,
                'details' => $details,
            ];
        });

        return response()->json([
            'orders' => $final
        ]);
    }

public function store(Request $request)
{
    // ✅ Validate request
    $request->validate([
        'customer_id' => 'required|exists:customers,customer_id',
        'order_date' => 'nullable|date',
        'details' => 'required|array|min:1',
        'details.*.product_id' => 'required|exists:products,product_id',
        'details.*.quantity' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();

    try {
        // ✅ Create order
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'order_date' => $request->order_date ?? now(),
        ]);

        $orderDetails = [];

        foreach ($request->details as $detail) {

            // ✅ Get product safely
            $product = Product::find($detail['product_id']);

            $orderDetails[] = OrderDetails::create([
                'order_id' => $order->order_id,
                'product_id' => $product->product_id,
                'quantity' => $detail['quantity'],
                'price' => $product->price,
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => [
                'order' => $order,
                'order_details' => $orderDetails,
            ]
        ], 201);

    } catch (\Exception $e) {

        DB::rollBack(); // 🔥 IMPORTANT

        return response()->json([
            'success' => false,
            'message' => 'Failed to create order',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function storeOrder(Request $request)
{
    echo "storeOrder method called";
//     $request->validate([
//         'customer_id' => 'required|exists:customers,customer_id',
//         'product_id'  => 'required|exists:products,product_id',
//         'quantity'    => 'required|integer|min:1',
//     ]);

//     DB::beginTransaction();

//     try {
//         // 1. Create Order
//         $order = Order::create([
//     'customer_id' => $request->customer_id,
//     'order_date' => now(),
// ]);

// $product = Product::findOrFail($request->product_id);

// OrderDetails::create([
//     'order_id' => $order->order_id,
//     'product_id' => $request->product_id,
//     'quantity' => $request->quantity,
//     'price' => $product->price,
// ]);

//         DB::commit();

//         return back()->with('success', 'Order created');

//     } catch (\Exception $e) {
//         DB::rollBack();
//         return back()->with('error', $e->getMessage());
//     }
}
}
