<?php

namespace KozhinhikkodanDev\ArtisanPlayground\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;
use KozhinhikkodanDev\ArtisanPlayground\Models\ArtisanCommand;

class ArtisanCommandPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('artisan-playground.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ArtisanCommand $artisanCommand): bool
    {
        return $user->hasPermissionTo('artisan-playground.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('artisan-playground.execute');
    }

    /**
     * Determine whether the user can execute dangerous commands.
     */
    public function executeDangerous(User $user): bool
    {
        return $user->hasPermissionTo('artisan-playground.execute-dangerous');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ArtisanCommand $artisanCommand): bool
    {
        return $user->hasPermissionTo('artisan-playground.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ArtisanCommand $artisanCommand): bool
    {
        return $user->hasPermissionTo('artisan-playground.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ArtisanCommand $artisanCommand): bool
    {
        return $user->hasPermissionTo('artisan-playground.force-delete');
    }
}