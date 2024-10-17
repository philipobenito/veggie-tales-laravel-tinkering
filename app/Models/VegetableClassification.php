<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VegetableClassification extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = ['name'];

    /**
     * Get the vegetables for the classification.
     */
    public function vegetables()
    {
        return $this->hasMany(Vegetable::class, 'classification_id');
    }
}
