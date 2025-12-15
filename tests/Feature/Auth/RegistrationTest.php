<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone_number' => '+371 12345678',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('phone number is required', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors('phone_number');
});

test('phone number must be valid format', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone_number' => 'geaaegae',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors('phone_number');
});

test('phone number accepts valid formats', function () {
    $validNumbers = [
        '+371 12345678',
        '12345678',
        '+371-1234-5678',
        '(371) 12345678',
        '+371 2345 6789',
    ];

    foreach ($validNumbers as $index => $phoneNumber) {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test' . $index . time() . '@example.com',
            'phone_number' => $phoneNumber,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticated();

        auth()->logout();
    }
});

test('phone number must be at least 8 characters', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone_number' => '1234567',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors('phone_number');
});
