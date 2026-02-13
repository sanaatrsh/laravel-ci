<?php

declare(strict_types=1);

use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
});

it('validates required fields when creating a user', function () {
    // Arrange
    $payload = [];

    // Act
    $response = $this->postJson('/api/users', $payload);

    // Assert
    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'email']);
});

it('validates email must be a valid email', function () {
    // Arrange
    $payload = [
        'name' => 'Sample name',
        'email' => 'invalid-email',
        'emailVerifiedAt' => 'test@example.com',
    ];

    // Act
    $response = $this->postJson('/api/users', $payload);

    // Assert
    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

it('validates emailVerifiedAt must be a valid email', function () {
    // Arrange
    $payload = [
        'name' => 'Sample name',
        'email' => 'test@example.com',
        'emailVerifiedAt' => 'invalid-email',
    ];

    // Act
    $response = $this->postJson('/api/users', $payload);

    // Assert
    $response->assertStatus(422)
        ->assertJsonValidationErrors(['emailVerifiedAt']);
});

it('validates emailVerifiedAt must be a valid date format', function () {
    // Arrange
    $payload = [
        'name' => 'Sample name',
        'email' => 'test@example.com',
        'emailVerifiedAt' => 'invalid-date',
    ];

    // Act
    $response = $this->postJson('/api/users', $payload);

    // Assert
    $response->assertStatus(422)
        ->assertJsonValidationErrors(['emailVerifiedAt']);
});
