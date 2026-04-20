<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\Categories\Models\Category;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CategoriesCategoryTest extends TestCase
{
    use RefreshDatabase;

    private Category $parent;
    private Category $middle;
    private Category $leaf;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parent = Category::factory()->create();
        $this->middle = Category::factory()->create(['parent_id' => $this->parent->id]);
        $this->leaf = Category::factory()->create(['parent_id' => $this->middle->id]);
    }

    #[Test]
    public function can_get_level(): void
    {
        $this->assertSame(0, $this->parent->level());
        $this->assertSame(1, $this->middle->level());
        $this->assertSame(2, $this->leaf->level());
    }

    #[Test]
    public function can_get_depth(): void
    {
        $this->assertSame(2, $this->parent->depth());
        $this->assertSame(1, $this->middle->depth());
        $this->assertSame(0, $this->leaf->depth());
    }

    #[Test]
    public function can_get_flatten(): void
    {
        $this->assertSame([1, 2, 3], $this->parent->flattenCurrentAndBelowIds()->toArray());
        $this->assertSame([2, 3], $this->middle->flattenCurrentAndBelowIds()->toArray());
        $this->assertSame([3], $this->leaf->flattenCurrentAndBelowIds()->toArray());
    }

    #[Test]
    public function can_get_parent_tree(): void
    {
        $this->assertSame([], $this->parent->parentTree()->map->id->toArray());
        $this->assertSame([1], $this->middle->parentTree()->map->id->toArray());
        $this->assertSame([1, 2], $this->leaf->parentTree()->map->id->toArray());
    }

    #[Test]
    public function featured_top_level_and_contains_scopes_return_expected_categories(): void
    {
        $featuredTopLevel = Category::factory()->create([
            'name' => 'Featured Top',
            'parent_id' => null,
            'is_featured' => true,
        ]);

        $nestedFeatured = Category::factory()->create([
            'name' => 'Nested Featured',
            'parent_id' => $this->parent->id,
            'is_featured' => true,
        ]);

        $topLevelIds = Category::query()->topLevel()->pluck('id')->all();
        $featuredIds = Category::query()->featured()->pluck('id')->all();
        $containsIds = Category::query()->contains('subcategories')->pluck('id')->all();

        $this->assertContains($featuredTopLevel->id, $topLevelIds);
        $this->assertNotContains($nestedFeatured->id, $topLevelIds);
        $this->assertContains($featuredTopLevel->id, $featuredIds);
        $this->assertContains($nestedFeatured->id, $featuredIds);
        $this->assertContains($this->parent->id, $containsIds);
        $this->assertContains($this->middle->id, $containsIds);
        $this->assertNotContains($this->leaf->id, $containsIds);
    }
}
