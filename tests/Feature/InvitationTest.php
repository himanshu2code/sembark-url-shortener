<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_invite_an_admin_to_a_company(): void
    {
        $company = Company::create([
            'name' => 'Test Company',
        ]);

        $superAdmin = User::factory()->create([
            'role' => 'SuperAdmin',
            'company_id' => null,
        ]);

        $response = $this->actingAs($superAdmin)->postJson(
            '/invitations',
            [
                'email' => 'admin@example.com',
                'role' => 'Admin',
                'company_id' => $company->id,
            ]
        );

        $response->assertCreated();

        $this->assertDatabaseHas('invitations', [
            'email' => 'admin@example.com',
            'role' => 'Admin',
            'company_id' => $company->id,
            'invited_by' => $superAdmin->id,
        ]);
    }

    public function test_admin_can_invite_a_member_to_their_company(): void
    {
        $company = Company::create([
            'name' => 'Test Company',
        ]);

        $admin = User::factory()->create([
            'role' => 'Admin',
            'company_id' => $company->id,
        ]);

        $response = $this->actingAs($admin)->postJson(
            '/invitations',
            [
                'email' => 'member@example.com',
                'role' => 'Member',
            ]
        );

        $response->assertCreated();

        $this->assertDatabaseHas('invitations', [
            'email' => 'member@example.com',
            'role' => 'Member',
            'company_id' => $company->id,
            'invited_by' => $admin->id,
        ]);
    }

    public function test_member_cannot_send_invitations(): void
    {
        $company = Company::create([
            'name' => 'Test Company',
        ]);

        $member = User::factory()->create([
            'role' => 'Member',
            'company_id' => $company->id,
        ]);

        $response = $this->actingAs($member)->postJson(
            '/invitations',
            [
                'email' => 'another@example.com',
                'role' => 'Member',
            ]
        );

        $response->assertForbidden();
    }

    public function test_invitation_registration_creates_the_invited_user(): void
    {
        $company = Company::create([
            'name' => 'Test Company',
        ]);

        $superAdmin = User::factory()->create([
            'role' => 'SuperAdmin',
            'company_id' => null,
        ]);

        $invitation = Invitation::create([
            'email' => 'newadmin@example.com',
            'role' => 'Admin',
            'company_id' => $company->id,
            'invited_by' => $superAdmin->id,
            'token' => 'test-invitation-token',
            'expires_at' => now()->addDays(7),
        ]);

        $response = $this->post(
            '/invitations/' . $invitation->token . '/register',
            [
                'name' => 'New Admin',
                'password' => 'SecurePassword123',
                'password_confirmation' => 'SecurePassword123',
            ]
        );

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'name' => 'New Admin',
            'email' => 'newadmin@example.com',
            'role' => 'Admin',
            'company_id' => $company->id,
        ]);

        $this->assertDatabaseHas('invitations', [
            'id' => $invitation->id,
            'accepted_at' => now()->toDateTimeString(),
        ]);
    }

    
    public function test_expired_invitation_cannot_be_accepted_or_registered(): void
    {
        $company = Company::create([
            'name' => 'Expired Invitation Company',
        ]);

        $superAdmin = User::factory()->create([
            'role' => 'SuperAdmin',
            'company_id' => null,
        ]);

        $invitation = Invitation::create([
            'email' => 'expired@example.com',
            'role' => 'Admin',
            'company_id' => $company->id,
            'invited_by' => $superAdmin->id,
            'token' => 'expired-invitation-token',
            'expires_at' => now()->subDay(),
        ]);

        // Expired invitation page must not open.
        $this->get('/invitations/' . $invitation->token)
            ->assertNotFound();

        // Expired invitation must not create an account.
        $this->post('/invitations/' . $invitation->token . '/register', [
            'name' => 'Expired Admin',
            'password' => 'SecurePassword123',
            'password_confirmation' => 'SecurePassword123',
        ])->assertNotFound();

        $this->assertDatabaseMissing('users', [
            'email' => 'expired@example.com',
        ]);
    }

    public function test_accepted_invitation_cannot_be_used_again(): void
    {
        $company = Company::create([
            'name' => 'Accepted Invitation Company',
        ]);

        $superAdmin = User::factory()->create([
            'role' => 'SuperAdmin',
            'company_id' => null,
        ]);

        $invitation = Invitation::create([
            'email' => 'accepted@example.com',
            'role' => 'Admin',
            'company_id' => $company->id,
            'invited_by' => $superAdmin->id,
            'token' => 'already-accepted-token',
            'expires_at' => now()->addDays(7),
            'accepted_at' => now(),
        ]);

        // Accepted invitation page must not open again.
        $this->get('/invitations/' . $invitation->token)
            ->assertNotFound();

        // The same invitation cannot register another account.
        $this->post('/invitations/' . $invitation->token . '/register', [
            'name' => 'Another Admin',
            'password' => 'SecurePassword123',
            'password_confirmation' => 'SecurePassword123',
        ])->assertNotFound();

        $this->assertDatabaseMissing('users', [
            'email' => 'accepted@example.com',
        ]);
    }

}
