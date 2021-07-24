<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Book</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/home.css')}}">

</head>

<body>
    <div class="content">
        <div class="title m-b-md">
            Edit Book
        </div>

        @if ($errors->any())
        <div class="errormessage">
            <h2>Errors!</h2>
            <div>
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
        @endif

        <div class="input">
            <form method="POST" action="/books/{{$book->bookid }}">
                @csrf
                Title: <input type="text" name="title" value="{{$book->title}}" required><br>
                Author: <input type="text" name="author" value="{{$book->author}}" required><br>
                <input type="submit" value="Edit" />
            </form>
        </div>
    </div>
</body>

</html>