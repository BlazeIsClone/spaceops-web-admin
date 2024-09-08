<?php

use App\Models\User;
use App\RoutePaths\Admin\AdminRoutePath;
use App\RoutePaths\Admin\Auth\AuthRoutePath;
use Illuminate\Support\Facades\Hash;

test('password can be updated', function () {
    $password = 'new-password';
    $newPassword = 'new-password';

    $user = User::factory()->create([
        'password' => Hash::make($password),
    ]);

    $response = $this
        ->actingAs($user)
        ->from(route(AdminRoutePath::PROFILE_EDIT))
        ->put(route(AuthRoutePath::PASSWORD_UPDATE), [
            'current_password' => 'password',
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route(AdminRoutePath::PROFILE_EDIT));

    $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
});

test('correct password must be provided to update password', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from(route(AdminRoutePath::PROFILE_EDIT))
        ->put(route(AuthRoutePath::PASSWORD_UPDATE), [
            'password' => 'password123',
            'password_confirmation' => 'password321',
        ]);

    $response
        ->assertSessionHasErrors()
        ->assertRedirect(route(AdminRoutePath::PROFILE_EDIT));
});
