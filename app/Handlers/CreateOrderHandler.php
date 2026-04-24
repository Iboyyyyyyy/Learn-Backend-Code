<?php

namespace App\Handlers;

// use Illuminate\Support\Str;
// use App\Models\OrderEvent;
use App\Repositories\OrderRepository;
use App\Commands\CreateOrderCommand;
use Illuminate\Support\Facades\DB;


class CreateOrderHandler
{
    protected $orderRepo;


    // public function __construct(OrderRepository $orderRepo)
    // {
    //     $this->orderRepo = $orderRepo;
    // }
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }
    public function handle(CreateOrderCommand $command)
    {
        DB::beginTransaction();

        try {
            $order = $this->orderRepo->createOrder([
                'customer_id' => $command->customerId,
                'order_date' => now(),
                'created_at' => now()
            ]);

            $details = [];

            foreach ($command->orderItems as $item) {
                $details[] = [
                    'order_id'   => $order->order_id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'created_at' => now(),
                ];
            }

            $this->orderRepo->insertDetails($details);

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }




        // try {
        //     $order = $this->orderRepo->createOrder([
        //         'customer_id' => $command->customerId,
        //         'order_date' => now(),
        //         'created_at' => now()
        //     ]);

        //     $details = [];

        //     foreach ($command->orderItems as $item) {
        //         $details[] = [
        //             'order_id'   => $order->order_id,
        //             'product_id' => $item['product_id'],
        //             'quantity'   => $item['quantity'],
        //             'created_at' => now(),
        //         ];
        //     }

        //     $this->orderRepo->insertDetails($details);

        //     DB::commit();
        //     return $order;
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     throw $e;
        // }
    }
}
