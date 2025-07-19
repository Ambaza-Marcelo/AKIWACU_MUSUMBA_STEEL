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
use App\Models\MsEbpStockout;
use App\Models\MsEbpStockoutDetail;
use App\Models\Setting;

class StockoutController extends Controller
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
            abort(403, 'Sorry !! You are Unauthorized to view any stockout !');
        }

        $stockouts = MsEbpStockout::orderBy('id','desc')->get();
        return view('backend.pages.musumba_steel.ebp.stockout.index', compact('stockouts'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_facture.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any stockout !');
        }

        $articles  = MsEbpArticle::orderBy('name','asc')->get();
        return view('backend.pages.musumba_steel.ebp.stockout.create', compact('articles'));
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
            abort(403, 'Sorry !! You are Unauthorized to create any stockout !');
        }

        $rules = array(
                'article_id.*'  => 'required',
                'date'  => 'required',
                'quantity.*'  => 'required',
                'asker'  => 'required',
                'destination'  => 'required',
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
            $asker = $request->asker;
            $destination = $request->destination;
            $description =$request->description; 
            $item_movement_type = $request->item_movement_type;
            $quantity = $request->quantity;
            $store_type = $request->store_type;
            

            $latest = MsEbpStockout::orderBy('id','desc')->first();
            if ($latest) {
               $stockout_no = 'BS' . (str_pad((int)$latest->id + 1, 4, '0', STR_PAD_LEFT)); 
            }else{
               $stockout_no = 'BS' . (str_pad((int)0 + 1, 4, '0', STR_PAD_LEFT));  
            }

            $created_by = $this->user->name;

            $stockout_signature = config('app.tin_number_company').Carbon::parse(Carbon::now())->format('YmdHis')."/".$stockout_no;


            for( $count = 0; $count < count($article_id); $count++ ){

                $purchase_price = MsEbpArticle::where('id', $article_id[$count])->value('purchase_price');
                $cump = MsEbpArticle::where('id', $article_id[$count])->value('cump');

                $total_value = $quantity[$count] * $purchase_price;
                $total_purchase_value = $quantity[$count] * $cump;

                $data = array(
                    'article_id' => $article_id[$count],
                    'date' => $date,
                    'quantity' => $quantity[$count],
                    'purchase_price' => $purchase_price,
                    'price' => $cump,
                    'total_purchase_value' => $total_purchase_value,
                    'item_movement_type' => $item_movement_type,
                    'stockout_no' => $stockout_no,
                    'stockout_signature' => $stockout_signature,
                    'created_by' => $created_by,
                    'description' => $description,
                    'status' => 1,
                    'created_at' => \Carbon\Carbon::now()

                );
                $insert_data[] = $data;

                
            }
            MsEbpStockoutDetail::insert($insert_data);


            //create stockout
            $stockout = new MsEbpStockout();
            $stockout->date = $date;
            $stockout->stockout_no = $stockout_no;
            $stockout->stockout_signature = $stockout_signature;
            $stockout->asker = $asker;
            $stockout->destination = $destination;
            $stockout->item_movement_type = $item_movement_type;
            $stockout->created_by = $created_by;
            $stockout->status = 1;
            $stockout->description = $description;
            $stockout->created_at = \Carbon\Carbon::now();
            $stockout->save();


            DB::commit();
            session()->flash('success', 'stockout has been created !!');
            return redirect()->route('admin.stockouts.index');
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
    public function show($stockout_no)
    {
        //
        $code = MsEbpStockoutDetail::where('stockout_no', $stockout_no)->value('stockout_no');
        $stockouts = MsEbpStockoutDetail::where('stockout_no', $stockout_no)->get();
        return view('backend.pages.musumba_steel.ebp.stockout.show', compact('stockouts','code'));
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($stockout_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_facture.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any stockout !');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $stockout_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_facture.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any stockout !');
        }

        session()->flash('success', 'stockout has been updated !!');
        return redirect()->route('admin.stockouts.index');
        
    }

    public function bonSortie($stockout_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_facture.create')) {
            abort(403, 'Sorry !! You are Unauthorized to print handover document!');
        }
        $setting = DB::table('settings')->orderBy('created_at','desc')->first();
        $datas = MsEbpStockoutDetail::where('stockout_no', $stockout_no)->get();
        $data = MsEbpStockout::where('stockout_no', $stockout_no)->first();
        $description = MsEbpStockout::where('stockout_no', $stockout_no)->value('description');
        $stockout_signature = MsEbpStockout::where('stockout_no', $stockout_no)->value('stockout_signature');
        $date = MsEbpStockout::where('stockout_no', $stockout_no)->value('date');
        $totalValue = DB::table('ms_ebp_stockout_details')
            ->where('stockout_no', '=', $stockout_no)
            ->sum('total_purchase_value');
        $pdf = PDF::loadView('backend.pages.musumba_steel.ebp.document.stockout',compact('datas','totalValue','data','description','stockout_no','setting','date','stockout_signature'));

        Storage::put('public/pdf/musumba_steel.ebp.stockout/'.$stockout_no.'.pdf', $pdf->output());

        // download pdf file
        return $pdf->download('BON DE SORTIE '.$stockout_no.'.pdf');
        
    }

    public function validateStockout($stockout_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_facture.validate')) {
            abort(403, 'Sorry !! You are Unauthorized to validate any stockout !');
        }

        try {DB::beginTransaction();
            MsEbpStockout::where('stockout_no', '=', $stockout_no)
                ->update(['status' => 2,'validated_by' => $this->user->name]);
            MsEbpStockoutDetail::where('stockout_no', '=', $stockout_no)
                ->update(['status' => 2,'validated_by' => $this->user->name]);

                DB::commit();
            session()->flash('success', 'stockout has been validated !!');
            return back();
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...

            DB::rollback();

            // and throw the error again.

            throw $e;
        }

    }

    public function reject($stockout_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_facture.reject')) {
            abort(403, 'Sorry !! You are Unauthorized to reject any stockout !');
        }

        try {DB::beginTransaction();

        MsEbpStockout::where('stockout_no', '=', $stockout_no)
                ->update(['status' => -1,'rejected_by' => $this->user->name]);
        MsEbpStockoutDetail::where('stockout_no', '=', $stockout_no)
                ->update(['status' => -1,'rejected_by' => $this->user->name]);

                DB::commit();
            session()->flash('success', 'Stockout has been rejected !!');
            return back();
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...

            DB::rollback();

            // and throw the error again.

            throw $e;
        }

    }

    public function reset($stockout_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_facture.reset')) {
            abort(403, 'Sorry !! You are Unauthorized to reset any stockout !');
        }

        try {DB::beginTransaction();

        MsEbpStockout::where('stockout_no', '=', $stockout_no)
                ->update(['status' => 1,'reseted_by' => $this->user->name]);
        MsEbpStockoutDetail::where('stockout_no', '=', $stockout_no)
                ->update(['status' => 1,'reseted_by' => $this->user->name]);

                DB::commit();
            session()->flash('success', 'Stockout has been reseted !!');
            return back();
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...

            DB::rollback();

            // and throw the error again.

            throw $e;
        }

    }

    public function confirm($stockout_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_facture.confirm')) {
            abort(403, 'Sorry !! You are Unauthorized to confirm any stockout !');
        }

        try {DB::beginTransaction();

        MsEbpStockout::where('stockout_no', '=', $stockout_no)
                ->update(['status' => 3,'confirmed_by' => $this->user->name]);
            MsEbpStockoutDetail::where('stockout_no', '=', $stockout_no)
                ->update(['status' => 3,'confirmed_by' => $this->user->name]);

            DB::commit();
            session()->flash('success', 'Stockout has been confirmed !!');
            return back();
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...

            DB::rollback();

            // and throw the error again.

            throw $e;
        }

    }

    public function approuve($stockout_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_facture.approuve')) {
            abort(403, 'Sorry !! You are Unauthorized to confirm any stockout !');
        }

        try {DB::beginTransaction();

        $datas = MsEbpStockoutDetail::where('stockout_no', $stockout_no)->get();

        $data = MsEbpStockoutDetail::where('stockout_no', $stockout_no)->first();

        foreach($datas as $data){

                $quantityStockInitial = MsEbpArticle::where('id', $data->article_id)->value('quantity');

                $cump = MsEbpArticle::where('id', $data->article_id)->value('cump');

                $quantityRestantStore = $quantityStockInitial - $data->quantity;

                $reportStore = array(
                    'article_id' => $data->article_id,
                    'quantity_stock_initial' => $quantityStockInitial,
                    'value_stock_initial' => $quantityStockInitial * $cump,
                    'date' => $data->date,
                    'quantity_stockout' => $data->quantity,
                    'value_stockout' => $data->value_stockout,
                    'quantity_stock_final' => $quantityStockInitial - $data->quantity,
                    'value_stock_final' => ($quantityStockInitial - $data->quantity) * $cump,
                    'type_transaction' => $data->item_movement_type,
                    'cump' => $cump,
                    'document_no' => $data->stockout_no,
                    'created_by' => $this->user->name,
                    'description' => $data->description,
                    'created_at' => \Carbon\Carbon::now()
                );
                $reportStoreData[] = $reportStore;

                    $store = array(
                        'quantity' => $quantityRestantStore,
                        'total_cump_value' => $quantityRestantStore * $cump
                    );

                    if ($data->quantity <= $quantityStockInitial) {
                        
                        MsEbpArticle::where('id',$data->article_id)
                        ->update($store);

                        $flag = 0;

                        
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
                        
                        $dataObr =  json_decode($response);
                        
                        
                    }else{

                        $flag = 1;

                        session()->flash('error', $this->user->name.' ,Why do you want to stockout a quantity you do not have in your store?please rewrite a valid quantity!');
                        return redirect()->back();
                    }
            }
                
        if($flag != 1){
            MsEbpStockReport::insert($reportStoreData);
        }
    

        MsEbpStockout::where('stockout_no', '=', $stockout_no)
                            ->update(['status' => 4,'approuved_by' => $this->user->name]);
        MsEbpStockoutDetail::where('stockout_no', '=', $stockout_no)
                            ->update(['status' => 4,'approuved_by' => $this->user->name]);

        DB::commit();
            session()->flash('success', 'Stockout has been done successfuly ! ');
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
        return Excel::download(new MsEbpStockoutExport, 'RAPPORT DES SORTIES.xlsx');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $stockout_no
     * @return \Illuminate\Http\Response
     */
    public function destroy($stockout_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_facture.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any stockout !');
        }

        try {DB::beginTransaction();

        $stockout = MsEbpStockout::where('stockout_no',$stockout_no)->first();
        if (!is_null($stockout)) {
            $stockout->delete();
            MsEbpStockoutDetail::where('stockout_no',$stockout_no)->delete();
        }

        DB::commit();
            session()->flash('success', 'Stockout has been deleted !!');
            return back();
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...

            DB::rollback();

            // and throw the error again.

            throw $e;
        }
    }
}
