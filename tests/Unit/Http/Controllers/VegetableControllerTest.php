<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\VegetableController;
use App\Models\Vegetable;
use App\Http\Requests\VegetableRequest;
use App\Http\Resources\VegetableResource;
use Mockery;
use Tests\TestCase;

class VegetableControllerTest extends TestCase
{
    protected $vegetableMock;
    protected $vegetableResourceMock;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->vegetableMock = Mockery::mock(Vegetable::class);
        $this->vegetableResourceMock = Mockery::mock(VegetableResource::class);

        $this->controller = new VegetableController($this->vegetableMock, $this->vegetableResourceMock);
    }

    public function testIndex()
    {
        $requestMock = Mockery::mock(VegetableRequest::class);
        $requestMock->shouldReceive('merge')->with(['with' => 'classification']);
        $requestMock->shouldReceive('query')->with('with', '')->andReturn('classification');
        $queryMock = Mockery::mock('Illuminate\Database\Eloquent\Builder');
        $queryMock->shouldReceive('applyFilters')->andReturnSelf();
        $queryMock->shouldReceive('applySorting')->andReturnSelf();
        $queryMock->shouldReceive('get')->andReturn(collect([]));
        $queryMock->shouldReceive('with')->with(['classification'])->andReturnSelf();

        $this->vegetableMock->shouldReceive('query')->andReturn($queryMock);
        $this->vegetableResourceMock->shouldReceive('collection')->andReturn([]);

        $response = $this->controller->index($requestMock);
        $this->assertIsArray($response);
    }

    public function testStore()
    {
        $requestMock = Mockery::mock(VegetableRequest::class);
        $requestMock->shouldReceive('validated')->andReturn(['name' => 'Carrot']);
        $this->vegetableMock->shouldReceive('create')->andReturn($this->vegetableMock);
        $this->vegetableResourceMock->shouldReceive('make')->andReturn([]);

        $response = $this->controller->store($requestMock);
        $this->assertIsArray($response);
    }

    public function testShow()
    {
        $vegetableMock = Mockery::mock(Vegetable::class);
        $vegetableMock->shouldReceive('load')->with('classification')->andReturnSelf();
        $this->vegetableResourceMock->shouldReceive('make')->andReturn([]);

        $response = $this->controller->show($vegetableMock);
        $this->assertIsArray($response);
    }

    public function testUpdate()
    {
        $requestMock = Mockery::mock(VegetableRequest::class);
        $requestMock->shouldReceive('validated')->andReturn(['name' => 'Updated Carrot']);
        $vegetableMock = Mockery::mock(Vegetable::class);
        $vegetableMock->shouldReceive('update')->andReturn(true);
        $this->vegetableResourceMock->shouldReceive('make')->andReturn([]);

        $response = $this->controller->update($requestMock, $vegetableMock);
        $this->assertIsArray($response);
    }

    public function testDestroy()
    {
        $vegetableMock = Mockery::mock(Vegetable::class);
        $vegetableMock->shouldReceive('delete')->andReturn(true);

        $response = $this->controller->destroy($vegetableMock);
        $this->assertEquals(204, $response->getStatusCode());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
