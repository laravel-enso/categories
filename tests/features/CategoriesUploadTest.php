<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CategoriesUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed()
            ->actingAs(User::first());
    }

    #[Test]
    public function rejects_nested_category_image_upload(): void
    {
        $parent = Category::factory()->create();
        $child = Category::factory()->create([
            'parent_id' => $parent->id,
        ]);

        $this->post(route('administration.categories.upload', $child, false), [
            'image' => UploadedFile::fake()->image('category.png'),
        ])->assertSessionHasErrors(['image_id']);
    }
}
