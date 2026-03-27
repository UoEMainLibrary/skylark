<?php

namespace App\Policies;

use App\Models\RespHomeContent;
use App\Models\User;

class RespHomeContentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, RespHomeContent $respHomeContent): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, RespHomeContent $respHomeContent): bool
    {
        return true;
    }

    public function delete(User $user, RespHomeContent $respHomeContent): bool
    {
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }

    public function restore(User $user, RespHomeContent $respHomeContent): bool
    {
        return false;
    }

    public function forceDelete(User $user, RespHomeContent $respHomeContent): bool
    {
        return false;
    }
}
