@extends('layouts.master')
@section('title')
    {{ $book->title }} @parent
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages.css')}}" />
    <style>
        .book-record div:first-child{
            height:26em;
            padding-bottom:0;
        }
        .book-record img{
            width:100%;
            height:auto;
        }
        .table{
           border:none;
        }
        .table tr{
            text-align:left;
            border:none;
        }
        table.table tr:first-child td{
           border:none;
        }
        .table tr td:first-child{
            font-weight:bold;
            width:18%;
        }
        .table tr td:first-child::after{
            content:":";
        }
        .table tr:last-child td:first-child::after{
            content:" ";
        }
        @media(max-width:700px){
            div.details{
            margin:1em 1.8em;
            }
        }
    </style>
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
                            <h4> {{$book->title}}
                                <span class="">  &nbsp; </span>
            <!--                    <span><a href="#" class="subjects transition" aria-hidden="true" onclick="showSubjects(this); return false"> &raquo;</a></span>-->
                            </h4>
                        </div>

                        <div class="col-sm-12 book-record">
                            <div id="{{ $book->id }}" class="col-sm-3">
                                <img src="{!! asset('storage/book_img/'.$book->img) !!}" title="{{ $book->title }}" alt="{{ $book->title }}" data-toggle="tooltip" onmouseover="showToolTip()" onerror="loadDefaultImage(this)"/>
                            </div>
                            <div class="col-sm-9">
                                <table class="table">
                                    <tr>
                                        <td>Title</td>
                                        <td>{{ $book->title}}</td>
                                    </tr>
                                    <tr>
                                        <td>Author</td>
                                        <td>{{ $book->author}}</td>
                                    </tr>
                                    <tr>
                                        <td>Edition</td>
                                        <td>{{$book->edition}}</td>
                                    </tr>
                                    <tr>
                                        <td>Pages</td>
                                        <td>{{$book->pages}}</td>
                                    </tr>
                                    <tr>
                                        <td>Category</td>
                                        <td>{{str_replace('-', ' ', ucfirst($book->category))}} </td>
                                    </tr>
                                    <tr>
                                        <td>Subcategory</td>
                                        <td>{{str_replace('-', ' ', ucfirst($book->subcategory))}} </td>
                                    </tr>
                                    <tr>
                                        <td>Language</td>
                                        <td>English</td>
                                    </tr>
                                    <tr>
                                        <td>Price</td>
                                        <td>{{$currency.  number_format($book->price, 0, '', ',') }} </td>
                                    </tr>
                                    <tr>
                                        <td> </td>
                                        <td><button class="btn btn-sm" data-bookid="{{$book->id}}" onclick ="addToCart(this)">Add to Cart</button>   </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="details">
                            <h4>Book Details</h4>
                                <p>{!!$book->details!!}</p>
                            </div>
                        </div>
                    </div>
                </div>

          </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    var sentBooks = {!! json_encode($bookArray)   !!}
</script>
@endsection
