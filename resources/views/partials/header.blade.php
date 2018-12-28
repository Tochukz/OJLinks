
<nav class="navbar navbar-default navbar-static-top visible-xs" id="xs_nav">
	<div class="container">
		<div class="navbar-header">
			<a href="{{ url('')}}" class="navbar-brand"><img src="{{ asset('img/logo_trans1.png') }}" alt="OJ Links BookShop" class="img-responsive"/></a>
			<a href="/cart/checkout">
				<span class="badge cart" id="cart-badge">5</span>
				<img src="{{ asset('img/cart.png') }}" alt="Shopping Cart" class="img-responsive cart-img"/>
			</a>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navmenu" aria-expanded="false"> 
				<span class="sr-only">Navbar Toggle</span>
				<span class="icon-bar"> </span>
				<span class="icon-bar"> </span>
				<span class="icon-bar"> </span>
			</button>
		</div>
		<div  class="text-center">
			@if(auth()->check())
				<p id="xs-welcome">Welcome {{ auth()->user()->firstname}}</p>
			@endif
			<form method="get" action="/book/search" id="search_form">
				<div class="input-group"  id="search_group">
					<input type="search" name="search_phrase" list="search-db" class="form-control" placeholder="Search by title..." id="search_icon_input"/>
					<div class="input-group-addon"><span class="glyphicon glyphicon-search search-btn" id="search_icon"></span></div>
					<!-- <button class="btn btn-warning">Search</button> -->
				</div>
			</form>
		</div>
		<div class="collapse navbar-collapse hidden-md" id="navmenu">
			<ul class="list-unstyled list-inline">
				<li><a href="/cart/checkout" class="btn btn-default btn-sm">Checkout </a></li>	
				@if(auth()->check())
						<?php echo '<li><a href="'.url('/logout').'" class="btn btn-default btn-sm">Logout </a></li> '; ?>
				@else
					<?php echo '<li><a href="'.url('/login').'" class="btn btn-default btn-sm">Login </a></li> <li><a href="'.url('/register').'" class="btn btn-default btn-sm">Register</a></li>'; ?>
				@endif												
				<li><a href="#" class="btn btn-default btn-sm">Help </a></li>					
			</ul>
			<ul class="nav navbar-nav">
				<li><a href="{{ url('medicine') }}" class="btn btn-default btn-sm">Medicine</a></li>
				<li><a href="{{ url('pharmacy') }}" class="btn btn-default btn-sm">Pharmacy</a></li>
				<li><a href="{{ url('engineering') }}" class="btn btn-default btn-sm">Engineering</a></li>
				<li><a href="{{ url('physical-science') }}" class="btn btn-default btn-sm">Physical Science</a></li>
				<li><a href="{{ url('life-science')}}" class="btn btn-default btn-sm">Life Science</a></li>
				<li><a href="{{ url('agric-science') }}" class="btn btn-default btn-sm">Agric. Science</a></li>
				<li><a href="{{ url('social-science') }}" class="btn btn-default btn-sm">Social Science</a></li>
				<li><a href="{{ url('law') }}" class="btn btn-default btn-sm">Law</a></li>
				<li><a href="{{ url('art') }}" class="btn btn-default btn-sm">Art</a></li>
			</ul>
		</div>
	</div>
</nav>
<nav class="navbar navbar-fixed-top navbar-default hidden-xs" id="sm_nav">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="col-sm-12">
					<div id="logo_div">
						<a href="{{ url('')}}"><img src="{{ asset('img/logo_trans1.png') }}" alt="OJ Links BookShop" class="img-responsive" /></a>
						<ul class="list-unstyled list-inline">
							
							@if(auth()->check())
								<?php echo '<li><strong> Welcome '.auth()->user()->firstname.'</strong></li> | <li><a href="'.url('/logout').'">Logout </a></li> |'; ?>
							@else
								<?php echo '<li><a href="'.url('/login').'">Login </a></li> | <li><a href="'.url('/register').'">Register</a></li> |'; ?>
							@endif
							<li><a href="/cart/checkout">Checkout </a></li> |																			
							<li><a href="#">Help </a></li>						
						</ul>
						
					</div>
				</div>
				<div class="col-sm-2">
					<div class="header-bar leftRadius"><h3 class="leftRadius">Categories </h3></div>
				</div>
				<div class="col-sm-8" >
					<div  class="text-center">
						<div  class="header-bar">
							<form method="get" action="/book/search">
								<div class="input-group"  id="search_group">
									<input type="search" name="search_phrase" list="search-db" class="form-control" placeholder="Search by title..." id="search_btn_input"/>
									<datalist id="search-db">
										<!-- <option value="Medicine">
										<option value="Pharmacy">
										<option value="Chemistry"> -->
									</datalist>
									<span class="input-group-btn"><button class="btn btn-warning" id="search_btn">Search</button></span>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="header-bar rightRadius"> 
						<button class="btn btnCart" id="cart_btn" data-toggle="popover" title="shopping cart"> 					
							<span id="cart-book-no"> 0 Book(s) </span> - 
							<span id="cart-price"> - ₦ 0.00 </span>
							<img src="/img/cart.png" />
						</button>
					</div>
					<div id="custom-popover">
						<p class="arrow">&#9650;</p>

						<div class="cart-divs">
							<div class="del"><span title="Delete book" data-toggle="tooltip" onmouseover="showToolTip()">&times;</span></div>
							<div class="col50">				
								<!-- <img src="/img/book_img/1.jpg" title="my book"/> -->						 
							</div>
							<div class="col50">
								<!-- <p class="title">Book title of introduction</p>
								<p class="author">authorname authorsurname </p>
								<p class="copies">2 copies </p> -->
							</div>
						</div>
						<p>
							<button class="btn btn-xs" onclick="emptyCart()">Empty Cart</button>
							<button class="btn btn-xs" onclick="checkOut()">Check out</button>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</nav>
