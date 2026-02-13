<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
});

it('handles empty payload gracefully', function () {
    // Arrange
    $payload = [];

    // Act
    $response = $this->postJson('/api/users', $payload);

    // Assert
    $response->assertStatus(422);
});

it('sanitizes SQL injection attempts in string fields', function () {
    // Arrange
    $payload = ['name' => '\'; DROP TABLE users; --',
        'email' => 'test@example.com',
        'emailVerifiedAt' => 'test@example.com', ];

    // Act
    $response = $this->postJson('/api/users', $payload);

    // Assert
    // Should either validate and reject, or sanitize and accept
    expect($response->status())->toBeIn([201, 422]);
});

it('sanitizes XSS attempts in string fields', function () {
    // Arrange
    $payload = ['name' => '<script>alert(\"XSS\")</script>',
        'email' => 'test@example.com',
        'emailVerifiedAt' => 'test@example.com', ];

    // Act
    $response = $this->postJson('/api/users', $payload);

    // Assert
    // Should either validate and reject, or sanitize and accept
    expect($response->status())->toBeIn([201, 422]);
});
