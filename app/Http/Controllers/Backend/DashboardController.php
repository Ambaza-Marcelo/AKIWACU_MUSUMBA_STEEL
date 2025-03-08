<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Events\RealTimeMessage;
use App\Models\MsFuelReport;
use App\Models\MsFuelPump;

class DashboardController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }


    public function index()
    {
        if (is_null($this->user) || !$this->user->can('dashboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view dashboard !');
        }


        //$month = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $year = ['2023','2024','2025','2026','2027','2028','2029','2030'];
        
        $gasoil_stockout = [];
        foreach ($year as $key => $value) {
            $gasoil_stockout[] = MsFuelReport::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->where('pump_id',1)->sum('quantity_stockout');
        }

        $essence_stockout = [];
        foreach ($year as $key => $value) {
            $essence_stockout[] = MsFuelReport::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->where('pump_id',2)->sum('quantity_stockout');
        }




        $total_roles = count(Role::select('id')->get());
        $total_admins = count(Admin::select('id')->get());
        $total_permissions = count(Permission::select('id')->get());


        return view('backend.pages.dashboard.index', 
            compact(
            'total_admins', 
            'total_roles', 
            'total_permissions'

            ))->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('gasoil_stockout',json_encode($gasoil_stockout,JSON_NUMERIC_CHECK))->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('essence_stockout',json_encode($essence_stockout,JSON_NUMERIC_CHECK));
    }

    public function changeLang(Request $request){
        \App::setlocale($request->lang);
        session()->put("locale",$request->lang);
        event(new RealTimeMessage('Hello World'));

        return redirect()->back();
    }
}
