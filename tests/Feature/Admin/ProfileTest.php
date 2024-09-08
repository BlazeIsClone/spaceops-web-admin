<?php

use App\Models\User;
use App\RoutePaths\Admin\AdminRoutePath;
use App\RoutePaths\Admin\Auth\AuthRoutePath;
use Illuminate\Support\Facades\Hash;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route(AdminRoutePath::PROFILE_EDIT));

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $name = 'Test User';
    $email = 'test@example.com';

    $response = $this
        ->actingAs($user)
        ->patch(route(AdminRoutePath::PROFILE_EDIT), [
            'name' => $name,
            'email' => $email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route(AdminRoutePath::PROFILE_EDIT));

    $user->refresh();

    $this->assertSame($name, $user->name);
    $this->assertSame($email, $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch(route(AdminRoutePath::PROFILE_EDIT), [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route(AdminRoutePath::PROFILE_EDIT));

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $password = 'secret123';

    $user = User::factory()->create([
        'password' => Hash::make($password),
    ]);

    $response = $this
        ->actingAs($user)
        ->delete(route(AdminRoutePath::PROFILE_DESTROY), [
            'password' => $password,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route(AuthRoutePath::LOGIN));

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $password = 'secret123';

    $user = User::factory()->create([
        'password' => Hash::make($password),
    ]);

    $response = $this
        ->actingAs($user)
        ->from(route(AdminRoutePath::PROFILE_EDIT))
        ->delete(route(AdminRoutePath::PROFILE_DESTROY), [
            'password' => 'secret321',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect(route(AdminRoutePath::PROFILE_EDIT));

    $this->assertNotNull($user->fresh());
});
