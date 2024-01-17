<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Subcounty;
use App\Models\Warehouse;
use App\Models\WarehouseBags;
use App\Enums\BankEnum;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiController extends Controller
{
    //
    public function getCountries()
    {
        return Country::query()
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . request('search') . '%');
                //->orWhere('currency_name','like', '%' . request('search') . '%')
                //->orWhere('currency_code','like', '%' . request('search') . '%');
            })
            ->select('id', 'name', 'code', 'dial_code', 'flag', 'currency_name', 'currency_code')->get();
    }

    public function getDefaultCountry()
    {
        $position = Location::get();
        $country = 'Kenya';
        if ($position) {
            $country = $position->countryName;
        }
        return Country::where('name', 'Kenya')->first();
    }
}
