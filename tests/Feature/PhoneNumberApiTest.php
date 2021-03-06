<?php

namespace Tests\Feature;

use App\Models\PhoneNumber;
use Tests\TestCase;

class PhoneNumberApiTest extends TestCase
{
    /**
     * @var PhoneNumber
     */
    private $imported;

    /**
     * @var PhoneNumber
     */
    private $corrected;

    /**
     * @var PhoneNumber
     */
    private $rejected;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->imported = PhoneNumber::factory(1)->create(['status' => PhoneNumber::IMPORTED]);
        $this->corrected = PhoneNumber::factory(1)->create(['status' => PhoneNumber::CORRECTED]);
        $this->rejected = PhoneNumber::factory(1)->create(['status' => PhoneNumber::REJECTED]);
    }

    /** @test */
    public function phone_number_api_index_route_return_correct_data()
    {

        $this->get('/api/phone-numbers')
            ->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonFragment([
                'mobile' => $this->imported->first()->mobile,
                'status' => $this->imported->first()->status
            ])
            ->assertJsonFragment([
                'mobile' => $this->corrected->first()->mobile,
                'status' => $this->corrected->first()->status,
            ])
            ->assertJsonFragment([
                'mobile' => $this->rejected->first()->mobile,
                'status' => $this->rejected->first()->status,
            ]);
    }

    /** @test */
    public function phone_number_api_index_route_can_be_filter_by_imported_status()
    {
        $this->get('/api/phone-numbers?filter=imported')
            ->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment([
                'mobile' => $this->imported->first()->mobile,
                'status' => $this->imported->first()->status
            ])
            ->assertJsonFragment([
                'mobile' => $this->corrected->first()->mobile,
                'status' => $this->corrected->first()->status,
            ])
            ->assertJsonMissing([
                'mobile' => $this->rejected->first()->mobile,
                'status' => $this->rejected->first()->status,
            ]);
    }

    /** @test */
    public function phone_number_api_index_route_can_be_filter_by_rejected_status()
    {
        $this->get('/api/phone-numbers?filter=rejected')
            ->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'mobile' => $this->rejected->first()->mobile,
                'status' => $this->rejected->first()->status,
            ])
            ->assertJsonMissing([
                'mobile' => $this->imported->first()->mobile,
                'status' => $this->imported->first()->status
            ])
            ->assertJsonMissing([
                'mobile' => $this->corrected->first()->mobile,
                'status' => $this->corrected->first()->status,
            ]);
    }

    /** @test */
    public function phone_number_api_statistics_route_return_correct_data()
    {
        $this->get('/api/phone-numbers/statistics')
            ->assertStatus(200)
            ->assertJson([
                'imported' => 1,
                'corrected' => 1,
                'rejected' => 1
            ]);
    }

    /** @test */
    public function phone_number_api_test_number_route_return_correct_data()
    {
        $this->get('/api/phone-numbers/test/27607909220')
            ->assertStatus(200)
            ->assertJson([
                'phone' => '27607909220',
                'status' => 'Phone Number is valid'
            ]);

        $this->get('/api/phone-numbers/test/607909220')
            ->assertStatus(200)
            ->assertJson([
                'phone' => '607909220',
                'status' => 'The international prefix is missing, try with 27607909220'
            ]);

        $this->get('/api/phone-numbers/test/60790923456220')
            ->assertStatus(200)
            ->assertJson([
                'phone' => '60790923456220',
                'status' => 'Phone number is invalid'
            ]);
    }
}
