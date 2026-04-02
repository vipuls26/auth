<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Role;

uses(RefreshDatabase::class);

// login screen
test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

// invalid password
test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});

// user login
test('user can login to their dashboard', function () {

    // add user role
    $role = Role::where('name', 'user')->first();

    // create user
    $user = User::factory()->create([
        'email' => 'testuser@gmail.com',
        'password' => bcrypt('Password123!'),
    ]);

    // attach role woth user
    $user->roles()->attach($role);

    // attempt login
    $response = $this->post('/login', [
        'email' => 'testuser@gmail.com',
        'password' => 'Password123!'
    ]);

    // ensure user is authenticate
    $this->assertAuthenticatedAs($user);

    // redirect to login
    $response->assertRedirect(route('user.dashboard'));
    auth()->logout();
});

// admin login
test('admin can login to their dashboard', function () {

    // add user role
    $role = Role::where('name', 'admin')->first();

    // create user
    $user = User::factory()->create([
        'email' => 'testuser@gmail.com',
        'password' => bcrypt('Password123!'),
    ]);

    // attach role woth user
    $user->roles()->attach($role);

    // attempt login
    $response = $this->post('/login', [
        'email' => 'testuser@gmail.com',
        'password' => 'Password123!'
    ]);

    // ensure user is authenticate
    $this->assertAuthenticatedAs($user);

    // redirect to login
    $response->assertRedirect(route('admin.dashboard'));
    auth()->logout();
});

// superadmin login
test('superadminadmin can login to their dashboard', function () {

    // add user role
    $role = Role::where('name', 'superadmin')->first();

    // create user
    $user = User::factory()->create([
        'email' => 'testuser@gmail.com',
        'password' => bcrypt('Password123!'),
    ]);

    // attach role woth user
    $user->roles()->attach($role);

    // attempt login
    $response = $this->post('/login', [
        'email' => 'testuser@gmail.com',
        'password' => 'Password123!'
    ]);

    // ensure user is authenticate
    $this->assertAuthenticatedAs($user);

    // redirect to login
    $response->assertRedirect(route('superadmin.dashboard'));
    auth()->logout();
});
