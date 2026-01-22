namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function product()
    {
        $products = Product::all();
        return view('product', compact('products'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);
        $cart[$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'qty' => ($cart[$id]['qty'] ?? 0) + 1
        ];

        session()->put('cart', $cart);

        return redirect('/cart');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        $total = collect($cart)->sum(fn ($item) =>
            $item['price'] * $item['qty']
        );

        Order::create([
            'total_price' => $total,
            'status' => 'paid',
        ]);

        session()->forget('cart');

        return redirect('/');
    }
}
