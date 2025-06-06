<?php

namespace App\Repositories\Ticket;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Ticket;
use App\Models\Status;


/**
 * Class TicketRepository.
 */
class TicketRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Ticket::class;
    }
}
