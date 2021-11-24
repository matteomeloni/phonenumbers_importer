<?php

namespace App\Imports;

use App\Models\PhoneNumber;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PhoneNumbers implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $data = [
            'mobile' => $row['sms_phone'],
            'status' => PhoneNumber::REJECTED,
            'status_description' => null
        ];

        if(Str::of($row['sms_phone'])->test('/^(27)[0-9]{9}/')) {
            $data = [
                'mobile' => $row['sms_phone'],
                'status' => PhoneNumber::IMPORTED,
                'status_description' => null
            ];
        }

        if(Str::of($row['sms_phone'])->test('/^(?!27)[0-9]{9}$/')) {
            $data = [
                'mobile' => "27{$row['sms_phone']}",
                'status' => PhoneNumber::CORRECTED,
                'status_description' => 'ADDED INTERNATION PREFIX'
            ];
        }

        return new PhoneNumber($data);
    }
}
