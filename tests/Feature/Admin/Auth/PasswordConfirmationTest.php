<?php

use App\Models\User;
use App\RoutePaths\Admin\Auth\AuthRoutePath;
use Illuminate\Support\Facades\Hash;

test('confirm password screen can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route(AuthRoutePath::PASSWORD_CONFIRM));

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $email = 'test@example.com';
    $password = 'secret123';

    $user = User::factory()->create([
        'email' => $email,
        'password' => Hash::make($password),
    ]);

    $response = $this->actingAs($user)->post(route(AuthRoutePath::PASSWORD_CONFIRM), [
        'email' => $email,
        'password' => $password,
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $email = 'test@example.com';

    $user = User::factory()->create([
        'email' => $email,
        'password' => Hash::make('secret123'),
    ]);

    $response = $this->actingAs($user)->post(route(AuthRoutePath::PASSWORD_CONFIRM), [
        'email' => $email,
        'password' => 'secret321',
    ]);

    $response->assertSessionHasErrors();
});
