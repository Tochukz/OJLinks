<nav class="nav-bar  navbar-static-top">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-md-2 top-left-menu">
				<div class="navbar-header">
					<a class="navbar-brand" href="{{url('/')}}" >
                         <img src="{{asset('img/logo_trans1.png')}}" />
					</a>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-menu" aria-expanded="false">
						<span class="sr-only">Navigation toggle</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<!-- <span class="glyphicon glyphicon-th-list"> </span> -->
					</button>
				</div>
			</div>
			<div class="col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2">
                <div class="collapse navbar-collapse" id="nav-menu">
                    <ul class="nav navbar-nav">
                        <li>
                            <div class="btn-group" id="btn-notifications">
                                <span class="badge">3</span>
                                <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-exanded="false">
                                    Notifications
                                </button>
                            </div>
                        </li>

                    </ul>
                    <div id="nav-profile" class="btn-group pull-right hidden-xs">
                        <button type="button" class="btn btn-link dropdown-toggle thumbnail" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="img/tochi.jpg" class="img-circle"> 
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Profile </a> </li>
                            <li><a href="settings.php">Setting</a></li>
                            <li role="seperator" class="divider"> </li>
                            <li><a href="#">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
		</div>
	</div>
</nav>
<section>
	<div class="container-fluid">
		<div class="row">
			<div id="side-menu" class="col-sm-3 col-md-2 hidden-xs" >
<!--                data-spy="affix" 	data-offset-top="0"	-->
				<ul class="nav nav-pills nav-stacked">
					<li class="active" id="overview">
						<a href="{{url('/admin')}}" class="transition">
							<span class="glyphicon glyphicon-home" aria-hidden="true"> </span> Overview
						</a>
					</li>
					<li id="category">
						<a href="#categories" class="transition" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="categories">
							<span class="glyphicon glyphicon-list-alt" aria-hidden="true"> </span> Categories <span class="glyphicon glyphicon-menu-left transition pull-right"></span>
						</a>
                        <ul class="collapse list-unstyled" id="categories">
							<li><a href="{{url('admin/category/medicine')}}" class="transition">Medicine</a></li>
							<li><a href="{{url('admin/category/pharmacy')}}" class="transition">Pharmacy</a></li>
                            <li><a href="{{url('admin/category/engineering')}}" class="transition">Enginerring</a></li>
							<li><a href="{{url('admin/category/physical-science')}}" class="transition">Physical Science</a></li>
                            <li><a href="{{url('admin/category/life-science')}}" class="transition">Life Science</a></li>
							<li><a href="{{url('admin/category/agric-science')}}" class="transition">Agric. Science</a></li>
                            <li><a href="{{url('admin/category/law')}}" class="transition">Law</a></li>
							<li><a href="{{url('admin/category/art')}}" class="transition">Art</a></li>
						</ul>
					</li>
					<li id="managebook">
						<a href="#books" class="transition" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="books" >
							<span class="glyphicon glyphicon-cog" aria-hidden="true"> </span> Manage books
							<span class="glyphicon glyphicon-menu-left transition pull-right" aria-hidden="true"> </span>
						</a>
						<ul class="collapse list-unstyled" id="books">
							<li><a href="{{url('admin/managebook/add')}}" class="transition">Add new</a></li>
							<li><a href="{{url('admin/managebook/update')}}" class="transition">Update old</a></li>

						</ul>
					</li>
					<li id="storekeeper">
						<a href="#storekeepers" class="transition" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="storekeppers">
							<span class="glyphicon glyphicon-book" aria-hidden="true"> </span> Store Keepers
							<span class="glyphicon glyphicon-menu-left transition pull-right"></span>
						</a>
                        <ul class="collapse list-unstyled" id="storekeepers">
							<li><a href="#" class="transition">All</a></li>
							<li><a href="#" class="transition">Add</a></li>
                            <li><a href="#" class="transition">Update</a></li>
						</ul>
					</li>
                    <li id="order">
						<a href="#finances-opts" class="transition" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="finances-opts" >
							<span class="glyphicon glyphicon-usd" aria-hidden="true"> </span> Orders
							<span class="glyphicon glyphicon-menu-left transition pull-right" aria-hidden="true"> </span>
						</a>
						<ul class="collapse list-unstyled" id="finances-opts">
							<li><a href="#" class="transition">Pending</a></li>
							<li><a href="#" class="transition">Paid</a></li>
                            <li><a href="#" class="transition">Delivered</a></li>
						</ul>
					</li>
					<li class="nav-divider"> </li>
					<li id="transact">
						<a href="#trans" class="transition" role="button" data-toggle="collapse" aria-exanded="false" aria-controls="trans">
							<span class="glyphicon glyphicon-folder-close"></span> Transactions
							<span class="glyphicon glyphicon-menu-left transition pull-right"> </span>
						</a>
						<ul class="list-unstyled collapse" id="trans">
							<li><a href="#" class="transition">All</a></li>
						</ul>
					</li>
				</ul>

			</div>
			<div id="main" class="col-sm-9 col-md-10  col-sm-offset-3 col-md-offset-2">
				@yield('content');
			</div>
		</div>
	</div>
</section>
