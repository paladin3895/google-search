<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        /** @var User */
        $user = Auth::user();

        return $user->keywords()->get();
    }

    /**
     * return keyword's results and HTML
     *
     * @return Keyword
     */
    public function show(Request $request, $id)
    {
        /** @var User */
        $user = Auth::user();

        $keyword = $user->keywords()->find($id);

        if (!$keyword) {
            throw new NotFoundHttpException('Keyword not found');
        }

        return $keyword;
    }

    /**
     * undocumented function
     *
     * @return void
     */
    public function create(Request $request)
    {
        /** @var User */
        $user = Auth::user();

        $keyword = $user->keywords()->create($request->only('key'));

        return $keyword;
    }

    /**
     * handle keywords file upload
     *
     * @return void
     */
    public function upload(Request $request)
    {
        /** @var User */
        $user = Auth::user();

        if (!$request->hasFile('file')) {
            throw new BadRequestHttpException('Missing upload file');
        }


    }
}
