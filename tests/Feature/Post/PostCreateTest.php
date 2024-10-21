<?php

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can display the create post page', function () {
    $this->get(route('posts.create'))
        ->assertStatus(200)
        ->assertSee('Create New Post');
});

it('can create a new post and save as draft', function () {
    $category = Category::factory()->create();

    $postData = [
        'title' => 'Test Post',
        'content' => 'This is a test post content.',
        'category_id' => $category->id,
        'status' => 0, // Save as draft
    ];

    $this->post(route('posts.store'), $postData)
        ->assertRedirect(route('posts.index'))
        ->assertSessionHas('success', 'Post created successfully.');

    $this->assertDatabaseHas('posts', [
        'title' => 'Test Post',
        'status' => 0,
        'user_id' => $this->user->id,
    ]);
});

it('can create a new post and publish it', function () {
    $category = Category::factory()->create();

    $postData = [
        'title' => 'Published Post',
        'content' => 'This is a published post content.',
        'category_id' => $category->id,
        'status' => 1, // Publish post
    ];

    $this->post(route('posts.store'), $postData)
        ->assertRedirect(route('posts.index'))
        ->assertSessionHas('success', 'Post created successfully.');

    $this->assertDatabaseHas('posts', [
        'title' => 'Published Post',
        'status' => 1,
        'user_id' => $this->user->id,
    ]);
});

it('validates required fields when creating a post', function () {
    $this->post(route('posts.store'), [])
        ->assertSessionHasErrors(['title', 'content', 'category_id']);
});
