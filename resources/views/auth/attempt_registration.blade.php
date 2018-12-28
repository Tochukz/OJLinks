@extends('layouts.master')
@section('title')
    Attemp |  @parent
@endsection
@section('style')
    <style>
        footer{display:none;}
    </style>
@endsection
@section('body')
<section id="book_items">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 book-cat-header">
                <h4>Login</h4>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="col-sm-6  register-box">
                    <p>An email will be sent to you inbox at <em>{{$email}}</em> please click on the link provided to activate your account. Or copy the link to you browser address bar.</p>              
                
                </div>
              <!--   <div> 
                    <a class="btn btn-primary">Confirm Order</a>
                </div> -->
            </div>
        </div>
    </div>
</section>
@endsection
