@extends('layouts.master')
@section('title')
    Reset Password  @parent
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
                <h4>Reset Password</h4>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="col-sm-6  register-box">                   
                 <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>                
                </div>
              <!--   <div> 
                    <a class="btn btn-primary">Confirm Order</a>
                </div> -->
            </div>
        </div>
    </div>
</section>
@endsection