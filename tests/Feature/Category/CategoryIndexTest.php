<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(); // Assuming you have a seed that creates necessary data like users or categories
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    Category::factory()->count(5)->create();
});

it('can display the category index page', function () {
    $category = Category::factory()->create([
        'name' => 'Sample Category',
    ]);

    $this->get(route('categories.index'))
        ->assertStatus(200)
        ->assertSee('Categories')
        ->assertSee('Sample Category')
        ->assertViewIs('category.index');
});

it('shows no categories available when there are none', function () {
    Category::query()->delete();

    $this->get(route('categories.index'))
        ->assertStatus(200)
        ->assertSee('No categories available');
});

it('has a create new category button', function () {
    $this->get(route('categories.index'))
        ->assertStatus(200)
        ->assertSee('Create New Category')
        ->assertSee(route('categories.create'));
});

it('displays pagination links when categories exceed the page limit', function () {
    Category::factory()->count(15)->create();

    $this->get(route('categories.index'))
        ->assertStatus(200)
        ->assertSee('Next')
        ->assertSee('Previous');
});
