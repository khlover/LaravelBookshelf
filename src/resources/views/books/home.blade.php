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

        <div class="row">
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


        <div class="row">
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

            <div class="row">
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

            <div class="row">
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