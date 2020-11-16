<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;

class OrderController extends Controller
{
    
    public function index()
    {
        $orders=Order::all();
        return view('order.index',compact('orders'));
    }

    
    public function create()
    {
        $items=Item::all();
        return view('order.form',compact('items'));
    }

    
    public function store(Request $request)
    {
        $order=Order::create([
            'user_id'=>1,
            'customer_name'=>$request->customer_name,
            'total'=>$request->total,
        ]);

        for ($i=0; $i < count($request->item_id); $i++) { 
            $order->order_details()->create([
                'item_id'=>$request->item_id[$i],
                'qty'=>$request->qty[$i],
                'price'=>$request->price[$i],
                'subtotal'=>$request->subtotal[$i],
            ]);
        }

        return redirect(route('order.index'));
    }

  
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $order=Order::with('order_details')->findOrFail($id);
        $items=Item::all();
        // dd($order->toArray());
        return view('order.form',compact('order','items'));
    }


    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->order_details()->delete();

        $order->update([
            'customer_name'=>$request->customer_name,
            'total'=>$request->total,
        ]);

        for ($i=0; $i < count($request->item_id); $i++) { 
            $order->order_details()->create([
                'item_id'=>$request->item_id[$i],
                'qty'=>$request->qty[$i],
                'price'=>$request->price[$i],
                'subtotal'=>$request->subtotal[$i],
            ]);
        }

        return redirect(route('order.index'));
    }


    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->order_details()->delete();
        $order->delete();

        return redirect(route('order.index'));
    }
}
