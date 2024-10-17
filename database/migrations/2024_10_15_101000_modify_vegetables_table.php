<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vegetables', function (Blueprint $table) {
            // Add the new classification_id column
            $table->unsignedBigInteger('classification_id')->nullable();

            // Set up the foreign key relationship
            $table->foreign('classification_id')
                  ->references('id')
                  ->on('vegetable_classifications')
                  ->onDelete('set null');
        });

        // Seed the vegetable_classifications table and update the vegetables table
        $this->seedVegetableClassifications();

        Schema::table('vegetables', function (Blueprint $table) {
            // Remove the existing classification column
            $table->dropColumn('classification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vegetables', function (Blueprint $table) {
            // Add the classification column back
            $table->string('classification', 256)->nullable();

            // Drop the foreign key and the classification_id column
            $table->dropForeign(['classification_id']);
            $table->dropColumn('classification_id');
        });

        // Restore the classification data from vegetable_classifications
        $classificationMap = DB::table('vegetable_classifications')
            ->pluck('name', 'id');

        DB::table('vegetables')->get()->each(function ($vegetable) use ($classificationMap) {
            DB::table('vegetables')
                ->where('id', $vegetable->id)
                ->update(['classification' => $classificationMap[$vegetable->classification_id] ?? null]);
        });
    }

    /**
     * Seed the vegetable_classifications table and update the vegetables table.
     */
    protected function seedVegetableClassifications(): void
    {
        // Extract unique classifications from the vegetables table
        $classifications = DB::table('vegetables')
            ->select('classification')
            ->distinct()
            ->pluck('classification');

        // Insert these classifications into the vegetable_classifications table
        foreach ($classifications as $classification) {
            DB::table('vegetable_classifications')->insert([
                'name' => $classification,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Update the vegetables table to set the classification_id
        $classificationMap = DB::table('vegetable_classifications')
            ->pluck('id', 'name');

        DB::table('vegetables')->get()->each(function ($vegetable) use ($classificationMap) {
            DB::table('vegetables')
                ->where('id', $vegetable->id)
                ->update(['classification_id' => $classificationMap[$vegetable->classification]]);
        });
    }
};
