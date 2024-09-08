<?php

use App\Models\User;
use App\Notifications\Admin\AdminResetPasswordNotification;
use App\RoutePaths\Admin\Auth\AuthRoutePath;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

test('reset password link screen can be rendered', function () {
    $response = $this->get(route(AuthRoutePath::PASSWORD_FORGET));

    $response->assertStatus(200);
});

test('reset password link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    $response = $this->post(route(AuthRoutePath::PASSWORD_MAIL), ['email' => $user->email]);

    Notification::assertSentTo(
        $user,
        AdminResetPasswordNotification::class,
        function ($notification, $channels) use ($user) {
            return $notification->toMail($user)->to[0]['address'] === $user->email;
        }
    );

    $response->assertSessionHas('status', trans(Password::RESET_LINK_SENT));
});

test('reset password screen can be rendered', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route(AuthRoutePath::PASSWORD_FORGET), ['email' => $user->email]);

    Notification::assertSentTo($user, AdminResetPasswordNotification::class, function ($notification) {
        $response = $this->get(route(AuthRoutePath::PASSWORD_RESET, ['token' => $notification->token]));

        $response->assertStatus(200);

        return true;
    });
});

test('password can be reset with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route(AuthRoutePath::PASSWORD_FORGET), ['email' => $user->email]);

    Notification::assertSentTo($user, AdminResetPasswordNotification::class, function ($notification) use ($user) {
        $response = $this->post(route(AuthRoutePath::PASSWORD_STORE), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasNoErrors();

        return true;
    });
});
