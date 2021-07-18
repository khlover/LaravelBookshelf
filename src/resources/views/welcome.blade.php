<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<?php

use Illuminate\Contracts\View\View;

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
            flex-direction: column;
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

        .export {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 5px;

        }

        .booklist {
            text-align: center;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <?PHP $_POST = array(); ?>
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

        <form method="Get" action="/search/title">
            @csrf
            <p>Search for Title</p>
            <span><input type="input" placeholder="Enter title" name="title" /> <button type="submit"><i class="fa fa-search"></i></button></span>
        </form>



        <form method="Get" action="/search/author">
            @csrf
            <p>Search for Author</p>
            <span><input type="input" placeholder="Enter author name" name="author" /> <button type="submit"><i class="fa fa-search"></i></button></span>
        </form>



        <div class="title m-b-md">
            Bookshelf
        </div>

        <form method="GET" action="/">
            <input type="submit" class="button" value="Show All" />
        </form>

        <form method="GET" action="/add">
            <input type="submit" class="button" value="New Book" />
        </form>

        <div class="booklist">
            <table class="booktable" style="width: 120%">
                <tr>
                    <th>Edit </th>
                    <form method="GET" action="/sort/title">
                        <th>Title <button class="remove"><i class="fa fa-sort"></i></button></th>
                    </form>
                    <form method="GET" action="/sort/author">
                        <th>Author <button class="remove"><i class="fa fa-sort"></i></button></th>
                    </form>
                    <th>Delete</th>
                </tr>
                </form>
                <?php foreach ($books as $book) : ?>
                    <?php $title = $book->title ?>
                    <tr>
                        <td>
                            <form method="post" action="/edit/ <?= $book->bookid ?>">
                                @csrf
                                <button class="remove"><i class="fa fa-edit"></i></button>
                            </form>
                        </td>
                        <td><?php echo htmlspecialchars($book->title) ?> </td>
                        <td><?php echo htmlspecialchars($book->author) ?> </td>
                        <td>
                            <form method="post" action="/delete/<?= $book->bookid ?>">
                                @csrf
                                <button class="remove"><i class="fa fa-trash"></i></button>
                        </td>
                        </form>
                    <?php endforeach ?>
            </table>

            <div class="export">
                <t2> Export to CSV </t2>
                <form method="GET" action="/export/csv/title">
                    <input type="submit" class="button" value="By Title" />
                </form>

                <form method="GET" action="/export/csv/author">
                    <input type="submit" class="button" value="By Author" />
                </form>

                <form method="GET" action="/export/csv/">
                    <input type="submit" class="button" value="All" />
                </form>
            </div>

            <div class="export">
                <t2> Export to XML </t2>
                <form method="GET" action="/export/xml/title">
                    <input type="submit" class="button" value="By Title" />
                </form>

                <form method="GET" action="/export/xml/author">
                    <input type="submit" class="button" value="By Author" />
                </form>

                <form method="GET" action="/export/xml/">
                    <input type="submit" class="button" value="All" />
                </form>
            </div>


        </div>
    </div>
    </div>
</body>

</html>