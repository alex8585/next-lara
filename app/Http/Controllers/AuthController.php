<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
  /**
   * Create a new AuthController instance.
   */
  public function __construct()
  {
    /* $this->middleware('auth:api', ['except' => ['login']]); */
  }

  public function register()
  {
    $validated = request()->validate([
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', Rules\Password::defaults()],
    ]);

    /* return response()->json($validated); */
    $user = User::create([
      'name' => $validated['email'],

      'email' => $validated['email'],
      'password' => Hash::make($validated['password']),
    ]);

    event(new Registered($user));

    Auth::login($user);

    return $this->respondWithToken(auth()->refresh());
    /* return response()->json(auth()->user()); */
  }

  /**
   * Get a JWT via given credentials.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function login()
  {
    /* dd('1'); */
    $credentials = request(['email', 'password']);

    if (!($token = auth()->attempt($credentials))) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    return $this->respondWithToken($token);
  }

  /**
   * Get the authenticated User.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function me()
  {
    return response()->json(auth()->user());
  }

  /**
   * Log the user out (Invalidate the token).
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
    auth()->logout();

    return response()->json(['message' => 'Successfully logged out']);
  }

  /**
   * Refresh a token.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function refresh()
  {
    return $this->respondWithToken(auth()->refresh());
  }

  /**
   * Get the token array structure.
   *
   * @param string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function respondWithToken($token)
  {
    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' =>
        auth()
          ->factory()
          ->getTTL() * 60,
    ]);
  }
}
