<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(); // Assuming you have a seed that creates necessary data like users or categories
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can delete a category that is not associated with any posts', function () {
    $category = Category::factory()->create(['name' => 'Category to Delete']);

    $this->delete(route('categories.destroy', $category))
        ->assertRedirect(route('categories.index'))
        ->assertSessionHas('success', 'Category deleted successfully.');

    $this->assertDatabaseMissing('categories', [
        'id' => $category->id,
    ]);
});

it('cannot delete a category that is associated with posts', function () {
    $category = Category::factory()->create(['name' => 'Category with Posts']);
    Post::factory()->create(['category_id' => $category->id]);

    $this->delete(route('categories.destroy', $category))
        ->assertRedirect(route('categories.index'))
        ->assertSessionHas('error', 'Category cannot be deleted because it is associated with existing posts.');

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
    ]);
});
