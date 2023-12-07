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
        $reports=DB::table('')->get();
        $filters = request()->all('search', 'showing');

        return inertia::render('admin/reports/index', compact('reports','filters'));
    }

}
