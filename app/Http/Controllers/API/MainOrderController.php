<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetails;
use App\Models\Customers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

// use App\Models\Categories;

class MainOrderController extends Controller
{
    public function getdata()
    {
        $orders = Order::all();
        $orderdetails = OrderDetails::all();
        $customers = Customers::all();


        $orders = Order::with(['customer', 'orderDetails.product'])->get();

        $final = $orders->map(function ($order) {
            $details = $order->orderDetails->map(function ($detail) {
                $product_name = $detail->product?->product_name;
                $product_price = $detail->product?->price ?? 0;
                $total_price = $product_price * $detail->quantity;

                return [
                    'product_name' => $product_name,
                    'quantity' => $detail->quantity,
                    'unit_price' => $product_price,
                    'total_price' => $total_price,
                ];
            });

            return [
                'order_id' => $order->order_id,
                'customer_name' => $order->customer?->customer_name,
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
}
