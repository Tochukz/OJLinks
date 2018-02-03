<?php
namespace Ojlinks\Http\Controllers;
use Illuminate\Http\Request;

use Ojlinks\Book;
/**
 * CartController handles all shopping cart operations.
 *
 * @author Tochi
 */
class CartController Extends Controller
{
    /**
     * Adds a selected book to the shopping cart.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response 
     */
    public function addToCart($id)
    {
        if (session('cart') === null) {
            session(['cart'=>[]]);
        } 
        $cart = session('cart');
        foreach ($cart as & $book) {
            if (in_array($id, $book)) {           
                $book['copies'] += 1;            
                $book['price'] =  $book['copies'] * $book['unit_price'] ;
                session(['cart'=>$cart]);
                $cart_new = session('cart');         
                return response()->json($cart_new);
            }
        }
        $bookInfo = Book::findOrFail($id);
        array_push($cart, [  'id'=>$bookInfo->id,  'title'=>$bookInfo->title, 'author'=>$bookInfo->author,  'edition'=>$bookInfo->edition,
                                    'price'=>$bookInfo->price, 'unit_price'=>$bookInfo->price,  'category'=>$bookInfo->category,
                                    'subcategory'=>$bookInfo->subcategory, 'img'=>$bookInfo->img, 'copies'=>1,
                                 ] );
         session(['cart'=>$cart]);
         $cart_new  = session('cart');
         return response()->json($cart_new);
       
     }
    
     /**
      * Updates the shopping cart when the user adds, removes or change number of books in the shopping carts.
      * 
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\Response
      */
    public function updateCart(Request $request)
    {
        $id = $request->input('id');
        $copies = $request->input('copies');
        if ($copies == 0) {
        return $this->deleteCart($id);
        }
        $cart = session('cart');
        foreach ($cart as & $book) {
            if (in_array($id, $book)) {
                $book['copies'] =  $copies;
                $book['price'] =  $book['copies']*$book['unit_price'] ;
                session(['cart'=>$cart]);
                $cart_new = session('cart');
                return response()->json($cart_new);
            }
        }
        return response()->json(['status'=>'empty']);
    }
    
    /**
     * Fetch the data from shopping cart and return to client.
     * The client uses this to update it's shopping cart display each time there is a page reload.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getCart()
    {
        if (session('cart')===null) {
            session(['cart'=>[]]);
        } 
        $cart= session('cart');
        return response()->json($cart);
    }
    
    /**
     * Empties the content of the shopping cart.
     * 
     * @return \Illuminate\Http\response
     */
    public function emptyCart()
    {
        session(['cart'=>[]]);
        $cart_new  = session('cart');
        return response()->json($cart_new);
    }
    
    /**
     * Removes a specified book, whose id is supplied, from the shopping cart
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCart($id)
    {
        $cart = session('cart');
        $i = 0;
        foreach ($cart as $book) {
            if ($book['id'] == $id) {
            array_splice($cart, $i, 1);
            }
            $i++;
        }
        session(['cart'=>$cart]);
        $cart_new = session('cart');
        return response()->json($cart_new);
    }
    
    /**
     * Displays the checkout page to the user.
     * 
     * @return \Illuminate\View\View
     */
    public function checkout()
    {
        $cart = [];
        if (session('cart')!==null || !empty(session('cart'))) {
            $cart = session('cart');
         }
         $grandTotal = 0;
         foreach ($cart as $book) {
            $price = (float) $book['price'];
            $grandTotal+=$price;
         }
         return view('checkout')->with(['cart'=>$cart, 'grandTotal'=>$grandTotal]);
    }
}
