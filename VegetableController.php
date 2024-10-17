<?php

namespace App\Http\Controllers;

use App\Models\Vegetable;
use App\Http\Requests\VegetableRequest;
use App\Http\Resources\VegetableResource;

class VegetableController extends Controller
{
    protected $vegetable;
    protected $vegetableResource;

    public function __construct(Vegetable $vegetable, VegetableResource $vegetableResource)
    {
        $this->vegetable = $vegetable;
        $this->vegetableResource = $vegetableResource;
    }

    /**
     * GET /vegetables
     */
    public function index(VegetableRequest $request)
    {
        $query = $this->vegetable->query();

        $query->applyFilters($request, ['name', 'classification', 'edible'])
              ->applySorting($request);

        $vegetables = $query->get();
        return $this->vegetableResource::collection($vegetables);
    }

    /**
     * POST /vegetables
     *
     * Note that we are fine with a 200 response code here, as the resource is created successfully AND returned.
     * 201 Created is more appropriate when the resource is created but not returned.
     */
    public function store(VegetableRequest $request)
    {
        $vegetable = $this->vegetable->create($request->validated());
        return $this->vegetableResource::make($vegetable);
    }

    /**
     * GET /vegetables/{id}
     */
    public function show(Vegetable $vegetable)
    {
        return $this->vegetableResource::make($vegetable);
    }

    /**
     * PUT OR PATCH /vegetables/{id}
     *
     * A discussion to be had here regarding PUT vs PATCH, I'd prefer PATCH as we're
     * only updating the fields that are sent. However, if we're updating all fields,
     * PUT would be more appropriate.
     */
    public function update(VegetableRequest $request, Vegetable $vegetable)
    {
        $vegetable->update($request->validated());
        return $this->vegetableResource::make($vegetable);
    }

    /**
     * DELETE /vegetables/{id}
     */
    public function destroy(VegetableRequest $vegetable)
    {
        $vegetable->delete();
        return response()->json(null, 204);
    }
}
