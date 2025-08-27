<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new students can register but are not authenticated', function () {
    $response = $this->post('/register', [
        'name' => 'Test Student',
        'email' => 'test.student@ui.ac.id',
        'phone' => '081234567890',
        'study_program' => 'Teknik Kimia',
        'batch_year' => '2023',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    // Student registration should redirect to login with a status message
    $response->assertRedirect(route('login'));
    $response->assertSessionHas('status');
    
    // Student should not be authenticated automatically (needs verification)
    $this->assertGuest();
    
    // Check that user was created
    $this->assertDatabaseHas('users', [
        'email' => 'test.student@ui.ac.id',
        'is_verified' => false,
    ]);
});

test('registration requires valid ui.ac.id email for students', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com', // Invalid domain
        'phone' => '081234567890',
        'study_program' => 'Teknik Kimia',
        'batch_year' => '2023',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});