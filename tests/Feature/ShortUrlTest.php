<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_short_url(): void
    {
        $company = Company::create([
            'name' => 'Test Company',
        ]);

        $admin = User::factory()->create([
            'role' => 'Admin',
            'company_id' => $company->id,
        ]);

        $response = $this->actingAs($admin)->postJson(
            '/api/short-urls',
            [
                'original_url' => 'https://example.com',
            ]
        );

        $response->assertCreated();

        $this->assertDatabaseHas('short_urls', [
            'original_url' => 'https://example.com',
            'user_id' => $admin->id,
            'company_id' => $company->id,
        ]);
    }

    public function test_superadmin_cannot_create_short_url(): void
    {
        $superAdmin = User::factory()->create([
            'role' => 'SuperAdmin',
            'company_id' => null,
        ]);

        $response = $this->actingAs($superAdmin)->postJson(
            '/api/short-urls',
            [
                'original_url' => 'https://example.com',
            ]
        );

        $response->assertForbidden();
    }

    public function test_member_sees_only_their_own_urls(): void
    {
        $company = Company::create([
            'name' => 'Test Company',
        ]);

        $member = User::factory()->create([
            'role' => 'Member',
            'company_id' => $company->id,
        ]);

        $otherMember = User::factory()->create([
            'role' => 'Member',
            'company_id' => $company->id,
        ]);

        ShortUrl::create([
            'original_url' => 'https://example.com/own',
            'short_code' => 'OWN123',
            'user_id' => $member->id,
            'company_id' => $company->id,
        ]);

        ShortUrl::create([
            'original_url' => 'https://example.com/other',
            'short_code' => 'OTH123',
            'user_id' => $otherMember->id,
            'company_id' => $company->id,
        ]);

        $response = $this->actingAs($member)->getJson(
            '/api/short-urls'
        );

        $response->assertOk();
        $response->assertJsonFragment([
            'short_code' => 'OWN123',
        ]);
        $response->assertJsonMissing([
            'short_code' => 'OTH123',
        ]);
    }

    public function test_admin_sees_only_urls_from_their_company(): void
    {
        $companyA = Company::create([
            'name' => 'Company A',
        ]);

        $companyB = Company::create([
            'name' => 'Company B',
        ]);

        $admin = User::factory()->create([
            'role' => 'Admin',
            'company_id' => $companyA->id,
        ]);

        $userA = User::factory()->create([
            'role' => 'Member',
            'company_id' => $companyA->id,
        ]);

        $userB = User::factory()->create([
            'role' => 'Member',
            'company_id' => $companyB->id,
        ]);

        ShortUrl::create([
            'original_url' => 'https://example.com/a',
            'short_code' => 'COMA01',
            'user_id' => $userA->id,
            'company_id' => $companyA->id,
        ]);

        ShortUrl::create([
            'original_url' => 'https://example.com/b',
            'short_code' => 'COMB01',
            'user_id' => $userB->id,
            'company_id' => $companyB->id,
        ]);

        $response = $this->actingAs($admin)->getJson(
            '/api/short-urls'
        );

        $response->assertOk();
        $response->assertJsonFragment([
            'short_code' => 'COMA01',
        ]);
        $response->assertJsonMissing([
            'short_code' => 'COMB01',
        ]);
    }

    public function test_public_short_url_redirects_to_original_url(): void
    {
        $shortUrl = ShortUrl::create([
            'original_url' => 'https://example.com',
            'short_code' => 'PUB123',
        ]);

        $response = $this->get('/PUB123');

        $response->assertRedirect('https://example.com');

        $this->assertDatabaseHas('short_urls', [
            'id' => $shortUrl->id,
            'clicks' => 1,
        ]);
    }

    public function test_superadmin_can_see_urls_from_all_companies(): void
    {
        $companyA = Company::create([
            'name' => 'Company A',
        ]);

        $companyB = Company::create([
            'name' => 'Company B',
        ]);

        $superAdmin = User::factory()->create([
            'role' => 'SuperAdmin',
            'company_id' => null,
        ]);

        $userA = User::factory()->create([
            'role' => 'Member',
            'company_id' => $companyA->id,
        ]);

        $userB = User::factory()->create([
            'role' => 'Member',
            'company_id' => $companyB->id,
        ]);

        ShortUrl::create([
            'original_url' => 'https://example.com/a',
            'short_code' => 'ALL001',
            'user_id' => $userA->id,
            'company_id' => $companyA->id,
        ]);

        ShortUrl::create([
            'original_url' => 'https://example.com/b',
            'short_code' => 'ALL002',
            'user_id' => $userB->id,
            'company_id' => $companyB->id,
        ]);

        $response = $this->actingAs($superAdmin)->getJson(
            '/api/short-urls'
        );

        $response->assertOk();

        $response->assertJsonFragment([
            'short_code' => 'ALL001',
        ]);

        $response->assertJsonFragment([
            'short_code' => 'ALL002',
        ]);
    }
}