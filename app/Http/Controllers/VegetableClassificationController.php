<?php

namespace App\Http\Controllers;

use App\Http\Requests\VegetableClassificationRequest;
use App\Http\Resources\VegetableClassificationResource;
use App\Models\VegetableClassification;
use Illuminate\Http\Request;

class VegetableClassificationController extends Controller
{
    protected $vegetableClassification;
    protected $vegetableClassificationResource;

    public function __construct(
        VegetableClassification $vegetableClassification,
        VegetableClassificationResource $vegetableClassificationResource
    ) {
        $this->vegetableClassification = $vegetableClassification;
        $this->vegetableClassificationResource = $vegetableClassificationResource;
    }

    /**
     * GET /vegetable-classifications
     */
    public function index(Request $request)
    {
        $query = $this->vegetableClassification->query();

        $query->applyFilters($request, ['name'])
              ->applySorting($request);

        // I would prefer to abstract this in to a custom query object
        // but for brevity I'll leave it here for now
        $query = $this->loadRelationships($request, $query, allowedRelationships: ['vegetables']);

        $vegetables = $query->get();
        return $this->vegetableClassificationResource::collection($vegetables);
    }

    /**
     * POST /vegetable-classifications
     *
     * Note that we are fine with a 200 response code here, as the resource is created successfully AND returned.
     * 201 Created is more appropriate when the resource is created but not returned.
     *
     * QA Phil here... I think Laravel is doing some magic to ensure a 201 response
     * anyway, which is acceptable, but 200 would also be fine.
     */
    public function store(VegetableClassificationRequest $request)
    {
        $classification = $this->vegetableClassification->create($request->validated());
        return $this->vegetableClassificationResource::make($classification);
    }

    /**
     * GET /vegetable-classifications/{id}
     */
    public function show(VegetableClassification $vegetableClassification)
    {
        // For brevity there is no consideration to data size on the dependency here
        $vegetableClassification->load('vegetables');
        return $this->vegetableClassificationResource::make($vegetableClassification);
    }

    /**
     * PUT OR PATCH /vegetable-classifications/{id}
     *
     * A discussion to be had here regarding PUT vs PATCH, I'd prefer PATCH as we're
     * only updating the fields that are sent. However, if we're updating all fields,
     * PUT would be more appropriate.
     */
    public function update(VegetableClassificationRequest $request, VegetableClassification $vegetableClassification)
    {
        $vegetableClassification->update($request->validated());
        return $this->vegetableClassificationResource::make($vegetableClassification);
    }

    /**
     * DELETE /vegetable-classifications/{id}
     */
    public function destroy(VegetableClassification $vegetableClassification)
    {
        $vegetableClassification->delete();
        return response()->json(null, 204);
    }
}
