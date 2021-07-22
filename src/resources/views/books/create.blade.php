<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Add Book</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/home.css')}}">

<body>
    <div class="content">
        <div class="title m-b-md">
            Add Book
        </div>

        <div class="input">
            <form method="POST" action="{{route('books.store')}}">
                @csrf
                Title: <input type="text" name="title" required><br>
                Author: <input type="text" name="author" required><br>
                <input type="submit" value="Add" />
            </form>
        </div>

    </div>
    </div>
    </div>
</body>

</html>