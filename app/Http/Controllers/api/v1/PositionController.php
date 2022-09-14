<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Position\IndexPositionRequest;
use App\Http\Requests\Position\SearchPositionRequest;
use App\Http\Requests\Position\StorePositionRequest;
use App\Http\Requests\Position\UpdatePositionRequest;
use App\Http\Resources\Position\PositionCollection;
use App\Http\Resources\Position\PositionResource;
use App\Models\Position;
use App\Services\PositionService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * @var PositionService
     */
    protected PositionService $positionService;

    /**
     * @param PositionService $positionService
     */
    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexPositionRequest $request
     * @return JsonResponse
     */
    public function index(IndexPositionRequest $request): JsonResponse
    {
        return success('Positions Index Successfully', new PositionCollection($this->positionService->index($request)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePositionRequest $request
     * @return JsonResponse
     */
    public function store(StorePositionRequest $request): JsonResponse
    {
        $inputs = $request->except(['expired_at', 'lived_at']);
        $inputs["expired_at"] = Carbon::now()->addDays($request->get('expired_at'));
        $inputs["lived_at"] = Carbon::now()->addDays($request->get('lived_at'));
        $position = $this->positionService->create($inputs);
        $this->addToIndex($position);
        if ((bool)$position)
            return success('Position Stored Successfully', new PositionResource($position));
        else
            return failed('An Unknown Error  Happened', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return success('Position Show Successfully', new PositionResource($this->positionService->show($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePositionRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdatePositionRequest $request, int $id): JsonResponse
    {
        $inputs = $request->except(['expired_at', 'lived_at']);
        $request->has('expired_at') ? $inputs["expired_at"] = Carbon::now()->addDays($request->get('expired_at'))
            : null;
        $request->has('lived_at') ? $inputs["lived_at"] = Carbon::now()->addDays($request->get('lived_at'))
            : null;
        $position = $this->positionService->updateAndFetch($id, $inputs);
        $this->addToIndex($position);
        if ((bool)$position)
            return success('Position Updated Successfully', $position);
        else
            return failed('An Unknown Error Is Happened', 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return success('Position Deleted Successfully', $this->positionService->delete($id));
    }

    /**
     * search all the positions in elasticsearch
     * @param SearchPositionRequest $request
     * @return JsonResponse
     */
    public function search(SearchPositionRequest $request): JsonResponse
    {
        $positions = $this->positionService->search($request);
        return success('The Positions Search Successfully.', $positions);
    }

    /**
     * add new or updated record to elasticsearch
     * @param $position
     * @return void
     */
    protected function addToIndex($position)
    {
        $this->positionService->addToIndex($position);
    }

}
