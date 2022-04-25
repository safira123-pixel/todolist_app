<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use ApiResponse;

    public function index()
    {
        $user = auth()->user();
        $todos = Todo::with('user')
            ->where('user_id', $user->id)
            ->get();

            return $this->apiSuccess($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validated();

        $user = auth()->user();
        $todo = new Todo($request->all());
        $todo->user()->associate($user);
        $todo->save();

        return $this->apiSuccess($todo->load('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(todo $todo)
    {
        return $this->apiSuccess($todo->load('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, todo $todo)
    {
        $request->validated();
        $todo->todo = $request->todo;
        $todo->label = $request->label;
        $todo->done = $request->done;
        $todo->save();
        return $this->apiSuccess($todo->load('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(todo $todo)
    {
        if(auth()->user()->id = $todo->user_id){
            $todo->delete;
            return $this->apiSuccess($todo);
        }
        return $this->apiError(
            'Unautorized',
            Response::HTTP_UNAUTORIZED
        );
    }
}