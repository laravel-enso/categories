<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CategoriesIndexOptionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed()
            ->actingAs(User::first());
    }

    #[Test]
    public function returns_nested_tree_payload_on_index(): void
    {
        $parent = Category::factory()->create([
            'name' => 'Parent',
            'parent_id' => null,
        ]);

        Category::factory()->create([
            'name' => 'Child',
            'parent_id' => $parent->id,
            'order_index' => 1,
        ]);

        $this->getJson(route('administration.categories.index', [], false))
            ->assertOk()
            ->assertJsonStructure([
                'maxNestingLevel',
                'items' => [
                    '*' => ['id', 'name', 'orderIndex', 'isFeatured', 'selected', 'items', 'image'],
                ],
            ])
            ->assertJsonFragment([
                'id' => $parent->id,
                'name' => 'Parent',
            ])
            ->assertJsonFragment([
                'name' => 'Child',
            ]);
    }

    #[Test]
    public function returns_breadcrumb_labels_in_options(): void
    {
        $parent = Category::factory()->create(['name' => 'Parent']);
        $child = Category::factory()->create([
            'name' => 'Child',
            'parent_id' => $parent->id,
        ]);

        $this->getJson(route('administration.categories.options', [], false))
            ->assertOk()
            ->assertJsonFragment([
                'id' => $child->id,
                'name' => 'Parent > Child',
            ]);
    }
}
