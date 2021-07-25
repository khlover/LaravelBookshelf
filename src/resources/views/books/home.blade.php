<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<?php

use Illuminate\Contracts\View\View; ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <div>
        <title>Book Shelf</title>
    </div>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/home.css')}}">


    <!-- Styles -->
    <style>
html,
body {
    background-color: #fff;
    color: #636b6f;
    font-family: "Nunito", sans-serif;
    font-weight: 200;
    height: 100vh;
    margin: 0;
}

.button_row {
    display: flex;
    margin-top: 25px;
    justify-content: center;
    gap: 15px;
}

.errormessage {
    color: red;
    font-weight: bold;
}

.full-height {
    height: 100vh;
}

.flex-center {
    align-items: center;
    display: flex;
    flex-direction: column;
    text-align: center;
}

.position-ref {
    position: relative;
}

.top-right {
    position: absolute;
    right: 10px;
    top: 18px;
}

.title {
    text-align: center;
}

.content {
    text-align: center;
}

.title {
    font-size: 84px;
}

.links > a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.1rem;
    text-decoration: none;
    text-transform: uppercase;
}

table {
    margin-top: 20px;

}

table,
th,
td {
    border: 1px solid grey;
    border-collapse: collapse;
}

.remove {
    cursor: pointer;
}

.searchrow {
    margin-top: 25px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 15px;
}

.booklist {
    text-align: center;
}

.pagination {
    display: flex;
    justify-content: space-around;
    list-style-type: none;
}

.m-b-md {
    margin-bottom: 30px;
}

@media only screen and (max-width: 700px) {
    .searchrow{
         flex-direction: column;
    }

    table{
        max-width: 300px;

    }

    td{
        max-width: 50px;
        overflow: scroll;
    }

    .title{
        font-size: 50px;
        margin-bottom: 0px;
    }
}

    </style>

</head>

<body>

    <div class=" title m-b-md">
        Bookshelf
    </div>

    <!-- Setting blank query if user has not searched to prevent failure-->
    @if (!isset($query))
    {{$query = null}}
    @endif

    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="searchrow">
            <form method="Get" action="{{route('books.search-title')}}">
                @csrf
                <h2>Search for Title</h2>
                <span><input type="input" placeholder="Enter title" name="title" required /> <button type="submit"><i class="fa fa-search"></i></button></span>
            </form>

            <form method="Get" action="{{route('books.search-author')}}">
                @csrf
                <h2>Search for Author</h2>
                <span><input type="input" placeholder="Enter author name" name="author" required /> <button type="submit"><i class="fa fa-search"></i></button></span>
            </form>
        </div>

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <p class="errormessage">{{ $error }}</p>
        @endforeach
        @endif


        <div class="buttonrow">
            <a href="/"><input type="submit" class="button" value="Show All" /></a>
            <a href="/books/create"> <input type="submit" class="button" value="New Book" /> </a>
        </div>

        <div class="booklist">
            <table class="booktable" style="width: 120%">
                <tr>
                    <th>Edit </th>
                    <th>@sortablelink('title')</th>
                    <th>@sortablelink('author')</th>
                    <th>Delete</th>
                </tr>
                </form>

                <tbody>
                    @if ($books->count() == 0)
                    <tr>
                        <td colspan="4"> No books in the bookshelf. </td>
                    </tr>
                    @endif

                    @foreach ($books as $book)
                    <?php $title = $book->title ?>
                    <tr>
                        <td>
                            <form method="get" action="/books/ <?= $book->bookid ?>">
                                <button class="remove"><i class="fa fa-edit"></i></button>
                            </form>
                        </td>
                        <td><?= htmlspecialchars($book->title) ?> </td>
                        <td><?= htmlspecialchars($book->author) ?> </td>
                        <td>
                            <form method="post" action="/books/<?= $book->bookid ?>">
                                @csrf
                                @method('DELETE')
                                <button class="remove"><i class="fa fa-trash"></i></button>
                        </td>
                        </form>
                        @endforeach
                </tbody>

            </table>
            {{$books->links()}}
            Showing {{$books->count() + ($books->currentPage() - 1 ) * $books->perPage()}} of {{$books->total()}}

            <div class="button_row">
                <t2> Export to CSV By </t2>
                <form method="GET" action="{{route('books.export-csv',['search' => $query])}}">
                    <input type="submit" class="button" name="field" value="Title" />
                </form>

                <form method="GET" action="{{route('books.export-csv',['search' => $query])}}">
                    <input type="submit" class="button" name="field" value="Author" />
                </form>

                <form method="GET" action="{{route('books.export-csv', $query )}}">
                    <input type="submit" class="button" name="field" value="All" />
                </form>
            </div>

            <div class="button_row">
                <t2> Export to XML By </t2>
                <form method="GET" action="{{route('books.export-xml',['search' => $query])}}">
                    <input type="submit" class="button" name="field" value="Title" />
                </form>

                <form method="GET" action="{{route('books.export-xml',['search' => $query])}}">
                    <input type="submit" class="button" name="field" value="Author" />
                </form>

                <form method="GET" action="{{route('books.export-xml')}}">
                    <input type="submit" class="button" name="field" value="All" />
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>