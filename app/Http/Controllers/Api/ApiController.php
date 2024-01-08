<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\County;
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

    public function getWarehouseWeightDaily()
    {
        $warehouse = Warehouse::select('*')
            ->join('warehouse_bags', 'warehouse_bags.warehouse_id', 'warehouses.id')
            ->select(DB::raw('DATE_FORMAT(warehouses.created_at, "%D %b %y") as day'),DB::raw('sum(warehouse_bags.weight) as `weight`'))
            ->whereBetween('warehouses.created_at', [Carbon::now()->subDay(5), Carbon::now()])
            ->groupBy('day')
            ->get()->toArray();
        
        $output = array();
        foreach ($warehouse as $day) {
            $m =  strtotime($day['day']);
            $output[$m] = $day;
        }
        ksort($output);
        return array_values($output);
    }

    public function getWarehouseBagDaily()
    {
        $bags = WarehouseBags::select('*')
            ->select(DB::raw('DATE_FORMAT(created_at, "%D %b %y") as day'),DB::raw('COUNT(id) as `bags`'))
            ->whereBetween('created_at', [Carbon::now()->subDay(5), Carbon::now()])
            ->groupBy('day')
            ->get()->toArray();
        
        $output = array();
        foreach ($bags as $day) {
            $m =  strtotime($day['day']);
            $output[$m] = $day;
        }
        ksort($output);
        return array_values($output);
    }
}
