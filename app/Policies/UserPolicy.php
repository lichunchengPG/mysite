<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
       //
    }
    public function update(User $currentUser, User $user)
    {
      return  $currentUser->id === $user->id;
      // '===' 表示判断值和类型是否都相等
    }
    public function destroy(User $currentUser, User $user)
    {
      return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
