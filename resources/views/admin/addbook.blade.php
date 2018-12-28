@extends('admin.master')
@section('content')
<div class="col-sm-12">
	<div class="col-sm-6">
        <h3>Add new Book</h3>
		<form action="{{url('/admin/managebook')}}" method="post" enctype="multipart/form-data">
			
			@if($errors->any())
				<div class="alert alert-danger">
					<ul>
					@foreach($errors->all() as $error)
						<li>{{$error}}</li>
					@endforeach
					</ul>
				</div>
			@endif
			
			{{csrf_field()}}
			<div class="form-group">                
				<input type="text" class="form-control"  name="title" placeholder="Title" value="{{old('title')}}"/>
			</div>
			<div class="form-group">
				<input type="text" class="form-control"  name="author" placeholder="Author" value="{{old('author')}}"/>
			</div>
			<div class="form-group">
				<input type="text" class="form-control"  name="edition" placeholder="Edition" value="{{old('edition')}}"/>
			</div>
            <div class="form-group">
				<input type="text" class="form-control"  name="pages" placeholder="Pages" value="{{old('pages')}}"/>
			</div>
			<div class="form-group">
				<select  name="category" class="form-control">
                    <option  value="{{old('category')}}"  selected="selected"> {{old('category', 'Category')}}</option>
                </select>
			</div>
			<div class="form-group">
				<select name="subcategory" class="form-control">
                    <option value="{{old('subcategory')}}" selected="selected"> {{old('subcategory', 'Subcategory')}}</option>
                </select>
			</div>
			<div class="form-group">
				<input type="text" name="language" class="form-control" placeholder="Language" value="{{old('language')}}"/>
			</div>
			<div class="form-group">
				<input type="text" name="price" class="form-control" placeholder="Price" value="{{old('price')}}"/>
			</div>
			<div class="form-group">
				<input type="file" name="cover_photo" class="form-control" placeholder="Cover Photo" value="{{old('cover_photo')}}"/>
			</div>
			<div class="form-group">
				<textarea class="form-control" name="details" placeholder="Book details" rows="7">{{old('details')}}</textarea>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Add Book" />
			</div>
		</form>
	</div>
</div>
@endsection