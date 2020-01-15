<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Jobs\OrderEmail;
use App\Mail\OrderShipped;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:api');
  }

  public function index()
  {
      $orders = auth()->user()->orders()->with('products')->latest()->paginate(10);

      return OrderResource::collection($orders);
  }

  public function store(OrderRequest $request, Cart $cart)
  {
      $type = $request->type;
      $subtotal = $type == 'buy' ? $cart->totalBuy() : $cart->totalSell();

      $order = $request->user()->orders()->create([
        'subtotal' => $subtotal,
        'serial' => (string) Str::uuid(),
        'type' => $type,
        'method' => $request->method,
        'currency' => $cart->currency()
      ]);

      $this->syncOrderWithProduct($cart->products($type), $order);

      return new OrderResource($order);
  }

  public function update(Order $order, Cart $cart)
  {
      $order->update([
        'status' => request()->status
      ]);

      Mail::to(auth()->user())->send(new OrderShipped($order));

      $cart->destroy(request()->type);

      return 200;
  }

  protected function syncOrderWithProduct($products, $order)
  {
      $product = $products->keyBy('id')->map(function ($product) {
        return [
          'quantity' => $product->pivot->quantity,
          'price' => $product->pivot->price,
          'type' => $product->pivot->type
        ];
      })->toArray();

      $order->products()->sync($product);
  }
}
