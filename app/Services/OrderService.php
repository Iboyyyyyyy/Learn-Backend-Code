<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\OrderRepository;
// use App\Models\OrderDetails;
use Illuminate\Support\Facades\Log;

class OrderService
{
    protected $orderRepo;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function createOrder($request)
    {
        DB::beginTransaction();

        try{
            $order = $this->orderRepo->createOrder([
                'customer_id' => session('id'),
                'order_date'  => now(),
            ]);

            $deails = [];

            foreach ($request->order_items as $item){
                $deails[] = [
                    'order_id'   => $order->order_id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'created_at' => now(),
                ];
            }

            $this->orderRepo->insertDetails($deails);

            DB::commit();

        // RETURN JSON instead of back()
        return response()->json([
            'success' => true,
            'message' => "Order #{$order->order_id} created successfully!"
        ], 201);

        }catch (\Exception $e){
                DB::rollBack();

        Log::error('Order Process Failed: ' . $e->getMessage());

        // RETURN JSON ERROR
        return response()->json([
            'success' => false,
            'message' => "Transaction Failed: " . $e->getMessage()
        ], 500);
            }
    }
}
