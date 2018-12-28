@extends('layouts.master')
@section('title')
    Successful Transaction |  @parent
@endsection
@section('style')
    <style>
        footer{display:none;}
        table tr td{text-align:left}
    </style>
@endsection
@section('body')
<section id="book_items">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 book-cat-header">
                <h4>Your transaction was successful</h4>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="col-sm-6  register-box">
                    <!-- [
                        {"title":"Clinical Pharmacy and Therapeutics","qty":1,"unit_price":2800,"price":2800},
                        {"title":"Davidson Medicine","qty":1,"unit_price":6000,"price":6000},
                        {"grandtotal":8800}] -->
                    <p><strong>Order Details</strong> </p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Copies</th>
                                <th>Unit Price</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                    <?php
                        $orderDetails = json_decode($order->order_details, true);
                        $lastElem =  count($orderDetails)-1;
                        $str = '<tfoot>
                                    <td colspan="4" style="text-align:right">
                                          <strong> Grand Total </strong>'.$orderDetails[$lastElem]['grandtotal'].
                                    '</td>
                                </tfoot>
                                <tbody>';
                   
                        foreach($orderDetails as $item){
                            if(array_key_exists('grandtotal', $item)){
                                    continue;
                            }  
                            $str.='<tr>';
                            foreach($item as $key=>$value){                                                       
                                $str.='<td>'.$value.'</td>';
                            }
                            $str.= '</tr>
                                </tbody>';
                        }
                        echo $str;
                    ?>                                   
                    </table>
                
                </div>
              <!--   <div> 
                    <a class="btn btn-primary">Confirm Order</a>
                </div> -->
            </div>
        </div>
    </div>
</section>
@endsection
