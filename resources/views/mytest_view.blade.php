@extends('layouts.master')
@section('body')
    <?php //var_dump($posts); ?>
    <table class="table table-bordered">
    <tr>
        <th>Title</th>
        <th>Author</th>
    </tr>
    @foreach($books as $book)
        <tr>
            <td>{{$book->title}} </td>
            <td>{{$book->author}} </td>
        </tr>
    @endforeach
    </table>
@endsection


