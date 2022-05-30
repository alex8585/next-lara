<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
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
    //
  }

  /**
   * Determine whether the user can view the model.
   *
   * @return bool|\Illuminate\Auth\Access\Response
   */
  public function view(User $user, Tag $tag)
  {
    return true;
    //
  }

  /**
   * Determine whether the user can create models.
   *
   * @return bool|\Illuminate\Auth\Access\Response
   */
  public function create(User $user)
  {
    return true;
  }

  /**
   * Determine whether the user can update the model.
   *
   * @return bool|\Illuminate\Auth\Access\Response
   */
  public function update(User $user, Tag $tag)
  {
    return true;
  }

  /**
   * Determine whether the user can delete the model.
   *
   * @return bool|\Illuminate\Auth\Access\Response
   */
  public function delete(User $user, Tag $tag)
  {
    return true;
  }

  /**
   * Determine whether the user can restore the model.
   *
   * @return bool|\Illuminate\Auth\Access\Response
   */
  public function restore(User $user, Tag $tag)
  {
    //
  }

  /**
   * Determine whether the user can permanently delete the model.
   *
   * @return bool|\Illuminate\Auth\Access\Response
   */
  public function forceDelete(User $user, Tag $tag)
  {
    //
  }
}
