<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    private function getCart()
    {
        if (auth('web')->check()) {
            return \App\Models\Cart::firstOrCreate(['user_id' => auth('web')->id()]);
        } else {
            return \App\Models\Cart::firstOrCreate(['session_id' => session()->getId(), 'user_id' => null]);
        }
    }

    public function viewCart()
    {
        $cart = $this->getCart()->load('items.product');
        return view('shop.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $cart = $this->getCart();
        
        $cartItem = \App\Models\CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();
            
        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            \App\Models\CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => 1
            ]);
        }
        
        $url = url()->previous();
        $url = explode('#', $url)[0];
        return redirect()->to($url . '#jendela-dunia')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function buyNow(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $cart = $this->getCart();
        
        // Bersihkan keranjang yang ada lalu tambahkan produk ini saja
        $cart->items()->delete();
        \App\Models\CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'quantity' => 1
        ]);
        
        return redirect()->route('cart.view');
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getCart();
        $cartItem = \App\Models\CartItem::where('cart_id', $cart->id)
            ->where('id', $request->cart_item_id)
            ->firstOrFail();

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['success' => true]);
    }

    public function removeFromCart($id)
    {
        $cart = $this->getCart();
        $cartItem = \App\Models\CartItem::where('cart_id', $cart->id)->where('id', $id)->firstOrFail();
        $cartItem->delete();
        
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $isAuth = auth('web')->check();

        if (!$isAuth) {
            $request->validate([
                'guest_name' => 'required|string|max:255',
                'guest_email' => 'required|email|max:255',
                'guest_phone' => 'required|string|max:20',
            ]);
        }

        $cart = $this->getCart()->load('items.product');
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Keranjang kosong.');
        }

        $selectedItemsIds = $request->input('selected_items', []);
        if (empty($selectedItemsIds)) {
            return redirect()->route('cart.view')->with('error', 'Silakan pilih setidaknya satu produk untuk di-checkout.');
        }

        $itemsToCheckout = $cart->items->whereIn('id', $selectedItemsIds);

        $totalAmount = 0;
        foreach ($itemsToCheckout as $item) {
            $price = $isAuth && $item->product->member_price !== null ? $item->product->member_price : $item->product->price;
            $totalAmount += $price * $item->quantity;
        }

        $order = \App\Models\Order::create([
            'user_id' => $isAuth ? auth('web')->id() : null,
            'guest_name' => $isAuth ? null : $request->guest_name,
            'guest_email' => $isAuth ? null : $request->guest_email,
            'guest_phone' => $isAuth ? null : $request->guest_phone,
            'total_amount' => $totalAmount,
            'status' => 'pending'
        ]);

        foreach ($itemsToCheckout as $item) {
            $price = $isAuth && $item->product->member_price !== null ? $item->product->member_price : $item->product->price;
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $price
            ]);
            // Hapus item yang dicheckout dari keranjang
            $item->delete();
        }

        // Redirect to Mayar if only 1 product and it has a payment_link
        if ($itemsToCheckout->count() == 1) {
            $product = $itemsToCheckout->first()->product;
            if ($product && $product->payment_link) {
                return redirect()->away($product->payment_link);
            }
        }

        // Fallback for multiple products or no payment link
        $waMessage = "Halo Admin Guruverse, saya ingin memproses pesanan dengan Order ID: " . $order->id . "%0ATotal: Rp " . number_format($totalAmount, 0, ',', '.');
        $waLink = "https://wa.me/6281234567890?text=" . $waMessage;
        
        return redirect()->away($waLink);
    }
}
