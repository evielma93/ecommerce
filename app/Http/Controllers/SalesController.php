<?php

namespace App\Http\Controllers;
use App\Client;
use App\PaymentType;
use App\Inventory;
use App\Sale;
use App\SalesDetail;
use App\WayPay;
use App\Kardex;
use App\KardexDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SaleProcessed;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;

class SalesController extends Controller
{
    public $date;

    public function __construct()
    {
        $this->date = Carbon::now();
    }


    public function store($request)
    {

        $user = \Auth::user()->id;
        $id_client = DB::table('clients')->where([['status', '=', '1'],['user_id', '=',$user],])->first();
        //dd($request,$id_client->id); die();
        $Sale = new Sale();
        $Sale->client_id       = $id_client->id;
        $Sale->user_id         = 1;
        $Sale->payment_type_id = 3;
        $Sale->total_sale      = $request['value'];
        $Sale->code_seller     = $request['code_seller'];
        $Sale->save();
        dd($request,$Sale); die();
        $num = count($request->input('id_produc'));
        $id_produc = $cantidad = $vunit = $vtotal = 0;
        for ($i=0; $i<$num ; $i++) {
            $id_produc = $request->input('id_produc')[$i];
            $cantidad = $request->input('cantidad')[$i];
            $vunit = $request->input('vunit')[$i];
            $vtotal = $request->input('vtotal')[$i];
            $SalesDetail = new SalesDetail();
            $SalesDetail->sale_id       = $Sale->id;
            $SalesDetail->inventory_id  = $id_produc;
            $SalesDetail->quantity      = $cantidad;
            $SalesDetail->unit_value    = $vunit;
            $SalesDetail->total_value   = $vtotal;
            $SalesDetail->save();
        }

        $WayPay = new WayPay();
        $WayPay->sale_id      = $Sale->id;
        $WayPay->bank_id      = $request->input('banks');
        $WayPay->voucher      = $request->input('voucher');
        $WayPay->amount       = $request->input('monto');
        $WayPay->payment_date = $request->input('payment_date');
        $WayPay->save();

        $resp = $this->processKardex($request,$Sale->id);

        Mail::to($request['email'])->send(new SaleProcessed($request,$Sale->id));

        return back()->with('message', 'Venta realizada');
    }

    public function processKardex($request,$invoice)
    {

        $num = count($request->input('cantidad'));
        $quantity = $total_cost = $cal_ct = $unit_cost = 0;
        for ($i=0; $i<$num; $i++) {
            $kardexs = Kardex::where('inventory_id','=',$request->input('id_produc')[$i])->get();
            $kardexs = $kardexs->last();
            $kardex_detail = KardexDetails::where('kardex_id',$kardexs->id)->first()->toArray();
            $quantity = $kardex_detail['quantity_s'] - $request->input('cantidad')[$i];
            $cal_ct = $request->input('cantidad')[$i] * $kardexs->inventory->value;
            $total_cost = $kardex_detail['total_cost_s'] - $cal_ct;
            if ($total_cost == 0 || $quantity == 0) {
                $unit_cost = 0;
            }else{
                $unit_cost  = $total_cost / $quantity;
            }

            $kardex = new Kardex();
            $kardex->inventory_id = $request->input('id_produc')[$i];
            $kardex->events_id    = 3;
            $kardex->user_id      = \Auth::user()->id;
            $kardex->invoice      = $invoice;
            $kardex->save();

            $KardexDetails = new KardexDetails();
            $KardexDetails->kardex_id    = $kardex->id;
            $KardexDetails->quantity_e   = $request->input('cantidad')[$i];
            $KardexDetails->unit_cost_e  = $kardexs->inventory->value;
            $KardexDetails->total_cost_e = $cal_ct;
            $KardexDetails->quantity_s   = $quantity;
            $KardexDetails->unit_cost_s  = $unit_cost;
            $KardexDetails->total_cost_s = $total_cost;
            $KardexDetails->save();

            $inventory = Inventory::find($request->input('id_produc')[$i]);
            $inventory->stock = $quantity;
            $inventory->value = $unit_cost;
            $inventory->total_cost = $total_cost;
            $inventory->update();
        }

        $return = $kardex->id.' '.$KardexDetails->id;
        return $return;
    }

    function complete($id,$op)
    {
        $sale = Sale::find($id);
        $sale->status = 2;
        $sale->update();
        return back()->with('message','Venta Actualizada');
    }

    function details($id)
    {
        $sale         = Sale::find($id);
        $SalesDetail  = SalesDetail::where('sale_id',$sale->id)->get();
        foreach ($SalesDetail as $sale) {
            echo $sale->sale_id.'<br>';
            echo $sale->inventory_id.'<br>';
            echo $sale->quantity.'<br>';
            echo $sale->unit_value.'<br>';
            echo $sale->total_value.'<br>';
        }
        //return back()->with('message','Venta Actualizada');
    }

    function cancel(Request $request,$id,$op)
    {
        $sale = Sale::find($id);
        // $kardex = Kardex::where('invoice','=',$id)->first();
        // $kardex_detail = KardexDetails::where('kardex_id',$kardex->id)->get();
        // $kardex_detail = $kardex_detail->last();

        // echo $quantity = $kardex_detail['quantity_s'] + $kardex_detail['quantity_s'];
        // echo '<br>';
        // echo $cal_ct = $kardex_detail['quantity_s'] * $kardex_detail['total_cost_s'];
        // echo '<br>';
        // echo $total_cost = $kardex_detail['total_cost_s'] + $kardex_detail['total_cost_s'];
        // echo '<br>';
        // if ($total_cost == 0 || $quantity == 0) {
        //     $unit_cost = 0;
        // }else{
        //     $unit_cost  = $total_cost / $quantity;
        // }
        // dd($kardex->id,$kardex_detail); die();
        $sale->status = 0;
        $sale->update();
        return back()->with('message', 'Venta Anulada');
    }

    public function report()
    {
        $desde = 0;
        $hasta = 0;
        return view('sales.report',compact('desde','hasta'));
    }

    public function getDataReport(Request $request)
    {
        $desde = $request['desde'];
        $hasta = $request['hasta'];
        $getSales = Sale::whereBetween('created_at',[$request['desde'],$request['hasta']])->get();
        return view('sales.report',compact('getSales','desde','hasta'));
    }

    public function salesExcel(Request $request,$desde,$hasta)
    {
        $getSales = Sale::whereBetween('created_at',[$desde,$hasta])->get();
        return Excel::download(new SalesExport($getSales,$this->date),'Reporte_Ventas_'.$desde.'_'.$hasta.'.xlsx');
    }


}
