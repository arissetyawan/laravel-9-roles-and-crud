<?php

namespace App\Repositories\Priority;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Priority;


/**
 * Class PriorityRepository.
 */
class PriorityRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Priority::class;
    }
}
