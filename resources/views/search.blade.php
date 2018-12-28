@extends('layouts.master')
@section('title')
    {{ "Search result for ". $search_phrase }} @parent
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
                            <h4 style="text-transform:none"> Search result for
                               <!--  <span class=""> | &nbsp; </span>      -->
                            </h4>
                            <ul class="list-inline list-unstyled dont-hide">
                                 <li><a href="#" style="text-transform:lowercase" onclick="return false" class="disabled"> {{ $search_phrase}} </a></li>
                            </ul>
                        </div>

                         @forelse ($books as $book)
                            <div class="col-sm-12 book-record">
                                <div id="{{ $book->id }}" class="col-sm-3">
                                    <img src="{!! asset('storage/book_img/'.$book->img) !!}" title="{{ $book->title }}" alt="{{ $book->title }}" data-toggle="tooltip" onmouseover="showToolTip()" onerror="loadDefaultImage(this)"/>                                    
                                    <p class="price">{{$currency.  number_format(floatval($book->price), 0, '', ',') }} </p>
                                    <button class="btn btn-sm" data-bookid="{{$book->id}}" onclick ="addToCart(this)">Add to Cart</button>
                                </div>
                                <div class="col-sm-9">
                                    <h3>{{ $book->title }}</h3>
                                    <p class="by">By {{ $book->author}} </p>
                                    <p class="details">{!! substr($book->details, 0, stripos($book->details, '</p>')+4) !!}...<a href="{{ url('book/'.$book->id)}}">View Details</a></p>
                                </div>
                            </div>
                        @empty
                            No book found under {{ $search_phrase }}.
                        @endforelse

                    </div>   
                    {!! $books->appends(['search_phrase='=>trim($search_phrase)])->links()!!}                                
                    <!--  <ul class="pagination"> -->
                        <?php
                            // $str='';
                            // for($x=1; $x<=$no_of_pages; $x++){                                                           
                                // if($x==$current_page){                                    
                                //     if($current_page==1){
                                //        $str .='<li class="disabled"><span>&laquo;</span></li>';
                                //     }
                                //     $str .='<li class="active"><span>$x</span></li>';
                                //     continue;
                                // }
                                // if($x==$no_of_pages){
                                //     $str .='<li class="active"><span>$x</span></li>';
                                //     $str .='<li class="disabled"><span>&laquo;</span></li>';
                                //     continue;
                                // }
                                // $str .='<li><a href="'.url('/search?search_phrase='.$search_phrase.'&page='.$x).'">'.$x.'</a></li>'
                            //}
                            // echo $str;

                        ?>                           
                       
                        <!--  <li><a href="http://ojlinks.dev/physical-science?page=2" rel="prev">&laquo;</a></li>

                        <li><a href="http://ojlinks.dev/physical-science?page=2">2</a></li>
                        <li><a href="http://ojlinks.dev/physical-science?page=3">3</a></li>
                        <li><a href="http://ojlinks.dev/physical-science?page=4">4</a></li>
                        <li><a href="http://ojlinks.dev/physical-science?page=2" rel="next">&raquo;</a></li> -->
                  <!--   </ul>   -->                 
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
       echo "var sentBooks= ".json_encode($bookArray).";"; 
       echo "var search_phrase = '".$search_phrase."';"; 
    ?>
</script>
@endsection
