<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function __construct(){
        $this->middleware(['role:'.RoleEnum::Admin->value]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports=DB::table('warehouse_bags')
                ->when(request('search'), function($query){
                    $query->where('warehouse_bags.bag_code','like','%'.request('search').'%');
                })
                ->join('grains','grains.id','warehouse_bags.grain_id')
                ->join('warehouses','warehouses.id','warehouse_bags.warehouse_id')
                ->select([
                    'warehouse_bags.id as bad_id',
                    'warehouse_bags.bag_code',
                    'warehouse_bags.weight',
                    'warehouses.id as warehouse_id',
                    'warehouses.warehouse_code'])
                ->paginate(request('showing')??10);
        $filters = request()->all('search', 'showing');

        return inertia::render('admin/reports/index', compact('reports','filters'));
    }

}
