<?php

namespace Tests\Feature\Organization;

use DateTimeImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationControllerTest extends TestCase
{
    use RefreshDatabase; // This ensures a clean database for each test

    public function test_apply_creates_new_organization()
    {
        $testData = [
            'ORG_Name' => 'Test Organization',
            'ORG_Address' => '123 Main St',
            'ORG_Email' => 'mail@example.com',
            'ORG_Website' => 'example.com',
            'ORG_DateEstablished' => new DateTimeImmutable('2000-01-01'),
            'ORG_PresidentName' => 'John Johnson',
            'ORG_PresidentEmail' => 'johnson@example.com',
            'ORG_SecretaryName' => 'Jade Jadesen',
            'ORG_SecretaryEmail' => 'jadesen@example.com',
            'ORG_TreasurerName' => 'Jeru Jerusalem',
            'ORG_TreasurerEmail' => 'jerusalem@example.com',
            'ORG_Phone' => '868-123-4567',
            'ORG_MembersCount' => 20,
            'ORG_MembersMale' => 10,
            'ORG_MembersFemale' => 10,
            'ORG_Objectives' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et hendrerit mauris, sit amet maximus ante. Maecenas aliquet eget mi at maximus. Ut nunc leo, aliquet vitae massa et, dapibus ornare lorem. Mauris semper, lorem vitae mollis auctor, magna urna consectetur enim, vel dictum mauris dolor eu tortor. Nulla sodales mi in nulla porta, vitae rhoncus dolor facilisis. Maecenas lobortis suscipit vulputate. Morbi egestas nibh nec eros faucibus, ac consequat nisl porta. Integer a viverra nunc, eget porttitor dolor.',
            'ORG_ResponsibitiesAccept' => true,
        ];

        $response = $this->post('/api/organization/apply', $testData, ['backendToken'=>env("BACKEND_TOKEN")]);

        // Log::debug($response->getContent());

        $response->assertStatus(201); // Assert successful creation (Created)
        $this->assertDatabaseHas('organizations', $testData); // Assert data saved in database
    }
}
