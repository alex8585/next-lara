<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\LocalesTrait;

class UserController extends Controller
{
    use LocalesTrait;

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = max(min(100, (int) request()->get('perPage', 5)), 5);

        $query = User::queryFilter()
      ->sort()
      ->paginate($perPage);

        return new UserCollection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
      'name' => $request->safe()->name,
      'email' => $request->safe()->email,
      'password' => Hash::make($request->safe()->password),
    ]);

        return response()->json([
      'message' => 'User created successfully!',
      'id' => $user->id,
    ]);

        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
      'name' => $request->safe()->name,
      'email' => $request->safe()->email,
      'password' => Hash::make($request->safe()->password),
    ]);

        return response()->json([
      'message' => 'User updated successfully!',
      'id' => $user->id,
    ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
      'message' => 'User deleted successfully!',
      'id' => $user->id,
    ]);
    }
}
