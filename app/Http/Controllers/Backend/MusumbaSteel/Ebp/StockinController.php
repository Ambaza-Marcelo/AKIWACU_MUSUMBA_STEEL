<?php

namespace App\Http\Controllers\Backend\MusumbaSteel\Ebp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use PDF;
use Excel;
use Mail;
use Validator;
use GuzzleHttp\Client;
use App\Models\MsEbpArticle;
use App\Models\MsEbpStockReport;
use App\Models\MsEbpStockin;
use App\Models\MsEbpStockinDetail;
use App\Models\Setting;

class StockinController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (is_null($this->user) || !$this->user->can('musumba_steel_facture.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any stockin !');
        }

            
        $stockins = MsEbpStockin::orderBy('id','desc')->get();
        return view('backend.pages.musumba_steel.ebp.stockin.index', compact('stockins'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_facture.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any stockin !');
        }

        $articles  = MsEbpArticle::orderBy('name','asc')->get();
        return view('backend.pages.musumba_steel.ebp.stockin.create', compact('articles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('musumba_steel_facture.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any stockin !');
        }

        $rules = array(
                'article_id.*'  => 'required',
                'date'  => 'required',
                'quantity.*'  => 'required',
                'purchase_price.*'  => 'required',
                'handingover'  => 'required',
                'origin'  => 'required',
                'receptionist'  => 'required',
                'item_movement_type'  => 'required',
                'description'  => 'required|max:490'
            );

            $error = Validator::make($request->all(),$rules);

            if($error->fails()){
                return response()->json([
                    'error' => $error->errors()->all(),
                ]);
            }

            try {DB::beginTransaction();

            $article_id = $request->article_id;
            $date = Carbon::now();
            $invoice_currency = $request->invoice_currency;
            $handingover = $request->handingover;
            $receptionist = $request->receptionist;
            $origin = $request->origin;
            $description =$request->description; 
            $item_movement_type = $request->item_movement_type;
            //$unit = $request->unit;
            $quantity = $request->quantity;
            $purchase_price = $request->purchase_price;
            

            $latest = MsEbpStockin::orderBy('id','desc')->first();
            if ($latest) {
               $stockin_no = 'BE' . (str_pad((int)$latest->id + 1, 4, '0', STR_PAD_LEFT)); 
            }else{
               $stockin_no = 'BE' . (str_pad((int)0 + 1, 4, '0', STR_PAD_LEFT));  
            }

            $created_by = $this->user->name;

            $stockin_signature = config('app.tin_number_company').Carbon::parse(Carbon::now())->format('YmdHis')."/".$stockin_no;


            for( $count = 0; $count < count($article_id); $count++ ){
                $total_amount_purchase = $quantity[$count] * $purchase_price[$count];

                $data = array(
                    'article_id' => $article_id[$count],
                    'date' => $date,
                    'quantity' => $quantity[$count],
                    'purchase_price' => $purchase_price[$count],
                    'total_amount_purchase' => $total_amount_purchase,
                    'receptionist' => $receptionist,
                    'handingover' => $handingover,
                    'origin' => $origin,
                    'item_movement_type' => $item_movement_type,
                    'stockin_no' => $stockin_no,
                    'stockin_signature' => $stockin_signature,
                    'created_by' => $created_by,
                    'description' => $description,
                    'status' => 1,
                    'created_at' => \Carbon\Carbon::now()

                );
                $insert_data[] = $data;

                
            }
            MsEbpStockinDetail::insert($insert_data);


            //create stockin
            $stockin = new MsEbpStockin();
            $stockin->date = $date;
            $stockin->stockin_no = $stockin_no;
            $stockin->stockin_signature = $stockin_signature;
            $stockin->receptionist = $receptionist;
            $stockin->handingover = $handingover;
            $stockin->origin = $origin;
            $stockin->item_movement_type = $item_movement_type;
            $stockin->created_by = $created_by;
            $stockin->status = 1;
            $stockin->description = $description;
            $stockin->created_at = \Carbon\Carbon::now();
            $stockin->save();

            DB::commit();
            session()->flash('success', 'stockin has been created !!');
            return redirect()->route('admin.stockins.index');
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...

            DB::rollback();

            // and throw the error again.

            throw $e;
        }
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($stockin_no)
    {
        //
        $code = MsEbpStockinDetail::where('stockin_no', $stockin_no)->value('stockin_no');
        $stockins = MsEbpStockinDetail::where('stockin_no', $stockin_no)->get();
        return view('backend.pages.musumba_steel.ebp.stockin.show', compact('stockins','code'));
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($stockin_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_facture.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any stockin !');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $stockin_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_facture.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any stockin !');
        }
        
    }

    public function bonEntree($stockin_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_facture.create')) {
            abort(403, 'Sorry !! You are Unauthorized to print handover document!');
        }
        $setting = DB::table('settings')->orderBy('created_at','desc')->first();
        $code = MsEbpStockin::where('stockin_no', $stockin_no)->value('stockin_no');
        $datas = MsEbpStockinDetail::where('stockin_no', $stockin_no)->get();
        $data = MsEbpStockin::where('stockin_no', $stockin_no)->first();
        $receptionniste = MsEbpStockin::where('stockin_no', $stockin_no)->value('receptionist');
        $description = MsEbpStockin::where('stockin_no', $stockin_no)->value('description');
        $handingover = MsEbpStockin::where('stockin_no', $stockin_no)->value('handingover');
        $stockin_signature = MsEbpStockin::where('stockin_no', $stockin_no)->value('stockin_signature');
        $date = MsEbpStockin::where('stockin_no', $stockin_no)->value('date');
        $totalValue = DB::table('ms_ebp_stockin_details')
            ->where('stockin_no', '=', $stockin_no)
            ->sum('total_amount_purchase');
        $pdf = PDF::loadView('backend.pages.musumba_steel.ebp.document.stockin',compact('datas','code','totalValue','receptionniste','description','handingover','setting','data','date','stockin_signature','stockin_no'));

        Storage::put('public/pdf/ebp/stockin/'.$stockin_no.'.pdf', $pdf->output());

        // download pdf file
        return $pdf->download('BON ENTREE '.$stockin_no.'.pdf');
        
    }

    public function validateStockin($stockin_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_facture.validate')) {
            abort(403, 'Sorry !! You are Unauthorized to validate any stockin !');
        }
        try {DB::beginTransaction();

            MsEbpStockin::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 2,'validated_by' => $this->user->name]);
            MsEbpStockinDetail::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 2,'validated_by' => $this->user->name]);

                DB::commit();
            session()->flash('success', 'stockin has been validated !!');
            return back();
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...

            DB::rollback();

            // and throw the error again.

            throw $e;
        }

    }

    public function reject($stockin_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_facture.reject')) {
            abort(403, 'Sorry !! You are Unauthorized to reject any stockin !');
        }

        try {DB::beginTransaction();

        MsEbpStockin::where('stockin_no', '=', $stockin_no)
                ->update(['status' => -1,'rejected_by' => $this->user->name]);
        MsEbpStockinDetail::where('stockin_no', '=', $stockin_no)
                ->update(['status' => -1,'rejected_by' => $this->user->name]);

                DB::commit();
            session()->flash('success', 'Stockin has been rejected !!');
            return back();
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...

            DB::rollback();

            // and throw the error again.

            throw $e;
        }

    }

    public function reset($stockin_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_facture.reset')) {
            abort(403, 'Sorry !! You are Unauthorized to reset any stockin !');
        }

        try {DB::beginTransaction();

        MsEbpStockin::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 1,'reseted_by' => $this->user->name]);
        MsEbpStockinDetail::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 1,'reseted_by' => $this->user->name]);

                 DB::commit();
            session()->flash('success', 'Stockin has been reseted !!');
            return back();
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...

            DB::rollback();

            // and throw the error again.

            throw $e;
        }

    }

    public function confirm($stockin_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_facture.confirm')) {
            abort(403, 'Sorry !! You are Unauthorized to confirm any stockin !');
        }

        try {DB::beginTransaction();

        MsEbpStockin::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 3,'confirmed_by' => $this->user->name]);
            MsEbpStockinDetail::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 3,'confirmed_by' => $this->user->name]);

                 DB::commit();
            session()->flash('success', 'Stockin has been confirmed !!');
            return back();
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...

            DB::rollback();

            // and throw the error again.

            throw $e;
        }

    }

    public function approuve($stockin_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_facture.approuve')) {
            abort(403, 'Sorry !! You are Unauthorized to confirm any stockin !');
        }

        try {DB::beginTransaction();


        $datas = MsEbpStockinDetail::where('stockin_no', $stockin_no)->get();

        $data = MsEbpStockinDetail::where('stockin_no', $stockin_no)->first();

        foreach($datas as $data){

                $valeurStockInitialDestination = MsEbpArticle::where('id', $data->article_id)->value('total_cump_value');
                $quantityStockInitialDestination = MsEbpArticle::where('id', $data->article_id)->value('quantity');
                $quantityTotalStore = $quantityStockInitialDestination + $data->quantity;


                $valeurAcquisition = $data->quantity * $data->purchase_price;

                $valeurTotalUnite = $data->quantity + $quantityStockInitialDestination;
                $cump = ($valeurStockInitialDestination + $valeurAcquisition) / $valeurTotalUnite;

                $report = array(
                    'article_id' => $data->article_id,
                    'quantity_stock_initial' => $quantityStockInitialDestination,
                    'value_stock_initial' => $valeurStockInitialDestination,
                    'date' => $data->date,
                    'quantity_stockin' => $data->quantity,
                    'value_stockin' => $data->total_amount_purchase,
                    'quantity_stock_final' => $quantityStockInitialDestination + $data->quantity,
                    'value_stock_final' => $valeurStockInitialDestination + $data->total_amount_purchase,
                    'type_transaction' => $data->item_movement_type,
                    'cump' => $cump,
                    'document_no' => $data->stockin_no,
                    'created_by' => $this->user->name,
                    'description' => $data->description,
                    'created_at' => \Carbon\Carbon::now()
                );
                $reportData[] = $report;

                    $store = array(
                        'quantity' => $quantityTotalStore,
                        'cump' => $cump,
                        'total_cump_value' => $quantityTotalStore * $cump
                    );

                    MsEbpArticle::where('id',$data->article_id)
                        ->update($store);
                        
                        
                        $theUrl = config('app.guzzle_test_url').'/ebms_api/login/';
                        $response = Http::post($theUrl, [
                            'username'=> config('app.obr_test_username'),
                            'password'=> config('app.obr_test_pwd')

                        ]);
                        $data1 =  json_decode($response);
                        $data2 = ($data1->result);       
    
                        $token = $data2->token;

                        $theUrl = config('app.guzzle_test_url').'/ebms_api/AddStockMovement';  
                        $response = Http::withHeaders([
                        'Authorization' => 'Bearer '.$token,
                        'Accept' => 'application/json'])->post($theUrl, [
                            'system_or_device_id'=> config('app.obr_test_username'),
                            'item_code'=> $data->article->code,
                            'item_designation'=>$data->article->name,
                            'item_quantity'=>$data->quantity,
                            'item_measurement_unit'=>$data->article->unit,
                            'item_purchase_or_sale_price'=>$cump,
                            'item_purchase_or_sale_currency'=> "BIF",
                            'item_movement_type'=> $data->item_movement_type,
                            'item_movement_invoice_ref'=> "",
                            'item_movement_description'=>$data->description,
                            'item_movement_date'=> $data->date,

                        ]); 
                
            }
            MsEbpStockReport::insert($reportData);

            MsEbpStockin::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 4,'approuved_by' => $this->user->name]);
            MsEbpStockinDetail::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 4,'approuved_by' => $this->user->name]);

        DB::commit();
            session()->flash('success', 'Stockin has been done successfuly !');
            return back();
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...

            DB::rollback();

            // and throw the error again.

            throw $e;
        }

    }

    public function exportToExcel(Request $request)
    {
        return Excel::download(new MsEbpStockinExport, 'RAPPORT DES ENTREES.xlsx');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $stockin_no
     * @return \Illuminate\Http\Response
     */
    public function destroy($stockin_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_facture.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any stockin !');
        }

        try {DB::beginTransaction();

        $stockin = MsEbpStockin::where('stockin_no',$stockin_no)->first();
        if (!is_null($stockin)) {
            $stockin->delete();
            MsEbpStockinDetail::where('stockin_no',$stockin_no)->delete();
        }

        DB::commit();
            session()->flash('success', 'Stockin has been deleted !!');
            return back();
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...

            DB::rollback();

            // and throw the error again.

            throw $e;
        }
    }
}
