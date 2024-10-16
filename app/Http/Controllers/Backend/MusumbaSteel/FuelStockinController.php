<?php

namespace App\Http\Controllers\Backend\MusumbaSteel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use App\Models\MsFuelStockin;
use App\Models\MsFuelStockinDetail;
use App\Models\MsFuel;
use App\Models\MsCar;
use App\Models\MsFuelPump;
use App\Models\MsFuelReport;
use Carbon\Carbon;
use PDF;
use Validator;
use Excel;
use Mail;
use App\Mail\DeleteFuelStockinMail;

class FuelStockinController extends Controller
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
        if (is_null($this->user) || !$this->user->can('musumba_steel_fuel_stockin.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any stockin !');
        }

        $stockins = MsFuelStockin::orderBy('id','desc')->get();
        return view('backend.pages.musumba_steel.fuel.stockin.index', compact('stockins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_fuel_stockin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any stockin !');
        }

        $fuels  = MsFuel::orderBy('name','asc')->get();
        $cars  = MsCar::orderBy('marque','asc')->get();
        $pumps = MsFuelPump::all();
        return view('backend.pages.musumba_steel.fuel.stockin.create', compact('fuels','pumps','cars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('musumba_steel_fuel_stockin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any stockin !');
        }

        $rules = array(
                'fuel_id.*'  => 'required',
                'date'  => 'required',
                'quantity.*'  => 'required',
                'purchase_price.*'  => 'required',
                'handingover'  => 'required',
                'origin'  => 'required',
                //'receptionist'  => 'required',
                'pump_id'  => 'required',
                'description'  => 'required'
            );

            $error = Validator::make($request->all(),$rules);

            if($error->fails()){
                return response()->json([
                    'error' => $error->errors()->all(),
                ]);
            }

            try {DB::beginTransaction();

            $fuel_id = $request->fuel_id;
            $date = $request->date;
            $handingover = $request->handingover;
            $receptionist = $request->receptionist;
            $origin = $request->origin;
            $description =$request->description; 
            $pump_id = $request->pump_id;
            $quantity = $request->quantity;
            $item_movement_type = $request->item_movement_type;
            $purchase_price = $request->purchase_price;
            

            $latest = MsFuelStockin::latest()->first();
            if ($latest) {
               $stockin_no = 'BE' . (str_pad((int)$latest->id + 1, 4, '0', STR_PAD_LEFT)); 
            }else{
               $stockin_no = 'BE' . (str_pad((int)0 + 1, 4, '0', STR_PAD_LEFT));  
            }

            $created_by = $this->user->name;

            $stockin_signature = "4001711615".Carbon::parse(Carbon::now())->format('YmdHis')."/".$stockin_no;


            for( $count = 0; $count < count($fuel_id); $count++ ){
                $total_amount_purchase = $quantity[$count] * $purchase_price[$count];

                $data = array(
                    'fuel_id' => $fuel_id[$count],
                    'date' => $date,
                    'quantity' => $quantity[$count],
                    'purchase_price' => $purchase_price[$count],
                    'total_amount_purchase' => $total_amount_purchase,
                    'receptionist' => $receptionist,
                    'handingover' => $handingover,
                    'origin' => $origin,
                    'pump_id' => $pump_id,
                    'stockin_no' => $stockin_no,
                    'stockin_signature' => $stockin_signature,
                    'created_by' => $created_by,
                    'item_movement_type' => $item_movement_type,
                    'description' => $description,
                    'status' => 1,
                    'created_at' => \Carbon\Carbon::now()

                );
                $insert_data[] = $data;

                
            }
            MsFuelStockinDetail::insert($insert_data);

            //create stockin
            $stockin = new MsFuelStockin();
            $stockin->date = $date;
            $stockin->stockin_no = $stockin_no;
            $stockin->stockin_signature = $stockin_signature;
            $stockin->receptionist = $receptionist;
            $stockin->handingover = $handingover;
            $stockin->origin = $origin;
            $stockin->pump_id = $pump_id;
            $stockin->created_by = $created_by;
            $stockin->item_movement_type = $item_movement_type;
            $stockin->status = 1;
            $stockin->description = $description;
            $stockin->save();

        DB::commit();
            session()->flash('success', 'stockin has been created !!');
           return redirect()->route('admin.ms-fuel-stockins.index');
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
        $code = MsFuelStockinDetail::where('stockin_no', $stockin_no)->value('stockin_no');
        $stockins = MsFuelStockinDetail::where('stockin_no', $stockin_no)->get();
        return view('backend.pages.musumba_steel.fuel.stockin.show', compact('stockins','code'));
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($stockin_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_fuel_stockin.edit')) {
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
        if (is_null($this->user) || !$this->user->can('musumba_steel_fuel_stockin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any stockin !');
        }

        
        
    }

    public function bon_entree($stockin_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_fuel_stockin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to print handover document!');
        }
        $setting = DB::table('settings')->orderBy('created_at','desc')->first();
        $code = MsFuelStockin::where('stockin_no', $stockin_no)->value('stockin_no');
        $datas = MsFuelStockinDetail::where('stockin_no', $stockin_no)->get();
        $data = MsFuelStockin::where('stockin_no', $stockin_no)->first();
        $receptionniste = MsFuelStockin::where('stockin_no', $stockin_no)->value('receptionist');
        $description = MsFuelStockin::where('stockin_no', $stockin_no)->value('description');
        $stockin_signature = MsFuelStockin::where('stockin_no', $stockin_no)->value('stockin_signature');
        $date = MsFuelStockin::where('stockin_no', $stockin_no)->value('date');
        $totalValue = DB::table('ms_fuel_stockin_details')
            ->where('stockin_no', '=', $stockin_no)
            ->sum('total_amount_purchase');
        $pdf = PDF::loadView('backend.pages.musumba_steel.fuel.document.stockin',compact('datas','code','totalValue','receptionniste','description','data','setting','stockin_no','date','stockin_signature'));

        Storage::put('public/musumba_steel/fuel/stockin/'.$stockin_no.'.pdf', $pdf->output());

        // download pdf file
        return $pdf->download('BON_ENTREE_'.$stockin_no.'.pdf');
        
    }

    public function validateStockin($stockin_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_fuel_stockin.validate')) {
            abort(403, 'Sorry !! You are Unauthorized to validate any stockin !');
        }
            MsFuelStockin::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 2,'validated_by' => $this->user->name]);
            MsFuelStockinDetail::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 2,'validated_by' => $this->user->name]);

        session()->flash('success', 'stockin has been validated !!');
        return back();
    }

    public function reject($stockin_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_fuel_stockin.reject')) {
            abort(403, 'Sorry !! You are Unauthorized to reject any stockin !');
        }

        MsFuelStockin::where('stockin_no', '=', $stockin_no)
                ->update(['status' => -1,'rejected_by' => $this->user->name]);
        MsFuelStockinDetail::where('stockin_no', '=', $stockin_no)
                ->update(['status' => -1,'rejected_by' => $this->user->name]);

        session()->flash('success', 'Stockin has been rejected !!');
        return back();
    }

    public function reset($stockin_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_fuel_stockin.reset')) {
            abort(403, 'Sorry !! You are Unauthorized to reset any stockin !');
        }

        MsFuelStockin::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 1,'reseted_by' => $this->user->name]);
        MsFuelStockinDetail::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 1,'reseted_by' => $this->user->name]);

        session()->flash('success', 'Stockin has been reseted !!');
        return back();
    }

    public function confirm($stockin_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_fuel_stockin.confirm')) {
            abort(403, 'Sorry !! You are Unauthorized to confirm any stockin !');
        }

        MsFuelStockin::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 3,'confirmed_by' => $this->user->name]);
            MsFuelStockinDetail::where('stockin_no', '=', $stockin_no)
                ->update(['status' => 3,'confirmed_by' => $this->user->name]);

        session()->flash('success', 'Stockin has been confirmed !!');
        return back();
    }

    public function approuve($stockin_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_fuel_stockin.approuve')) {
            abort(403, 'Sorry !! You are Unauthorized to confirm any stockin !');
        }

        try {DB::beginTransaction();

        $datas = MsFuelStockinDetail::where('stockin_no', $stockin_no)->get();

        foreach($datas as $data){

                $valeurStockInitialDestination = MsFuelPump::where('id', $data->pump_id)->value('total_purchase_value');
                $quantityStockInitialDestination = MsFuelPump::where('id', $data->pump_id)->value('quantity');
                $quantityTotalPump = $quantityStockInitialDestination + $data->quantity;


                $valeurAcquisition = $data->quantity * $data->purchase_price;

                $valeurTotalUnite = $data->quantity + $quantityStockInitialDestination;
                $cump = ($valeurStockInitialDestination + $valeurAcquisition) / $valeurTotalUnite;

                $reportData = array(
                    'fuel_id' => $data->fuel_id,
                    'pump_id' => $data->pump_id,
                    'quantity_stock_initial' => $quantityStockInitialDestination,
                    'value_stock_initial' => $valeurStockInitialDestination,
                    'stockin_no' => $data->stockin_no,
                    'quantity_stockin' => $data->quantity,
                    'value_stockin' => $data->total_amount_purchase,
                    'quantity_stock_final' => $quantityStockInitialDestination + $data->quantity,
                    'value_stock_final' => $valeurStockInitialDestination + $data->total_amount_purchase,
                    'created_by' => $this->user->name,
                    'transaction' => "ENTREE",
                    'description' => $data->description,
                    'date' => $data->date,
                    'type_transaction' => $data->item_movement_type,
                    'document_no' => $stockin_no,
                    'created_at' => \Carbon\Carbon::now()
                );
                $reportFuelData[] = $reportData;

                    $pump = array(
                        'id' => $data->pump_id,
                        'quantity' => $quantityTotalPump,
                        'total_purchase_value' => $quantityTotalPump * $data->purchase_price,
                        'cump' => $cump,
                        'verified' => false
                    );

                    $pumpData[] = $pump;

                    $fuelData = array(
                        'id' => $data->fuel_id,
                        'quantity' => $quantityTotalPump,
                        'cump' => $cump
                    );


                        $fuel = MsFuelPump::where("fuel_id",$data->fuel_id)->value('fuel_id');

                        if (!empty($fuel)) {
                            $flag = 1;
                            MsFuelPump::where('id',$data->pump_id)
                        ->update($pump);
                        MsFuel::where('id',$data->fuel_id)
                        ->update($fuelData);
                        }else{
                            $flag = 0;
                            session()->flash('error', 'this type of fuel is not linkded to the pump');
                            return back();
                        }
  
        }

        if ($flag != 0) {
            MsFuelReport::insert($reportFuelData);
        }

        MsFuelStockin::where('stockin_no', '=', $stockin_no)
                        ->update(['status' => 4,'approuved_by' => $this->user->name]);
        MsFuelStockinDetail::where('stockin_no', '=', $stockin_no)
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $stockin_no
     * @return \Illuminate\Http\Response
     */
    public function destroy($stockin_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_fuel_stockin.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any stockin !');
        }

        $stockin = MsFuelStockin::where('stockin_no',$stockin_no)->first();
        if (!is_null($stockin)) {
            $stockin->delete();
            MsFuelStockinDetail::where('stockin_no',$stockin_no)->delete();
        }

        session()->flash('success', 'Stockin has been deleted !!');
        return back();
    }
}
