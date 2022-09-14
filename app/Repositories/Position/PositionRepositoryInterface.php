<?php

namespace App\Repositories\Position;

use Elasticquent\ElasticquentResultCollection;
use Illuminate\Http\Request;

interface PositionRepositoryInterface
{
    /**
     * @param $position
     * @return void
     */
    public function addToIndex($position): void;

    /**
     * @param Request $request
     * @return ElasticquentResultCollection
     */
    public function search(Request $request): ElasticquentResultCollection;


}
