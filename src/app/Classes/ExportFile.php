<?php

namespace App\Classes;

use DOMDocument;

class ExportFile
{

    //Creates instance
    public function __construct()
    {
    }

    /**
     * Creates XML file from database object then downloads to user via headers.
     *
     * @param mixed $obj   - Object containing filtered table data
     * @param mixed $field - Table column field name
     *
     * @return void
     */

    function create_XML($obj, $field)
    {
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename=' . $field . 's.xml');

        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;

        $container = $doc->createElement('container');
        $container = $doc->appendChild($container);

        foreach ($obj as $line) {
            $root = $doc->createElement('book');

            if ($field == "Book" || $field == "title") {
                $title = $doc->createElement('Title', $line->title);
                $title = $root->appendChild($title);
            }

            if ($field == "Book" || $field == "author") {
                $author = $doc->createElement('Author', $line->author);
                $author = $root->appendChild($author);
            }

            $root = $container->appendChild($root);
        }

        $xmldata =  $doc->saveXML();
        echo $xmldata;
        exit();
        return redirect('/books');
    }


    /**
     * Creates CSV file from the database object then downloads to user via headers.
     *
     * @param mixed $obj   - Object containing filtered table data
     * @param mixed $field - Table column field name
     *
     * @return void
     */
    function create_CSV($obj, $field)
    {
        header("Content-Type: application/csv");
        header("Content-Disposition: attachment; filename= " . $field . "s.csv");

        if ($field != "Books") {
            $headers = [$field];
        } else {

            $headers = ['Title', 'Author'];
        }

        $f = fopen('php://output', 'w');


        fputcsv($f, $headers);
        foreach ($obj as $line) {
            if (isset($line)) {
                fputcsv($f, get_object_vars($line));
            }
        }

        fclose($f);
        return redirect('/books');
    }
}
