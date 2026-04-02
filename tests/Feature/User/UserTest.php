<?php

use App\Models\Blog;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user dashboard screen can be rendered', function () {

    // create new user
    $user = User::factory()->create();
    // create role with user
    $role = Role::create(['name' => 'user']);
    // find created user
    $user = User::where('email', $user->email)->first();
    // assign role to user
    $user->roles()->attach($role->id);

    // check if user has role
    $this->assertTrue($user->roles->contains($role));

    // redirect to dashbaord
    $response = $this->actingAs($user)
        ->get(route('user.dashboard'));

    // check response
    $response->assertStatus(200);
});

test('fetch category on dashboard', function () {

    // create use
    $user = User::factory()->create();

    // category
    $category = Category::all();

    $this->assertCount(7, $category);
    $this->assertInstanceOf(Category::class, $category->first());
});


test('fetch blog on dashboard', function () {

    $user = User::factory()->create();

    $role = Role::create(['name' => 'user']);
    // find created user
    $user = User::where('email', $user->email)->first();
    // assign role to user
    $user->roles()->attach($role->id);

    $blogs = Blog::factory()->create();

    // redirect to dashbaord
    $response = $this->actingAs($user)
        ->get(route('user.dashboard'));

    // check response
    $response->assertStatus(200);
});


