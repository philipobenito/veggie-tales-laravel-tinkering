<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filterable
{
    public function scopeApplyFilters(Builder $query, Request $request, array $filterable): Builder
    {
        foreach ($filterable as $field) {
            if ($request->has($field)) {
                $query->where($field, 'like', '%' . $request->input($field) . '%');
            }
        }

        return $query;
    }

    public function scopeApplySorting(Builder $query, Request $request): Builder
    {
        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            // Default to ascending order
            $sortOrder = $request->input('sort_order', 'asc');
            $query->orderBy($sortBy, $sortOrder);
        }

        return $query;
    }
}
