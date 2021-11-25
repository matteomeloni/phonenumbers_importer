<?php

namespace Tests\Unit;

use App\Models\PhoneNumber;
use Tests\TestCase;

class PhoneNumberTest extends TestCase
{
    /** @test */
    public function can_be_filter_by_imported_status()
    {
        PhoneNumber::factory(2)->create([
            'status' => PhoneNumber::IMPORTED
        ]);

        PhoneNumber::factory(5)->create([
            'status' => PhoneNumber::REJECTED
        ]);

        $phones = PhoneNumber::imported()->get();

        $this->assertCount(2, $phones);
        $this->assertFalse($phones->first()->status === PhoneNumber::REJECTED);
    }

    /** @test */
    public function can_be_filter_by_rejected_status()
    {
        PhoneNumber::factory(2)->create([
            'status' => PhoneNumber::REJECTED
        ]);

        PhoneNumber::factory(5)->create([
            'status' => PhoneNumber::IMPORTED
        ]);

        $phones = PhoneNumber::rejected()->get();

        $this->assertCount(2, $phones);
        $this->assertFalse($phones->first()->status === PhoneNumber::IMPORTED);
    }

    /** @test */
    public function can_be_filter_by_corrected_status()
    {
        PhoneNumber::factory(2)->create([
            'status' => PhoneNumber::CORRECTED
        ]);

        PhoneNumber::factory(5)->create([
            'status' => PhoneNumber::IMPORTED
        ]);

        $phones = PhoneNumber::corrected()->get();

        $this->assertCount(2, $phones);
        $this->assertFalse($phones->first()->status === PhoneNumber::IMPORTED);
    }

    /** @test */
    public function can_be_filter_by_imported_and_corrected_status()
    {
        PhoneNumber::factory(1)->create([
            'status' => PhoneNumber::CORRECTED
        ]);

        PhoneNumber::factory(1)->create([
            'status' => PhoneNumber::IMPORTED
        ]);

        PhoneNumber::factory(5)->create([
            'status' => PhoneNumber::REJECTED
        ]);

        $phones = PhoneNumber::importedWithCorrected()->get();

        $this->assertCount(2, $phones);
        $this->assertFalse($phones->first()->status === PhoneNumber::REJECTED);
    }
}
