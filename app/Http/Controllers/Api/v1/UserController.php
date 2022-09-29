<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->authorizeResource(User::class, 'user');
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = max(min(100, (int) request()->get('perPage', 5)), 5);

        return $this->userRepo->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userRepo->create([
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
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userRepo->update($user, [
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
        $this->userRepo->delete($user);

        return response()->json([
            'message' => 'User deleted successfully!',
            'id' => $user->id,
        ]);
    }
}
