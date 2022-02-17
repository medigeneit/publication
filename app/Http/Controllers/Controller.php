<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $query;
    public function __construct()
    {

        if( env('APP_DEBUG', false ) ) {
            DB::enableQueryLog();

        }

    }

    protected function getQuery()
    {
        return $this->query;
    }

    protected function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }
}
