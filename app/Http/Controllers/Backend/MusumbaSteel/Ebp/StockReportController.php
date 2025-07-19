<?php

namespace App\Http\Controllers\Backend\MusumbaSteel\Ebp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\MsEbpStockReport;
use Illuminate\Support\Facades\Storage;
use App\Exports\MusumbaSteel\Ebp\StockReportExport;
use Excel;
use PDF;
use Carbon\Carbon;

class StockReportController extends Controller
{
    //
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }


    public function index(){
        if (is_null($this->user) || !$this->user->can('musumba_steel_facture.view')) {
            abort(403, 'Muradutunge !! Ntaburenganzira mufise bwo kuraba raporo,mufise ico mubaza murashobora guhamagara kuri 122 !');
        }
            $datas = MsEbpStockReport::select(
                        DB::raw('id,date,type_transaction,document_no,created_at,article_id,quantity_stock_initial,value_stock_initial,quantity_stockin,value_stockin,quantity_stockout,value_stockout,quantity_stock_final,value_stock_final,created_by,description'))->groupBy('id','date','type_transaction','document_no','created_at','article_id','quantity_stock_initial','value_stock_initial','quantity_stockin','value_stockin','quantity_stockout','value_stockout','quantity_stock_final','value_stock_final','description','created_by')->orderBy('id','asc')->take(200)->get();


        return view('backend.pages.musumba_steel.ebp.stock_report.index',compact('datas'));
       
    }

    public function exportToExcel(Request $request)
    {
        return Excel::download(new StockReportExport, 'MOUVEMENT DE STOCK.xlsx');
    }
}
