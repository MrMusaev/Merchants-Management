<?php

namespace App\Policies\Merchants;

use App\Models\Merchants\Merchant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MerchantPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Merchant $merchant): bool
    {
        return $this->checkOwnModel($user, $merchant);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Merchant $merchant): bool
    {
        return $this->checkOwnModel($user, $merchant);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Merchant $merchant): bool
    {
        return $this->checkOwnModel($user, $merchant);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Merchant $merchant): bool
    {
        return $this->checkOwnModel($user, $merchant);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Merchant $merchant): bool
    {
        return $this->checkOwnModel($user, $merchant);
    }

    private function checkOwnModel(User $user, Merchant $merchant): bool
    {
        return $user->isSuperAdmin() || $user->id == $merchant->creator_id;
    }
}
