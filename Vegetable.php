<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vegetable extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'classification_id',
        'description',
        'edible',
    ];

    /**
     * Get the classification for the vegetable.
     */
    public function classification()
    {
        return $this->belongsTo(VegetableClassification::class, 'classification_id');
    }
}
