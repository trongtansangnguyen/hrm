<?php

namespace App\Repositories;

use App\Repositories\Core\RepositoryAbstract;
use App\Models\Log;
use Illuminate\Database\Eloquent\Model;

class LogRepository extends RepositoryAbstract
{
    /**
     * Get the model instance
     */
    protected function getModel(): Model
    {
        return new Log();
    }
}
