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
use App\Models\MsMaterial;
use App\Models\MsMaterialPurchase;
use App\Models\MsMaterialPurchaseDetail;
use App\Models\MsMaterialSupplierOrder;
use App\Models\MsMaterialSupplierOrderDetail;
use App\Models\MsMaterialSupplier;
use Validator;
use PDF;
use Mail;
use Carbon\Carbon;

class MaterialSupplierOrderController extends Controller
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
        if (is_null($this->user) || !$this->user->can('musumba_steel_material_supplier_order.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any order !');
        }

        $orders = MsMaterialSupplierOrder::orderBy('id','desc')->get();
        return view('backend.pages.musumba_steel.material_supplier_order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($purchase_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_material_supplier_order.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any order !');
        }

        $materials  = MsMaterial::orderBy('name','asc')->get();
        $suppliers  = MsMaterialSupplier::orderBy('name','asc')->get();
        $datas = MsMaterialPurchaseDetail::where('purchase_no', $purchase_no)->get();
        return view('backend.pages.musumba_steel.material_supplier_order.create', compact('materials','purchase_no','datas','suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('musumba_steel_material_supplier_order.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any order !');
        }

        $rules = array(
                'material_id.*'  => 'required',
                'date'  => 'required',
                'unit.*'  => 'required',
                'quantity.*'  => 'required',
                'purchase_price.*'  => 'required',
                'purchase_no'  => 'required',
                'description'  => 'required'
            );

            $error = Validator::make($request->all(),$rules);

            if($error->fails()){
                return response()->json([
                    'error' => $error->errors()->all(),
                ]);
            }

            try {DB::beginTransaction();

            $material_id = $request->material_id;
            $date = $request->date;
            $purchase_no = $request->purchase_no;
            $description =$request->description; 
            $supplier_id =$request->supplier_id; 
            $unit = $request->unit;
            $quantity = $request->quantity;
            $purchase_price = $request->purchase_price;
            

            $latest = MsMaterialSupplierOrder::latest()->first();
            if ($latest) {
               $order_no = 'BCF' . (str_pad((int)$latest->id + 1, 4, '0', STR_PAD_LEFT)); 
            }else{
               $order_no = 'BCF' . (str_pad((int)0 + 1, 4, '0', STR_PAD_LEFT));  
            }

            $created_by = $this->user->name;

            $order_signature = "4001711615".Carbon::parse(Carbon::now())->format('YmdHis')."/".$order_no;


            for( $count = 0; $count < count($material_id); $count++ ){
                $total_value = $quantity[$count] * $purchase_price[$count];
                $data = array(
                    'material_id' => $material_id[$count],
                    'date' => $date,
                    'quantity' => $quantity[$count],
                    'quantity' => $quantity[$count],
                    'unit' => $unit[$count],
                    'purchase_price' => $purchase_price[$count],
                    'total_value' => $total_value,
                    'purchase_no' => $purchase_no,
                    'order_no' => $order_no,
                    'supplier_id' => $supplier_id,
                    'order_signature' => $order_signature,
                    'created_by' => $created_by,
                    'description' => $description,
                    'status' => 1,
                    'created_at' => \Carbon\Carbon::now()

                );
                $insert_data[] = $data;

                
            }
            MsMaterialSupplierOrderDetail::insert($insert_data);


            //create order
            $order = new MsMaterialSupplierOrder();
            $order->date = $date;
            $order->order_no = $order_no;
            $order->order_signature = $order_signature;
            $order->purchase_no = $purchase_no;
            $order->supplier_id = $supplier_id;
            $order->created_by = $created_by;
            $order->status = 1;
            $order->description = $description;
            $order->save();

            DB::commit();
            session()->flash('success', 'order has been created !!');
            return redirect()->route('admin.ms-material-supplier-orders.index');
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
    public function show($order_no)
    {
        //
        $code = MsMaterialSupplierOrderDetail::where('order_no', $order_no)->value('order_no');
        $orders = MsMaterialSupplierOrderDetail::where('order_no', $order_no)->get();
        return view('backend.pages.musumba_steel.material_supplier_order.show', compact('orders','code'));
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($order_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_material_supplier_order.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any order !');
        }

        $materials  = MsMaterial::all();
        $order = MsMaterialSupplierOrder::where('order_no', $order_no)->first();
        $datas = MsMaterialSupplierOrderDetail::where('order_no', $order_no)->get();
        return view('backend.pages.musumba_steel.material_supplier_order.edit', compact('materials','datas','order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $purchase_no
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $purchase_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_material_supplier_order.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any order !');
        }

        
    }

    public function validateOrder($order_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_material_supplier_order.validate')) {
            abort(403, 'Sorry !! You are Unauthorized to validate any order !');
        }
            MsMaterialSupplierOrder::where('order_no', '=', $order_no)
                ->update(['status' => 2,'validated_by' => $this->user->name]);
            MsMaterialSupplierOrderDetail::where('order_no', '=', $order_no)
                ->update(['status' => 2,'validated_by' => $this->user->name]);

        session()->flash('success', 'order has been validated !!');
        return back();
    }

    public function reject($order_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_material_supplier_order.reject')) {
            abort(403, 'Sorry !! You are Unauthorized to reject any order !');
        }

        MsMaterialSupplierOrder::where('order_no', '=', $order_no)
                ->update(['status' => -1,'rejected_by' => $this->user->name]);
            MsMaterialSupplierOrderDetail::where('order_no', '=', $order_no)
                ->update(['status' => -1,'rejected_by' => $this->user->name]);

        session()->flash('success', 'Order has been rejected !!');
        return back();
    }

    public function reset($order_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_material_supplier_order.reset')) {
            abort(403, 'Sorry !! You are Unauthorized to reset any order !');
        }

        MsMaterialSupplierOrder::where('order_no', '=', $order_no)
                ->update(['status' => 1,'reseted_by' => $this->user->name]);
            MsMaterialSupplierOrderDetail::where('order_no', '=', $order_no)
                ->update(['status' => 1,'reseted_by' => $this->user->name]);

        session()->flash('success', 'Order has been reseted !!');
        return back();
    }

    public function confirm($order_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_material_supplier_order.confirm')) {
            abort(403, 'Sorry !! You are Unauthorized to confirm any order !');
        }

        MsMaterialSupplierOrder::where('order_no', '=', $order_no)
                ->update(['status' => 3,'confirmed_by' => $this->user->name]);
            MsMaterialSupplierOrderDetail::where('order_no', '=', $order_no)
                ->update(['status' => 3,'confirmed_by' => $this->user->name]);

        session()->flash('success', 'Order has been confirmed !!');
        return back();
    }

    public function approuve($order_no)
    {
       if (is_null($this->user) || !$this->user->can('musumba_steel_material_supplier_order.approuve')) {
            abort(403, 'Sorry !! You are Unauthorized to confirm any order !');
        }

        try {DB::beginTransaction();

        MsMaterialSupplierOrder::where('order_no', '=', $order_no)
                ->update(['status' => 4,'approuved_by' => $this->user->name]);
            MsMaterialSupplierOrderDetail::where('order_no', '=', $order_no)
                ->update(['status' => 4,'approuved_by' => $this->user->name]);

        $purchase_no = MsMaterialSupplierOrder::where('order_no',$order_no)->value('purchase_no');

        MsMaterialPurchase::where('purchase_no', '=', $purchase_no)
                        ->update(['status' => 5]);
        MsMaterialPurchaseDetail::where('purchase_no', '=', $purchase_no)
                        ->update(['status' => 5]);

        DB::commit();
            session()->flash('success', 'Order has been confirmed !!');
            return back();
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...

            DB::rollback();

            // and throw the error again.

            throw $e;
        }

    }

    public function materialSupplierOrder($order_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_material_supplier_order.create')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }

        $setting = DB::table('settings')->orderBy('created_at','desc')->first();
        $stat = MsMaterialSupplierOrder::where('order_no', $order_no)->value('status');
        $description = MsMaterialSupplierOrder::where('order_no', $order_no)->value('description');
        $date = MsMaterialSupplierOrder::where('order_no', $order_no)->value('date');
        $data = MsMaterialSupplierOrder::where('order_no', $order_no)->first();
        if($stat == 2 && $stat == 3 || $stat == 4 || $stat == 5){
           $order_no = MsMaterialSupplierOrder::where('order_no', $order_no)->value('order_no');
           $order_signature = MsMaterialSupplierOrder::where('order_no', $order_no)->value('order_signature');
           $totalValue = DB::table('ms_material_supplier_order_details')
            ->where('order_no', '=', $order_no)
            ->sum('total_value');

           $datas = MsMaterialSupplierOrderDetail::where('order_no', $order_no)->get();
           $pdf = PDF::loadView('backend.pages.musumba_steel.document.material_supplier_order',compact('datas','order_no','setting','description','date','order_signature','totalValue','data'));

           Storage::put('public/musumba_steel/material_supplier_order/'.'FICHE_COMMANDE_'.$order_no.'.pdf', $pdf->output());

           // download pdf file
           return $pdf->download('FICHE_COMMANDE_'.$order_no.'.pdf'); 
           
        }else if ($stat == -1) {
            session()->flash('error', 'Order has been rejected !!');
            return back();
        }else{
            session()->flash('error', 'wait until Order will be validated !!');
            return back();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $order_no
     * @return \Illuminate\Http\Response
     */
    public function destroy($order_no)
    {
        if (is_null($this->user) || !$this->user->can('musumba_steel_material_supplier_order.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any order !');
        }

        $order = MsMaterialSupplierOrder::where('order_no',$order_no)->first();
        if (!is_null($order)) {
            $order->delete();           
            MsMaterialSupplierOrderDetail::where('order_no',$order_no)->delete();
        }

        session()->flash('success', 'Order has been deleted !!');
        return back();
    }
}
