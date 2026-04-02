<?php

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\post;



uses(RefreshDatabase::class);

test('guest dashboard screen can be rendered', function () {

    // redirect to dashbaord
    $response = $this->get('/');

    // check response
    $response->assertStatus(200);
});


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
    // $response = $this->get('/?search=laravel');
});



test('blog add', function () {

    Storage::fake('public');

    $user = User::factory()->create();
    $role = Role::where('name', 'user')->first();
    $user->roles()->attach($role);

    $category = Category::factory()->create([
        'name' => 'technology',
    ]);


    $file = UploadedFile::fake()->image('blog.jpg');

    // dd($user,$category,$file);


    $response = post(route('blog.store'), [
        'title' => 'Test Blog',
        'content' => 'This is a test blog content.',
        'category' => $category->name,
        'image' => $file,
    ]);

        $response->assertRedirect(route('user.dashboard'));

});
