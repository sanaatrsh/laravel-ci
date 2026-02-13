<?php

declare(strict_types=1);

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Mrmarchone\LaravelAutoCrud\Enums\ResponseMessages;

beforeEach(function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
});

it('lists users', function () {
    User::factory()->count(3)->create();

    $response = $this->getJson('/api/users');

    $response->assertOk()->assertJsonPath('message', ResponseMessages::RETRIEVED->message());
    expect($response->json('data'))->toBeArray();

    $data = $response->json('data');
    if (! empty($data)) {
        $firstItem = $data[0];
        expect($firstItem['id'])->toBeInt()
            ->and($firstItem)->toHaveKey('name')
            ->and($firstItem)->toHaveKey('email')
            ->and($firstItem)->toHaveKey('emailVerifiedAt');
    }
});

it('creates a user', function () {
    $payload = [
        'name' => 'Sample name',
        'email' => 'test@example.com',
        'emailVerifiedAt' => 'test@example.com',
    ];

    $response = $this->postJson('/api/users', $payload);
    $response->assertCreated()->assertJsonPath('message', ResponseMessages::CREATED->message());
    $id = $response->json('data.id');
    $this->assertDatabaseHas('users', ['id' => $id]);
});

it('shows a user', function () {
    $user = User::factory()->create();

    $response = $this->getJson("/api/users/{$user->id}");
    $response->assertOk()
        ->assertJsonPath('message', ResponseMessages::RETRIEVED->message());

    $data = $response->json('data');

    expect($data['id'])->toBeInt()
        ->and($data)->toHaveKey('name')
        ->and($data)->toHaveKey('email')
        ->and($data)->toHaveKey('emailVerifiedAt');
});

it('updates a user', function () {
    $user = User::factory()->create();

    $updatePayload = [
        'name' => 'Sample name updated',
        'email' => 'test_updated@example.com',
        'emailVerifiedAt' => 'test_updated@example.com',
    ];

    $response = $this->putJson("/api/users/{$user->id}", $updatePayload);
    $response->assertOk()
        ->assertJsonPath('message', ResponseMessages::UPDATED->message());
});

it('deletes a user', function () {
    $user = User::factory()->create();

    $response = $this->deleteJson("/api/users/{$user->id}");
    $response->assertOk()
        ->assertJsonPath('message', ResponseMessages::DELETED->message());

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});
it('returns 404 when showing non-existent user', function () {
    // Arrange
    $nonExistentId = 99999;

    // Act
    $response = $this->getJson('/api/users/'.$nonExistentId);

    // Assert
    $response->assertNotFound();
});

it('returns 404 when updating non-existent user', function () {
    // Arrange
    $nonExistentId = 99999;
    $payload = [
        'name' => 'Sample name updated',
        'email' => 'test_updated@example.com',
        'emailVerifiedAt' => 'test_updated@example.com',
        'password' => 'Sample password updated',
        'rememberToken' => 'Sample remember_token updated',
    ];

    // Act
    $response = $this->putJson('/api/users/'.$nonExistentId, $payload);

    // Assert
    $response->assertNotFound();
});

it('returns 404 when deleting non-existent user', function () {
    // Arrange
    $nonExistentId = 99999;

    // Act
    $response = $this->deleteJson('/api/users/'.$nonExistentId);

    // Assert
    $response->assertNotFound();
});
