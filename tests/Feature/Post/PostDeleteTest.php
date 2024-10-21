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

it('can delete a post', function () {
    $this->delete(route('posts.destroy', $this->post))
        ->assertRedirect(route('posts.index'))
        ->assertSessionHas('success', 'Post deleted successfully.');

    $this->assertDatabaseMissing('posts', [
        'id' => $this->post->id,
    ]);
});
