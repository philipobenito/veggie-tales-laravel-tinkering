<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vegetable;

class VegetablesEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $vegetable = Vegetable::factory()->create();

        $response = $this->get('/api/vegetables');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'name',
                             'classification',
                             'edible',
                             // Add other fields as necessary
                         ]
                     ]
                 ]);
    }

    public function testStore()
    {
        $data = [
            'name' => 'Carrot',
            'edible' => true,
        ];

        $response = $this->post('/api/vegetables', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'name' => 'Carrot',
                         'edible' => true,
                     ]
                 ]);

        $this->assertDatabaseHas('vegetables', $data);
    }

    public function testShow()
    {
        $vegetable = Vegetable::factory()->create();

        $response = $this->get("/api/vegetables/{$vegetable->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $vegetable->id,
                         'name' => $vegetable->name,
                         'classification' => $vegetable->classification,
                         'edible' => $vegetable->edible,
                     ]
                 ]);
    }

    public function testUpdate()
    {
        $vegetable = Vegetable::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'edible' => false,
        ];

        $response = $this->put("/api/vegetables/{$vegetable->id}", $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $vegetable->id,
                         'name' => 'Updated Name',
                         'edible' => false,
                     ]
                 ]);

        $this->assertDatabaseHas('vegetables', $data);
    }

    public function testDestroy()
    {
        $vegetable = Vegetable::factory()->create();
        $response = $this->delete("/api/vegetables/{$vegetable->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('vegetables', ['id' => $vegetable->id]);
    }
}
