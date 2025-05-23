<?php

namespace App\Repositories\Status;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Status;


/**
 * Class StatusRepository.
 */
class StatusRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Status::class;
    }
}
