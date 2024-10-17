<?php

namespace Tests\Unit\Traits;

use Mockery;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Traits\Filterable;

class FilterableTest extends TestCase
{
    protected $query;
    protected $request;
    protected $filterable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->query = Mockery::mock(Builder::class);
        $this->request = Mockery::mock(Request::class);

        $this->filterable = new class {
            use Filterable;

            public function applyFilters(Builder $query, Request $request, array $filterable): Builder
            {
                return $this->scopeApplyFilters($query, $request, $filterable);
            }

            public function applySorting(Builder $query, Request $request): Builder
            {
                return $this->scopeApplySorting($query, $request);
            }
        };
    }

    public function testApplyFilters()
    {
        $this->request->shouldReceive('has')
                      ->with('name')
                      ->andReturn(true);

        $this->request->shouldReceive('has')
                      ->with('classification')
                      ->andReturn(false);

        $this->request->shouldReceive('input')
                      ->with('name')
                      ->andReturn('carrot');

        $this->query->shouldReceive('where')
                    ->with('name', 'like', '%carrot%')
                    ->andReturnSelf();

        $result = $this->filterable->applyFilters($this->query, $this->request, ['name', 'classification']);
        $this->assertInstanceOf(Builder::class, $result);
    }

    public function testApplySorting()
    {
        $this->request->shouldReceive('has')
                      ->with('sort_by')
                      ->andReturn(true);

        $this->request->shouldReceive('input')
                      ->with('sort_by')
                      ->andReturn('name');

        $this->request->shouldReceive('input')
                      ->with('sort_order', 'asc')
                      ->andReturn('desc');

        $this->query->shouldReceive('orderBy')
                    ->with('name', 'desc')
                    ->andReturnSelf();

        $result = $this->filterable->applySorting($this->query, $this->request);
        $this->assertInstanceOf(Builder::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
