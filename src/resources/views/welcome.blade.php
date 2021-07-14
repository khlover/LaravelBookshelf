<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<?php

class Book
{
    public $title;
    public $author;

    public function __construct()
    {
        $this->title = $_GET['title'];
        $this->author = $_GET['author'];
    }

    public function delete()
    {
    }

    public function edit()
    {
    }
}

class BookShelf
{

    public $books = array();

    public function add()
    {
        $book = new Book;
        array_push($this->books, $book);
        console_log($this->books);
    }

    public function __construct()
    {
        $this->books = $this->books;
    }
}

if (!isset($shelf)) {
    console_log("IM GENERATED");
    $shelf = new BookShelf;
}



function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Book Shelf</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
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

        <div class="content">
            <div class="title m-b-md">
                Bookshelf
            </div>

            <div class="form">
                <form method="GET">
                    Title: <input type="text" name="title"><br>
                    Author: <input type="text" name="author"><br>
                    <input type="submit" value="Add" />
                </form>
            </div>

            <?php
            if (isset($_GET['title'])) {
                $shelf->add();
            }

            ?>

            <div class="booklist">
                <table style="width: 100%">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                    </tr>

                    <?php foreach ($shelf->books as $book) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($book->title) ?> </td>
                            <td><?php echo htmlspecialchars($book->author) ?> </td>
                        <?php endforeach ?>
            </div>
        </div>
    </div>
</body>

</html>