<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{

    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $authors = Author::all();
        return $this->successResponse($authors);
    }

    /**
     * Store an Author
     * @param Request $request
     * @return use Illuminate\Http\Response;
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:female,male',
            'country' => 'required|max:255',
        ];

        $this->validate($request, $rules);
        $author = Author::create($request->all());
        return $this->successResponse($author, Response::HTTP_CREATED);

    }

    public function show($authorId)
    {
        $author = Author::findOrFail($authorId);
        return $this->successResponse($author);
    }

    public function update(Request $request, $authorId)
    {
        $rules = [
            'name' => 'max:255|',
            'gender' => 'max:255|in:female,male',
            'country' => 'max:255',
        ];

        $this->validate($request, $rules);

        $author = Author::findOrFail($authorId);
        $author->fill($request->all());

        //Check, if no change made
        if ($author->isClean()) {
            return $this->errorResponse('At least one Field should be changed', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $author->update();
        return $this->successResponse($author);
    }

    public function destroy($authorId)
    {

    }
}