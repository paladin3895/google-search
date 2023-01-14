<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class KeywordController extends Controller
{
    public static function getMethodName($name)
    {
        return static::class . '@' . $name;
    }

    /**
     * return a list of user's keywords
     *
     * @return Collection<int, Keyword>
     */
    public function index()
    {
        return null;
    }

    /**
     * return keyword's results and HTML
     *
     * @return Keyword
     */
    public function show($param)
    {
        return null;
    }

}
