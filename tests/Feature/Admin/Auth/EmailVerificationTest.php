<?php

use App\Models\User;
use App\RoutePaths\Admin\Auth\AuthRoutePath;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

test('email verification screen can be rendered', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $response = $this->actingAs($user)->get(
        route(AuthRoutePath::VERIFICATION_NOTICE)
    );

    $response->assertStatus(200);
});

test('email can be verified', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        AuthRoutePath::VERIFICATION_VERIFY,
        Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
        [
            'id' => $user->getKey(),
            'hash' => sha1($user->email)
        ]
    );

    $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

test('email is not verified with invalid hash', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $verificationUrl = URL::temporarySignedRoute(
        AuthRoutePath::VERIFICATION_VERIFY,
        Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
        [
            'id' => $user->getKey(),
            'hash' => sha1('fake-email')
        ]
    );

    $this->actingAs($user)->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});
