<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::all();
            if ($users == []) {
                return $this->notFound('there is no users');
            }

            return $this->success('got all users successfully', UserResource::collection($users));
        } catch (\Throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'is_admin' => 'required',
                'image' => ['file', 'mimetypes:image/*'],
            ]);
            $user = User::create($data);

            if ($request->file('image')) {
                $path = $request->file('image')->storeAs('user', $user->id.'.'.$request->file('image')->extension(), 'custom');
                $user->update(['image' => $path]);
            }

            return $this->success('created user successfully', new UserResource($user));
        } catch (ValidationException $v) {
            return $this->validationError('invalid data', $v->errors());
        } catch (\throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            return $this->success('got user successfully', new UserResource($user));
        } catch (\throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $data = $request->validate([
                'first_name' => 'string',
                'last_name' => 'string',
                'email' => 'string|email|unique:users,email,except,'.$user->id,
                'password' => 'string',
                'is_admin' => 'string',
                'image' => ['file', 'mimetypes:image/*'],
            ]);

            $user->update($data);

            if ($request->file('image')) {
                Storage::delete($user->image);
                $path = $request->file('image')->storeAs('user', $user->id.'.'.$request->file('image')->extension(), 'custom');
                $user->update(['image' => $path]);
            }

            return $this->success('updated user successfully', new UserResource($user));
        } catch (ValidationException $v) {
            return $this->validationError('invalid data', $v->errors());
        } catch (\throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            Storage::delete($user->image);
            $user->delete();

            return $this->success('deleted user successfully');
        } catch (\throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }
}
