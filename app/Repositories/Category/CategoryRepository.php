<?php

namespace App\Repositories\Category;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Category;


/**
 * Class CategoryRepository.
 */
class CategoryRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Category::class;
    }
}
