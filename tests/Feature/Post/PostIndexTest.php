<?php

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    $this->seed(); // Assuming you have a seed that creates necessary data like users or categories
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('displays the posts index page', function () {
    $post = Post::factory()->create([
        'title' => 'Sample Post',
        'category_id' => Category::factory()->create()->id,
        'user_id' => $this->user->id,
    ]);

    $this->get(route('posts.index'))
        ->assertStatus(200)
        ->assertSee('Posts')
        ->assertSee('Sample Post')
        ->assertSee($post->category->name)
        ->assertSee($post->user->name);
});

it('shows no posts available when there are none', function () {
    Post::query()->delete();

    $this->get(route('posts.index'))
        ->assertStatus(200)
        ->assertSee('No posts available');
});

it('has a create new post button', function () {
    $this->get(route('posts.index'))
        ->assertStatus(200)
        ->assertSee('Create New Post')
        ->assertSee(route('posts.create'));
});

it('displays pagination links when posts exceed the page limit', function () {
    Post::factory()->count(15)->create();

    $this->get(route('posts.index'))
        ->assertStatus(200)
        ->assertSee('Next')
        ->assertSee('Previous');
});
