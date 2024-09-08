<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\RoutePaths\Admin\Auth\AuthRoutePath;
use Illuminate\Support\Facades\Hash;

test('login screen can be rendered', function () {
    $response = $this->get(route(AuthRoutePath::LOGIN));

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $password = 'secret123';

    $user = User::factory()->create([
        'password' => Hash::make($password),
    ]);

    $response = $this->post(route(AuthRoutePath::LOGIN_STORE), [
        'email' => $user->email,
        'password' => $password,
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('secret123'),
    ]);

    $this->post(route(AuthRoutePath::LOGIN_STORE), [
        'email' => $user->email,
        'password' => 'secret321',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route(AuthRoutePath::LOGOUT));

    $this->assertGuest();
    $response->assertRedirect(route(AuthRoutePath::LOGIN));
});
