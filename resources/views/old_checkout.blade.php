@extends('layouts.master')
@section('title')
    Checkout  @parent
@endsection
@section('body')
<section id="book_items">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 book-cat-header">
                <h4>Summary of order</h4>
            </div>
            <div class="col-md-12 col-sm-12" >
                <div id="cartdiv">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Title</th>
                                <th>Unit Price</th>
                                <th>Units</th>
                                <th>&nbsp;</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <?php
                            /*::::::::::IMPORTANT!!!:::::::::::::::::::::*/
                            /*The display of the summary of the order has been commented out but left for the developer to see the structure of the output.

                            The actual output is handled by Javascript on the client side.

                            This is done to easy handling of the summary display via AJAX should the user decides to remove items from the cart or update item quantity.

                            See the  assembleCheckout() function in public/js/main.js
                            */
                        ?>
                        <tfoot>
                            <?php
                            /*To be handled by JS*/

                            // <tr>
                            //     <td colspan="5"><h4>Grand Total</h4></td>
                            //     <td><h4> {{$currency.  number_format($grandTotal, 0, '', ',') }}</h4></td>
                            // </tr>
                            ?>
                       </tfoot>
                        <tbody>
                        <?php
                            /*To be handled by JS*/

                            // @forelse($cart as $book)
                            //     <tr>
                            //         <td><div><img src="/storage/book_img/{{$book['img']}}"/></div></td>
                            //         <td>{{$book['title']}}</td>
                            //         <td> {{$currency.  number_format($book['unit_price'], 0, '', ',') }}</td>
                            //         <td><input type="text" value="{{$book['copies']}}"  readonly="readonly" onclick="changeState(this)" onchange="changeQuantity(this)" data-bookID="{{$book['id']}}"/> </td>
                            //         <td><button class="btn btn-sm" onclick="askToRemove({{$book['id']}})">Remove</button></td>
                            //         <td>{{$currency.  number_format($book['price'], 0, '', ',') }}</td>
                            //     </tr>
                            // @empty
                            //         Your shopping cart is empty
                            // @endforelse
                        ?>
                        </tbody>
                    </table>


                    <script>
                        // var path = window.location.pathname;
                        // if(path.match(/checkout/i)){
                        //      document.write(path);
                        // }
                    </script>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{url('/payment/process')}}">Confirm Order</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection