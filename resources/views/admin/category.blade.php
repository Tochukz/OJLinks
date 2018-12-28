@extends('admin.master')
@section('content')
<div class="col-sm-12">

    <form class="header-form">
        <div class="form-group">
            <span>Category</span>
            <select class="form-control" id="cat_field">
                <option value="" disabled="disabled">Category</option>
            </select>
            <button class="btn btn-primary btn-sm"> Apply</button>
        </div>
        <div class="form-group">
            <span>Subcategory</span>
            <select class="form-control" id="subcat_field">
            <option value="" disabled="disabled" selected="selected">Subcategory</option>
            </select>
            <button class="btn btn-primary btn-sm"> Apply</button>
        </div>
    </form>

    <table class="table table-stripped table-bordered">
        <thead>
            <tr>
                <th>
                    Book
                </th>
                <th>
                    Title
                </th>
                <th>
                     Author
                </th>
                <th>
                    Category
                </th>
                <th>
                    Subcategory
                </th>
                <th>
                     Price
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>

            </tr>
        </tfoot>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>
                    <img src='{{asset("storage/book_img/$book->img")}}' />
                </td>
                <td>
                   {{$book->title}}
                </td>
                <td>
                   {{$book->author}}
                </td>
                <td>
                   {{$book->category}}
                </td>
                <td>
                    {{$book->subcategory}}
                </td>
                <td>
                    {{$book->price}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
   {{$books->links()}}
</div>
@endsection
