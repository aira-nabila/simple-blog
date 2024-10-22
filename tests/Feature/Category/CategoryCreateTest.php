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

it('can create a new category', function () {
    $categoryData = [
        'name' => 'New Category',
        'parent_id' => null,
    ];

    $this->post(route('categories.store'), $categoryData)
        ->assertRedirect(route('categories.index'))
        ->assertSessionHas('success', 'Category created successfully.');

    $this->assertDatabaseHas('categories', [
        'name' => 'New Category',
    ]);
});

it('validates category creation fields', function () {
    $this->post(route('categories.store'), [])
        ->assertSessionHasErrors(['name']);
});

it('can create a category with a parent', function () {
    $parentCategory = Category::factory()->create(['name' => 'Parent Category']);

    $categoryData = [
        'name' => 'Child Category',
        'parent_id' => $parentCategory->id,
    ];

    $this->post(route('categories.store'), $categoryData)
        ->assertRedirect(route('categories.index'))
        ->assertSessionHas('success', 'Category created successfully.');

    $this->assertDatabaseHas('categories', [
        'name' => 'Child Category',
        'parent_id' => $parentCategory->id,
    ]);
});
