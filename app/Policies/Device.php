<?php

namespace App\Policies;

use App\Models\DeviceCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Device
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->categories()->pluck('id')[0] != 1;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DeviceCategory  $deviceCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, DeviceCategory $deviceCategory)
    {
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->categories()->pluck('id')[0] != 1;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DeviceCategory  $deviceCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, DeviceCategory $deviceCategory)
    {
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DeviceCategory  $deviceCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, DeviceCategory $deviceCategory)
    {
        return $user->categories()->pluck('id')[0] != 1;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DeviceCategory  $deviceCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, DeviceCategory $deviceCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DeviceCategory  $deviceCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, DeviceCategory $deviceCategory)
    {
        //
    }
}
