<?php

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Category;
use App\Models\ImageUpload;

uses(RefreshDatabase::class);

// guest user blog display
test('guest dashboard screen can be rendered', function () {

    // redirect to dashbaord
    $response = $this->get('/');

    // check response
    $response->assertStatus(200);
});

// serch result display
test('search result on display dashboard', function () {

    $matchingResult = Blog::factory()->create(['title' => 'laravel']);
    $otherResult = Blog::factory()->create(['title' => 'apple']);

    // redirect to dashbaord
    $response = $this->get('/');

    $response->assertStatus(200);

    $response = $this->get('/?search=laravel');

    $response->assertSee($matchingResult->title);
    $response->assertDontSee($otherResult->title);
});

// no result found
test('search not found', function () {

    $noResult = Blog::factory()->create(['title' => 'apple']);

    $response = $this->get('/');

    $response->assertStatus(200);
    // $response->assertSee('No results found');
});

// blog add testing
test('blog validation test', function () {

    $user = User::factory()->create();

    $this->actingAs($user);

    Blog::factory()->create();

    $response = $this->post('/blog/store', [
        'title' => '',
        'content' => '',
        'category' => '',
        'image' => null,
    ]);

    $response->assertSessionHasErrors([
        'title',
        'content',
        'category',
        'image',
    ]);

    $this->assertDatabaseCount('blogs', 1);

    // $response->assertStatus(200);
});

// blog update testing
test('blog update validation test', function () {

    // create user
    $user = User::factory()->create();

    // act user as real one
    $this->actingAs($user);

    // create category
    $category = Category::factory()->create([
        'name' => 'science'
    ]);

    // create blog
    $blog = Blog::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    // send invalid data
    $response = $this->put("/blog/{$blog->id}/updateBlog", [
        'title' => '',
        'content' => '',
        'category' => '',
        'image' => null,
    ]);

    // error response
    $response->assertSessionHasErrors([
        'title',
        'content',
        'category',
        'image',
    ]);

    // blog not update
    $this->assertDatabaseHas('blogs', [
        'id' => $blog->id,
        'title' => $blog->title,
    ]);
});

// blog delete testing
test('user can delete their blog', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    // create blog
    $blog = Blog::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    // request for deleteing blog
    $response = $this->delete(route('blog.delete', $blog->id));

    $response->assertStatus(302);

    // check redirection
    $response->assertRedirect(route('user.dashboard'));

    // check database
    $this->assertDatabaseMissing('blogs', [
        'id' => $blog->id,
    ]);
});

// blog detail test case
test('user can view blog detail', function () {

    // for category create
    $category = Category::factory()->create();

    // for blog create
    $blog = Blog::factory()->create([
        'category_id' => $category->id,
    ]);

    // for image relation
    $image = ImageUpload::factory()->create([
        'blog_id' => $blog->id,
    ]);

    // send request
    $response = $this->get(route('blog.detail', $blog->id));

    // check response status
    $response->assertStatus(200);
});
