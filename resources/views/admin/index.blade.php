@extends('admin.master')
@section('content')
<div class="col-sm-12">
    <table class="table table-stripped table-bordered">
        <thead>
            <tr>
                <form>
                    <td>
                        Book count
                    </td>
                     <td>
                          <select class="form-control">
                            <option value="#">Category</option>
                         </select>
                    </td>
                     <td>
                        <button class="btn btn-primary"> Apply</button>
                    </td>
                    <td>
                         <select class="form-control">
                            <option value="#">Subcategory</option>
                         </select>
                    </td>
                     <td>
                          <button class="btn btn-primary"> Apply</button>
                    </td>
                    <td>

                    </td>
                </form>
            </tr>
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
            <tr>
                <td>
                    <img src="{{asset('storage/book_img/1.jpg')}}" />
                </td>
                <td>
                    Title
                </td>
                <td>
                    Author
                </td>
                <td>
                    Category
                </td>
                <td>
                    Subcategory
                </td>
                <td>
                    Price
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
