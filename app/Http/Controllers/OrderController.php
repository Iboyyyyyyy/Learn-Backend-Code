<?php

namespace App\Http\Controllers;

use App\Commands\CreateOrderCommand;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Handlers\CreateOrderHandler;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this ->orderService = $orderService;
    }

    // this code order use logic with service and respository
    // public function store(Request $request)
    // {
    //     return $this->orderService->createOrder($request);
    // }



    public function store(Request $request, CreateOrderHandler $handler)
    {
        try{
            $command = new CreateOrderCommand(
                customerId: session('id'),
                orderItems: $request->order_items
            );

            $order = $handler->handle($command);

            return response()->json([
                'success' => true,
                'message' => "Order #{$order?->order_id} created successfully",
            ], 201);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
         }
    }
}
