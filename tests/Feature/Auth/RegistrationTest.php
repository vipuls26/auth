<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Role;
use App\Notifications\RegisterNotification;

uses(RefreshDatabase::class);

// check if register page work
test('registration screen can be rendered', function () {
    $response = $this->get('/register');
    $response->assertStatus(200);
});

// if role not pressent registration fails
test('registration fails if role does not exist', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'password' => 'Password123!',               // raw password
        'password_confirmation' => 'Password123!',  // must match
        'role' => 'user',
    ]);


    // user not create
    $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
});

// validation not pass
test('registration fails if validation rules are not met', function () {
    $role = Role::create(['name' => 'user']);

    $response = $this->post('/register', [
        'name' => '',                        // missing name
        'email' => 'invalid-email',          // invalid email
        'password' => 'short',               // too short / invalid
        'password_confirmation' => 'wrong',  // doesn't match
        'role' => 'user',
    ]);

    // user not create
    $this->assertDatabaseCount('users', 0);

    // validation error
    $response->assertSessionHasErrors([
        'name',
        'email',
        'password',
        'password_confirmation',
    ]);
});

// successfully create user
test('user can register successfully when role exists', function () {
    // create the role
    $role = Role::create(['name' => 'user']);

    // fake notifications
    Notification::fake();

    // Send registration request
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'role' => 'user',
    ]);

    // check if user exist
    $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);

    // fetch user from database
    $user = User::where('email', 'testuser@example.com')->first();

    // assign role to user
    $user->roles()->attach($role->id);
    $this->assertTrue($user->roles->contains($role));

    // notification
    Notification::assertSentTo($user, RegisterNotification::class);

    // success message
    $response->assertSessionHas('message', 'Registration successful');
    // redirect user to login page
    $response->assertRedirect(route('login'));
});
