<?php

use App\Models\Role;
use App\Models\User;

// display superadmin dashboard
test('superadmin dashboard screen can be rendered', function () {

    // create new user
    $user = User::factory()->create();
    // create role with user
    $role = Role::create(['name' => 'superadmin']);
    // find created user
    $user = User::where('email', $user->email)->first();
    // assign role to user
    $user->roles()->attach($role->id);

    // check if user has role
    $this->assertTrue($user->roles->contains($role));

    // redirect to dashbaord
    $response = $this->actingAs($user)
        ->get(route('superadmin.dashboard'));

    // check response
    $response->assertStatus(200);
});
