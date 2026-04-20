<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CategoriesCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed()
            ->actingAs(User::first());
    }

    #[Test]
    public function can_store_category_and_assign_next_index(): void
    {
        $parent = Category::factory()->create([
            'order_index' => 1,
        ]);

        Category::factory()->create([
            'parent_id' => $parent->id,
            'order_index' => 1,
        ]);

        Category::factory()->create([
            'parent_id' => $parent->id,
            'order_index' => 2,
        ]);

        $this->postJson(route('administration.categories.store', [], false), [
            'name' => 'Solar',
            'parent_id' => $parent->id,
            'is_featured' => true,
        ])->assertOk()
            ->assertJsonFragment([
                'message' => __('The category was successfully created'),
                'redirect' => 'administration.categories.edit',
            ]);

        $category = Category::whereName('Solar')->firstOrFail();

        $this->assertSame($parent->id, $category->parent_id);
        $this->assertSame(3, $category->order_index);
        $this->assertTrue($category->is_featured);
    }

    #[Test]
    public function rejects_non_existent_parent_when_storing_category(): void
    {
        $this->postJson(route('administration.categories.store', [], false), [
            'name' => 'Broken',
            'parent_id' => 999999,
            'is_featured' => false,
        ])->assertUnprocessable()
            ->assertInvalid(['parent_id']);
    }

    #[Test]
    public function can_get_category_forms(): void
    {
        $category = Category::factory()->create();

        $this->getJson(route('administration.categories.create', [], false))
            ->assertOk()
            ->assertJsonStructure(['form']);

        $this->getJson(route('administration.categories.edit', $category, false))
            ->assertOk()
            ->assertJsonStructure(['form']);
    }

    #[Test]
    public function rejects_duplicate_sibling_name_on_update(): void
    {
        $parent = Category::factory()->create();

        Category::factory()->create([
            'name' => 'Existing',
            'parent_id' => $parent->id,
        ]);

        $category = Category::factory()->create([
            'name' => 'Current',
            'parent_id' => $parent->id,
        ]);

        $this->patchJson(route('administration.categories.update', $category, false), [
            'name' => 'Existing',
            'is_featured' => false,
        ])->assertUnprocessable()
            ->assertInvalid(['name']);
    }

    #[Test]
    public function can_update_and_delete_category(): void
    {
        $category = Category::factory()->create([
            'name' => 'Initial',
            'is_featured' => false,
        ]);

        $this->patchJson(route('administration.categories.update', $category, false), [
            'name' => 'Updated',
            'is_featured' => true,
        ])->assertOk()
            ->assertJsonFragment([
                'message' => __('The category has been successfully updated'),
            ]);

        $category->refresh();

        $this->assertSame('Updated', $category->name);
        $this->assertTrue($category->is_featured);

        $this->deleteJson(route('administration.categories.destroy', $category, false))
            ->assertOk()
            ->assertJsonFragment([
                'message' => __('The category was successfully deleted'),
                'redirect' => 'administration.categories.index',
            ]);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
