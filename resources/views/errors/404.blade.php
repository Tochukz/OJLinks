@extends('layouts.master')
@section('title')
    404 Page nout found|  @parent
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
                <h4>Sorry</h4>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="col-sm-6  register-box">
                    <!-- [
                        {"title":"Clinical Pharmacy and Therapeutics","qty":1,"unit_price":2800,"price":2800},
                        {"title":"Davidson Medicine","qty":1,"unit_price":6000,"price":6000},
                        {"grandtotal":8800}] -->
                    <h1>404 Page not found</h1>
                    
                </div>
              <!--   <div> 
                    <a class="btn btn-primary">Confirm Order</a>
                </div> -->
            </div>
        </div>
    </div>
</section>
@endsection
