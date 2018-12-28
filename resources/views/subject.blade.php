@extends('layouts.master')
@section('title')
    {{ $subject.' | '.$field  }} @parent
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages.css')}}" />
@endsection
@section('body')
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-2  nav-col hidden-xs">
                    <ul class="list-unstyled">
                        <li><a href="{{ url('medicine') }}">Medicine</a></li>
                        <li><a href="{{ url('pharmacy') }}">Pharmacy</a></li>
                        <li><a href="{{ url('engineering') }}">Engineering</a></li>
                        <li><a href="{{ url('physical-science') }}">Physical Science</a></li>
                        <li><a href="{{ url('life-science') }}">Life Science</a></li>
                        <li><a href="{{ url('agric-science') }}">Agric. Science</a></li>
                        <li><a href="{{ url('social-science') }}">Social Science</a></li>
                        <li><a href="{{ url('law') }}">Law</a></li>
                        <li><a href="{{ url('art') }}">Art</a></li>
                    </ul>
                </div>
                <div class="col-sm-10">
                    <div>

                         <div class="col-sm-12 book-cat-header">
                            <h4><a href="{{ url($field)}}"> {{ str_replace('-', ' ', $field )}} </a>
                                <span class=""> | &nbsp; </span>
            <!--                    <span><a href="#" class="subjects transition" aria-hidden="true" onclick="showSubjects(this); return false"> &raquo;</a></span>-->
                            </h4>
                            <ul class="list-inline list-unstyled dont-hide">
                                <li><a href="{!! $field.'/'.$subject !!}" onclick="return false" class="disabled"> {{ str_replace('-', ' ', $subject)}} </a></li>
                            </ul>
                        </div>

                         @forelse ($books as $book)
                            <div class="col-sm-12 book-record">
                                <div id="{{ $book->id }}" class="col-sm-3">
                                    <img src="{!! asset('storage/book_img/'.$book->img) !!}" title="{{ $book->title }}" alt="{{ $book->title }}" data-toggle="tooltip" onmouseover="showToolTip()" onerror="loadDefaultImage(this)"/>
                                    <p class="price">{{$currency.  number_format($book->price, 0, '', ',') }} </p>
                                    <button class="btn btn-sm" data-bookid="{{$book->id}}" onclick ="addToCart(this)">Add to Cart</button>
                                </div>
                                <div class="col-sm-9">
                                    <h3>{{ $book->title }}</h3>
                                    <p class="by">By {{ $book->author}} </p>
                                    <p class="details">{!!  substr($book->details, 0, stripos($book->details, '</p>')+4) !!}...<a href="{{ url('book/'.$book->id)}}">View Details</a></p>
                                </div>
                            </div>
                        @empty
                            No book found under {{  $subject }}.
                        @endforelse

                    </div>
                    {{$books->links()}}
                </div>

          </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    <?php
       $bookArray = [];
       foreach($books as $book){
            $bookArray[$book->id]=$book;
       }
       echo "var sentBooks= ".json_encode($bookArray); 
    ?>
</script>
@endsection

