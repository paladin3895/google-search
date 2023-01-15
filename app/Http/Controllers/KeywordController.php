<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
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

        return $user->keywords()->orderBy('updated_at', 'desc')->get();
    }

    /**
     * return keyword's results
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

        $keyword->makeVisible('html');
        return $keyword;
    }

    /**
     * Render keywords dashboard
     *
     * @return void
     */
    public function getDashboard(Request $request)
    {
        /** @var User */
        $user = Auth::user();
        $keywords = $user->keywords()->get();

        return Inertia::render('Dashboard', [
            'token' => $user->createToken('auth')->plainTextToken,
            'keywords' => $keywords->toArray(),
        ]);
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

        /** @var UploadedFile */
        $file = $request->file('file');
        $mime = $file->getClientMimeType();

        if ($mime !== 'text/csv') {
            throw new BadRequestHttpException('Invalid upload file, text/csv required');
        }

        $csv = $file->openFile('r');

        $keywords = collect();
        while ($data = $csv->fgetcsv()) {
            // get first value only
            $keywords = $keywords->push($data[0]);
        }

        return $keywords
            ->filter()
            ->each(function ($key) use ($user) {
                $user->keywords()->create([
                    'key' => $key,
                ]);
            });
    }
}
