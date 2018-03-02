<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\UserTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Validator;

class UsersController extends Controller
{
    use Helpers;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginate(10);

        return $this->response->paginator($users, new UserTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'firstName' => 'required|min:3',
            'lastName' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response->errorBadRequest($validator->errors());
        }

        $attributes = [
            'name' => $request->get('firstName') . ' ' . $request->get('lastName'),
            'email' => $request->get('email'),
            'password' => app('hash')->make($request->get('password'))
        ];
        $user = $this->user->create($attributes);

        return $this->response->array(compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->where('id', $id)->first();

        if (!$user)
            return $this->errorBadRequest('No user found!');

        return $this->response->item($user, new UserTransformer());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator->messages());
        }

        $attributes = [
            'name' => $request->get('firstName') . ' ' . $request->get('lastName'),
            'email' => $request->get('email'),

        ];
        $user = $this->user->where('id', $id)->first();

        if (!$user->update($attributes))
            return $this->response->error('Update failed');

        return $this->response->noContent();
    }

    /**
     * Change the user password
     *
     * @param Request $request
     * @param $id
     */
    public function updatePassword(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (! $user) {
            return $this->response->errorNotFound();
        }

        if( !$user->delete() ) {
            return $this->response->errorInternal();
        }

        return $this->response->noContent();
    }
}
