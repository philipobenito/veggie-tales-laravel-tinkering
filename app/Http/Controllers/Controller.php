<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    protected function loadRelationships(Request $request, mixed $query, array $allowedRelationships): mixed
    {
        // Parse the 'with' query parameter
        $requestedRelationships = explode(',', $request->query('with', ''));

        // Filter the requested relationships based on the whitelist
        $relationshipsToLoad = array_intersect($requestedRelationships, $allowedRelationships);

        // Conditionally load the relationships
        if (!empty($relationshipsToLoad)) {
            $query->with($relationshipsToLoad);
        }

        return $query;
    }
}
