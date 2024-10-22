<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(); // Assuming you have a seed that creates necessary data like users or categories
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can update an existing category', function () {
    $category = Category::factory()->create(['name' => 'Old Category Name']);

    $updatedData = [
        'name' => 'Updated Category Name',
        'parent_id' => null,
    ];

    $this->put(route('categories.update', $category), $updatedData)
        ->assertRedirect(route('categories.index'))
        ->assertSessionHas('success', 'Category updated successfully.');

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Updated Category Name',
    ]);
});

it('validates category update fields', function () {
    $category = Category::factory()->create();

    $this->put(route('categories.update', $category), ['name' => ''])
        ->assertSessionHasErrors(['name']);
});

it('can update a category with a new parent', function () {
    $parentCategory = Category::factory()->create(['name' => 'Parent Category']);
    $category = Category::factory()->create(['name' => 'Child Category']);

    $updatedData = [
        'name' => 'Updated Child Category',
        'parent_id' => $parentCategory->id,
    ];

    $this->put(route('categories.update', $category), $updatedData)
        ->assertRedirect(route('categories.index'))
        ->assertSessionHas('success', 'Category updated successfully.');

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Updated Child Category',
        'parent_id' => $parentCategory->id,
    ]);
});
