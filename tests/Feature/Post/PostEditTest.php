<?php

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->category = Category::factory()->create();
    $this->post = Post::factory()->create([
        'user_id' => $this->user->id,
        'category_id' => $this->category->id,
    ]);
});

it('can display the edit post page', function () {
    $this->get(route('posts.edit', $this->post))
        ->assertStatus(200)
        ->assertSee('Edit Post')
        ->assertSee($this->post->title)
        ->assertSee($this->category->name);
});

it('can update a post and save as draft', function () {
    $updatedData = [
        'title' => 'Updated Post Title',
        'content' => 'This is the updated content of the post.',
        'category_id' => $this->category->id,
        'status' => 0, // Save as draft
    ];

    $this->put(route('posts.update', $this->post), $updatedData)
        ->assertRedirect(route('posts.index'))
        ->assertSessionHas('success', 'Post updated successfully.');

    $this->assertDatabaseHas('posts', [
        'id' => $this->post->id,
        'title' => 'Updated Post Title',
        'status' => 0,
        'user_id' => $this->user->id,
    ]);
});

it('can update a post and publish it', function () {
    $updatedData = [
        'title' => 'Published Post Title',
        'content' => 'This is the published content of the post.',
        'category_id' => $this->category->id,
        'status' => 1, // Publish post
    ];

    $this->put(route('posts.update', $this->post), $updatedData)
        ->assertRedirect(route('posts.index'))
        ->assertSessionHas('success', 'Post updated successfully.');

    $this->assertDatabaseHas('posts', [
        'id' => $this->post->id,
        'title' => 'Published Post Title',
        'status' => 1,
        'user_id' => $this->user->id,
    ]);
});

it('validates required fields when updating a post', function () {
    $this->put(route('posts.update', $this->post), [])
        ->assertSessionHasErrors(['title', 'content', 'category_id']);
});
