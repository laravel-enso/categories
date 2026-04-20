<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CategoriesMoveTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed()
            ->actingAs(User::first());
    }

    #[Test]
    public function can_move_category_and_reorder_old_and_new_siblings(): void
    {
        $fromParent = Category::factory()->create(['name' => 'From']);
        $toParent = Category::factory()->create(['name' => 'To']);

        $first = Category::factory()->create([
            'name' => 'First',
            'parent_id' => $fromParent->id,
            'order_index' => 1,
        ]);

        $moving = Category::factory()->create([
            'name' => 'Moving',
            'parent_id' => $fromParent->id,
            'order_index' => 2,
        ]);

        $third = Category::factory()->create([
            'name' => 'Third',
            'parent_id' => $fromParent->id,
            'order_index' => 3,
        ]);

        $target = Category::factory()->create([
            'name' => 'Target',
            'parent_id' => $toParent->id,
            'order_index' => 1,
        ]);

        $this->patchJson(route('administration.categories.move', $moving, false), [
            'parentId' => $toParent->id,
            'newIndex' => 1,
        ])->assertOk();

        $moving->refresh();
        $first->refresh();
        $third->refresh();
        $target->refresh();

        $this->assertSame($toParent->id, $moving->parent_id);
        $this->assertSame(1, $moving->order_index);
        $this->assertSame(1, $first->order_index);
        $this->assertSame(2, $third->order_index);
        $this->assertSame(2, $target->order_index);
    }
}
