<?php

namespace App\Models;

use App\Classes\ExportFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Book extends Model
{
    use Sortable;

    protected $guarded = ["bookid"];
    protected $primaryKey = "bookid";

    public $sortable = ["title", "author"];
    public $timestamps = false;

    static function toCSV(Request $request)
    {
        $field = strtolower($request->field);
        $search = explode(",", $request->search);
        $export = new ExportFile();

        if ($field == "all") {
            $data = DB::table("books")
                ->when($search[0] != "", function ($query) use ($search) {
                    return $query->where($search[0], $search[1]);
                })
                ->get();

            $field = "Book";
        } else {
            $data = DB::table("books")
                ->select($field)
                ->when($search[0] != "", function ($query) use ($search) {
                    return $query->where($search[0], $search[1]);
                })
                ->get();
        }

        $export->create_CSV($data, $field);
    }

    static function toXML(Request $request)
    {
        $field = strtolower($request->field);
        $search = explode(",", $request->search);
        $export = new ExportFile();

        if ($field == "all") {
            $data = DB::table("books")
                ->when($search[0] != "", function ($query) use ($search) {
                    return $query->where($search[0], $search[1]);
                })
                ->get();

            $field = "Book";
        } else {
            $data = DB::table("books")
                ->select($field)
                ->when($search[0] != "", function ($query) use ($search) {
                    return $query->where($search[0], $search[1]);
                })
                ->get();
        }

        $export->create_XML($data, $field);
    }
}
