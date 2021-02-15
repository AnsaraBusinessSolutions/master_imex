<?php

namespace App\Http\Controllers;

use App\importdata;
use App\ibd_po_detail;
use App\Hssmaster;
use App\Materialmaster;
use App\pgi_details;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;
class ImportdataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        $master = $request->input('master');
        $msg = $master;
        $path= request()->file('file');
        if($master=='stock'){
            $bccnt=importdata::count();
            $customers = (new FastExcel)->import($path, function ($line) {
                return importdata::updateOrCreate([
                    'nupco_trade_code' => $line['nupco_trade_code'],
                    'plant' => $line['plant'],
                    'storage_location' => $line['storage_location'],
                    'vendor_batch' => $line['vendor_batch']
                ],[
                    'customer' => $line['customer'],
                    'nupco_generic_code' => $line['nupco_generic_code'],
                    'nupco_trade_code' => $line['nupco_trade_code'],
                    'customer_trade_code' => $line['customer_trade_code'],
                    'nupco_desc' => $line['nupco_desc'],
                    'plant' => $line['plant'],
                    'storage_location' => $line['storage_location'],
                    'unrestricted_stock_qty' => $line['unrestricted_stock_qty'],
                    'vendor_batch' => $line['vendor_batch'],
                    'uom' => $line['uom'],
                    'batch' => $line['batch'],
                    'map' => $line['map'],
                    'stock_value' => $line['stock_value'],
                    'mfg_date' => $line['mfg_date'],
                    'expiry_date' => $line['expiry_date']
                ]);
            });
            $iccnt=count($customers);
            $accnt=importdata::count();
            $msg = "Stock Total :".$accnt." | Created ".($accnt-$bccnt)." | Updated ".($iccnt-($accnt-$bccnt));
            return view('home')->with('datas',$msg);
        }elseif($master=='ibd_po_details'){
            $bccnt=ibd_po_detail::count();
            $customers = (new FastExcel)->import($path, function ($line) {
                return ibd_po_detail::updateOrCreate([
                    'nupco_po_no' => $line['nupco_po_no'],
                    'nupco_po_item' => $line['nupco_po_item']
                ],[
                    'nupco_po_no' => $line['nupco_po_no'],
                    'nupco_po_item' => $line['nupco_po_item'],
                    'plant' => $line['plant'],
                    'nupco_material' => $line['nupco_material'],
                    'po_date' => $line['po_date'],
                    'nupco_material_description' => $line['nupco_material_description'],
                    'order_quantity' => $line['order_quantity'],
                    'open_qty' => $line['open_qty'],
                    'order_unit' => $line['order_unit'],
                    'price_unit' => $line['price_unit'],
                    'net_order_price' => $line['net_order_price'],
                    'net_order_value' => $line['net_order_value'],
                    'currency' => $line['currency'],
                    'storage_location' => $line['storage_location'],
                    'vendor_no' => $line['vendor_no'],
                    'vendor_name' => $line['vendor_name'],
                    'status' => $line['status'],
                    'trade_code' => $line['trade_code'],
                    'po_delivery_date' => $line['po_delivery_date'],
                    'moh_tender_no' => $line['moh_tender_no'],
                    'cust_mat_code' => $line['cust_mat_code'],
                    'cust_no' => $line['cust_no'],
                    'cust_name' => $line['cust_name'],
                    'cust_cont_no' => $line['cust_cont_no'],
                    'moh_po_no' => $line['moh_po_no'],
                    'so_ref' => $line['so_ref'],
                    'so_ref_item' => $line['so_ref_item'],
                    'delivery_completed' => $line['delivery_completed'],
                    'deletion_indicator' => $line['deletion_indicator'],
                    'item_status' => $line['item_status'],
                    'last_update' => $line['last_update'],
                    'qty_inv' => $line['qty_inv'],
                    'value_inv' => $line['value_inv'],
                    'qty_inv_open' => $line['qty_inv_open'],
                    'value_inv_open' => $line['value_inv_open'],
                    'release_indicator' => $line['release_indicator'],
                    'po_type' => $line['po_type'],
                    'cust_ship_to' => $line['cust_ship_to'],
                    'cust_ship_to_name' => $line['cust_ship_to_name']
                ]);
            });
            $iccnt=count($customers);
            $accnt=ibd_po_detail::count();
            $msg = "PO Total :".$accnt." | Created ".($accnt-$bccnt)." | Updated ".($iccnt-($accnt-$bccnt));
            return view('home')->with('datas',$msg);
        }elseif($master=='pgi_details'){
            $bccnt=pgi_details::count();
            $customers = (new FastExcel)->import($path, function ($line) {
                return pgi_details::Create([
                    'pgi_id' => $line['pgi_id'],
                    'obd_no' => $line['obd_no'],
                    'batch_qty' => $line['batch_qty'],
                    'batch_no' => $line['batch_no'],
                    'manufacture_date' => $line['manufacture_date'],
                    'expiry_date' => $line['expiry_date'],
                    'order_id' => $line['order_id'],
                    'order_main_id' => $line['order_main_id'],
                    'category' => $line['category'],
                    'nupco_generic_code' => $line['nupco_generic_code'],
                    'nupco_trade_code' => $line['nupco_trade_code'],
                    'customer_trade_code' => $line['customer_trade_code'],
                    'material_desc' => $line['material_desc'],
                    'qty_ordered' => $line['qty_ordered'],
                    'uom' => $line['uom'],
                    'delivery_date' => $line['delivery_date'],
                    'supplying_plant_code' => $line['supplying_plant_code'],
                    'supplying_plant' => $line['supplying_plant'],
                    'sloc_id' => $line['sloc_id'],
                    'hss_master_no' => $line['hss_master_no'],
                    'hospital_name' => $line['hospital_name'],
                    'vehicle_no' => $line['vehicle_no'],
                    'created_at' => $line['created_at'],
                    'updated_at' => $line['updated_at'],
                    'pgi_status' => $line['pgi_status'],
                    '3pl_ref' => $line['3pl_ref'],
                    'ship_date' => $line['ship_date']
                ]);
            });
            $iccnt=count($customers);
            $accnt=pgi_details::count();
            $msg = "PO Total :".$accnt." | Created ".($accnt-$bccnt)." | Updated ".($iccnt-($accnt-$bccnt));
            return view('home')->with('datas',$msg);
        }else{
            return view('home')->with('datas',$msg);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $tname=$request->input('master');
        $tim=Carbon::now()->toDateTimeString();
        if($tname=='stock'){$tname=importdata::all();$ename='Stock_'.$tim;}
        elseif($tname=='hss_master'){$tname=Hssmaster::all();$ename='HSS_Master_'.$tim;}
        elseif($tname=='material_master'){$tname=Materialmaster::all();$ename='Material_Master'.$tim;}
        //return ($ename);
        return (new FastExcel($tname))->download($ename.'.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\importdata  $importdata
     * @return \Illuminate\Http\Response
     */
    public function show(importdata $importdata)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\importdata  $importdata
     * @return \Illuminate\Http\Response
     */
    public function edit(importdata $importdata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\importdata  $importdata
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, importdata $importdata)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\importdata  $importdata
     * @return \Illuminate\Http\Response
     */
    public function destroy(importdata $importdata)
    {
        //
    }
}
