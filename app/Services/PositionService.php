<?php

namespace App\Services;

use App\Repositories\Position\PositionRepositoryInterface;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;

class PositionService extends BaseService
{
    /**
     * @param PositionRepositoryInterface $repository
     */
    #[Pure] public function __construct(PositionRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function search(Request $request)
    {
      return  $this->repository->search($request);
    }

    public function addToIndex($position)
    {
       return $this->repository->addToIndex($position);
    }
}
