<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function testCreateTransaction()
    {
        // Dummy user
        $user = (object) [
            'name'  => 'John Doe',
            'email' => 'john@example.com',
        ];

        // Dummy products
        $product1 = (object) [
            'id'   => 1,
            'name' => 'Product A',
        ];
        $product2 = (object) [
            'id'   => 2,
            'name' => 'Product B',
        ];

        // Dummy order details
        $orderDetail1 = (object) [
            'product_id' => 1,
            'price'      => 50000,
            'quantity'   => 2,
            'product'    => $product1,
        ];
        $orderDetail2 = (object) [
            'product_id' => 2,
            'price'      => 75000,
            'quantity'   => 1,
            'product'    => $product2,
        ];

        // Dummy order
        $order = (object) [
            'id'             => 101,
            'invoice_number' => 'INV-20250819001',
            'gross_amount'   => 175000, // (50000*2 + 75000*1)
            'user'           => $user,
            'orderDetails'   => [$orderDetail1, $orderDetail2],
            'payments'       => collect([]), // kosong dulu biar masuk ke if
        ];

        $payment = $order->payments->last();
        $snap_token = '';

        if ($payment == null || $payment->status != 'paid') {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

            $transaction_details = array(
                'order_id'      => $order->invoice_number,
                'gross_amount'  => $order->gross_amount,
            );

            $customer_details = array(
                'first_name' => $order->user->name,
                'last_name'  => "",
                'email'      => $order->user->email,
                'phone'      => "",
            );

            $item_details = [];
            foreach ($order->orderDetails as $detail) {
                $item_details[] = [
                    'id'       => $detail->product_id,
                    'price'    => $detail->price,
                    'quantity' => $detail->quantity,
                    'name'     => $detail->product->name,
                ];
            }

            $transaction = array(
                'transaction_details' => $transaction_details,
                'customer_details'    => $customer_details,
                'item_details'        => $item_details,
            );

            try {
                $snap_token = \Midtrans\Snap::getSnapToken($transaction);
                return response()->json(['snap_token' => $snap_token]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
