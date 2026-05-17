<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('login screen can be rendered at auth path', function () {
    $response = $this->get('/auth/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create([
        'role' => 'customer',
    ]);

    $response = $this->post('/login', [
        'login' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect('/');
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create([
        'role' => 'customer',
    ]);

    $this->post('/login', [
        'login' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create([
        'role' => 'customer',
    ]);

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect(route('login', absolute: false));
});
