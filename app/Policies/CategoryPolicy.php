<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
  use HandlesAuthorization;

  /**
   * Determine whether the user can view any models.
   *
   * @return bool|\Illuminate\Auth\Access\Response
   */
  public function viewAny(User $user)
  {
    return true;
  }

  /**
   * Determine whether the user can view the model.
   *
   * @return bool|\Illuminate\Auth\Access\Response
   */
  public function view(User $user, Category $category)
  {
    return true;
  }

  /**
   * Determine whether the user can create models.
   *
   * @return bool|\Illuminate\Auth\Access\Response
   */
  public function create(User $user)
  {
    return in_array($user->role, [UserRole::Admin, UserRole::Editor]);
  }

  /**
   * Determine whether the user can update the model.
   *
   * @return bool|\Illuminate\Auth\Access\Response
   */
  public function update(User $user, Category $category)
  {
    return in_array($user->role, [UserRole::Admin]);
  }

  /**
   * Determine whether the user can delete the model.
   *
   * @return bool|\Illuminate\Auth\Access\Response
   */
  public function delete(User $user, Category $category)
  {
    return in_array($user->role, [UserRole::Admin]);
  }

  /**
   * Determine whether the user can restore the model.
   *
   * @return bool|\Illuminate\Auth\Access\Response
   */
  public function restore(User $user, Category $category)
  {
    //
  }

  /**
   * Determine whether the user can permanently delete the model.
   *
   * @return bool|\Illuminate\Auth\Access\Response
   */
  public function forceDelete(User $user, Category $category)
  {
    //
  }
}
