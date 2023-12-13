<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\County;
use App\Models\Subcounty;
use App\Models\WarehouseBags;
use App\Enums\BankEnum;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\DB;

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

    public function getGrainsWarehouseCount()
    {
        $data= DB::table('warehouse_bags')
            // ->join('warehouse_bag_statuses', 'warehouse_bags.id', 'warehouse_bag_statuses.warehouse_bag_id')
            // ->orderBy('warehouse_bag_statuses.id', 'desc')
            // ->get();

            ->join('grains', 'grains.id', 'warehouse_bags.grain_id')
            ->select('grains.id as grain_id', 'grains.name as grain_name', DB::raw('COUNT(grains.id) as `count`'))
            ->orderBy('count', 'desc')
            ->groupBy('grains.id', 'grains.name')
            ->get();

            $retutnLabel = [];
            $returnCount = [];
            foreach($data as $value){
                array_push($retutnLabel, $value->grain_name);
                array_push($returnCount, $value->count);
            }
            return [$retutnLabel,$returnCount];
    }

    public function getGrainsSoldCount()
    {
        return County::where('name', 'Uasin Gishu')->first();
    }

    public function getBanks()
    {
        return BankEnum::cases();
    }
}
