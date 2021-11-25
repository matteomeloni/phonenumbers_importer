<?php

namespace App\Http\Controllers;

use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PhoneNumberController extends Controller
{
    public function index()
    {
        $data = new PhoneNumber();

        if (\request('filter') === 'imported') {
            $data = $data->importedWithCorrected();
        }

        if (\request('filter') === 'rejected') {
            $data = $data->rejected();
        }

        return response($data->get());
    }

    public function statistics()
    {
        return response([
            'imported' => PhoneNumber::imported()->count(),
            'corrected' => PhoneNumber::corrected()->count(),
            'rejected' => PhoneNumber::rejected()->count(),
        ]);
    }

    public function testNumber(Request  $request)
    {
        $status = null;

        if(Str::of($request->phone)->test('/^(27)[0-9]{9}/')) {
            $status = 'Phone Number is valid';
        }

        if(Str::of($request->phone)->test('/^(?!27)[0-9]{9}$/')) {
            $status = 'The international prefix is missing, try with 27' . $request->phone;
        }

        if ($status === null) {
            $status = 'Phone number is invalid';
        }

        return response([
            'phone' => $request->phone,
            'status' => $status
        ]);
    }
}
