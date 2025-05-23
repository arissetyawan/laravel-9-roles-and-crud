<?php

namespace App\Repositories\User;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\User;
use App\Models\Role;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }
    public function byRole($role_id)
    {
        return Role::find($role_id)->users()->get();
    }
}
