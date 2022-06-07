<?php

namespace App\Repositories\user;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\User;

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
}
