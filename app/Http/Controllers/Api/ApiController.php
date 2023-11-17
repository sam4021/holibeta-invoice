<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\County;
use App\Models\Subcounty;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class ApiController extends Controller
{
    //
    public function getCounties ()
    {
        return County::query()
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->select('id', 'name')->get();
    }

    public function getSubcounties($county)
    {
        return Subcounty::query()
            ->where('county_id',$county)
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->select('id', 'name')->get();
    }

    public function getDefaultCounty()
    {
        return County::where('name', 'Uasin Gishu')->first();
    }
}
