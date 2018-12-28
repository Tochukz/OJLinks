@extends('layouts.master')
@section('title')
    Welcome  @parent
@endsection
@section('body')
<section class="hidden-xs nav_banner">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="col-sm-2 nav-col">
					<ul class="list-unstyled" id="nav_col">						
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
						  <div id="slider" class="carousel slide" data-ride="carousel" >
		                      <!-- Indicators -->
		                      <ol class="carousel-indicators">
		                        <li data-target="#slider" data-slide-to="0" class="active"></li>
		                        <li data-target="#slider" data-slide-to="1"></li>
		                        <li data-target="#slider" data-slide-to="2"></li>
		                       <!--  <li data-target="#slider" data-slide-to="3"></li -->
		                      </ol>

		                      <!-- Wrapper for slides -->
		                      <div class="carousel-inner" role="listbox">
		                        <div class="item active">
		                        	<img src="img/books5k.jpg" alt="More than 5000 books..." class="img-responsive"/> 	                      
		                        </div>
		                        <div class="item">
		                        	<img src="img/prof_books.jpg" alt="Professional Books" class="img-responsive"/>	                           
		                        </div>

		                        <div class="item">
		                        	<img src="img/all_books.jpg" alt="Books for all ages" class="img-responsive"/>	                           
		                        </div>	                   
		                      </div>

		                      <!-- Left and right controls -->
		                      <a class="left carousel-control" href="#slider" role="button" data-slide="prev">
		                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		                        <span class="sr-only">Previous</span>
		                      </a>
		                      <a class="right carousel-control" href="#slider" role="button" data-slide="next">
		                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		                        <span class="sr-only">Next</span>
		                      </a>
	                    </div>
                  	</div>					
				</div>

			</div>
		</div>

	</div>
</section>
<section id="test_section">
	<!-- <button class="btn btn-default" id="test_json">Test JSON </button>
	<button class="btn btn-default" id="test_build">Build </button> -->
</section>

<section id="book_items">
	<div class="container">
		<div class="row">
			
		</div>
	</div>
</section> 
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<p class="text-center">
                <a href="#" class="more-content" aria-hidden="true" id="load_more" onclick="loadMoreBooks(); return false">
                    <span>More Books</span>
                    <span class="rotate-90">&raquo;</span> 
                </a>
            </p>
		</div>
	</div>
</div>
@endsection