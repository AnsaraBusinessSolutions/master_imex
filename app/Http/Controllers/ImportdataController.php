<?php

namespace App\Http\Controllers;

// use App\ProductTable;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Box\Spout\Writer\Style\StyleBuilder;
use Carbon\Carbon;
use DB;

use App\Models\material_master;
use App\Models\ibd_po_details;
use App\Models\pgi_details;
use App\Models\stock;

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
            $bccnt=stock::count();
            $customers = (new FastExcel)->import($path, function ($line) {
                return stock::updateOrCreate([
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
            $accnt=stock::count();
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
        }elseif($master=='material_master'){
            $bccnt=material_master::count();
            $customers = (new FastExcel)->import($path, function ($line) {
                return material_master::Create([
                    'customer'=> $line['customer'],
                    'nupco_generic_code'=> $line['nupco_generic_code'],
                    'nupco_trade_code'=> $line['nupco_trade_code'],
                    'nupco_desc'=> $line['nupco_desc'],
                    'nupco_long_desc'=> $line['nupco_long_desc'],
                    'uom'=> $line['uom'],
                    'material_type'=> $line['material_type'],
                    'division'=> $line['division'],
                    'customer_code'=> $line['customer_code'],
                    'customer_code_cat'=> $line['customer_code_cat'],
                    'customer_desc'=> $line['customer_desc'],
                    'customer_long_desc'=> $line['customer_long_desc'],
                    'status'=> $line['status']
                ]);
            });
            $iccnt=count($customers);
            $accnt=material_master::count();
            $msg = "Material Master Total :".$accnt." | Created ".($accnt-$bccnt)." | Updated ".($iccnt-($accnt-$bccnt));
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
        $chk=$request->input('chk');
        $out=$request->input('out');
        $all=$request->input('all');
        $tim=Carbon::now()->toDateTimeString();
        if($all=='ALL'){
            $ename=$tname.'_'.$tim;
            $tname=DB::table($tname)->get();
            $header_style = (new StyleBuilder())->setFontBold()->build();
            $rows_style = (new StyleBuilder())
                ->setFontSize(11)
                ->setShouldWrapText(false)
                ->build();
            return (new FastExcel($tname))
                ->headerStyle($header_style)
                ->rowsStyle($rows_style)
                ->download($ename.'.xlsx');
        }else{
            if(empty($out) || empty($all)){
            return back();
            }
        for ($j=0; $j < count($chk); $j++) {
            $i=$chk[$j];
            $re[]=$i;
            $ins=$request->input("action-".$i);
            if($ins=="*"){
                return back();
            }
            if(strpos($ins,'*')){
                $val=explode("*", $ins);
                $where=$i." LIKE ".$val[0];
            }elseif(strpos($ins,',')){
                $val=explode(",", $ins);
                $vals="";$k="";
                foreach ($val as $key => $value) {
                    if($vals!=""){$k=",";}
                    $vals=$vals.$k.$value;
                }
                $where=$i." IN (".$vals.")";
            }elseif(strpos($ins,'-')){
                $val=explode("-", $ins);
                $where=$i." BETWEEN ".$val[0].' AND '.$val[1];
            }else{
                $where=$i." = ".$ins;
            }
            $wheres[]=$where;
        }
        $valus="";$l="";
        if(count($wheres)>1){
        foreach ($wheres as $key => $value) {
            if($valus!=""){$l=" OR ";}
            $valus=$valus.$l.$value;
        }}else{
            $valus=$wheres[0];
        }
        $valss="";$ks="";
        foreach ($out as $key => $value) {
            if($valss!=""){$ks=",";}
            $valss=$valss.$ks.$value;
        }
        $tbls=DB::select("SELECT ".$valss." FROM ".$tname." WHERE ".$valus);
        $data=json_encode($tbls);
        return view('exportview',compact('data','out'));
    }
        // $ename=$tname.'_'.$tim;
        // $tname=DB::table($tname)->get();
        // $header_style = (new StyleBuilder())->setFontBold()->build();
        // $rows_style = (new StyleBuilder())
        //     ->setFontSize(11)
        //     ->setShouldWrapText(false)
        //     ->build();
        // return (new FastExcel($tname))
        //     ->headerStyle($header_style)
        //     ->rowsStyle($rows_style)
        //     ->download($ename.'.xlsx');
    }

    public function master(Request $request)
    {
        $tname=$request->master;
        $count = DB::table($tname)->count();
        return 'Total : '.$count;
    }

    public function showall()
    {
        $DB=env("DB_DATABASE");
        $DB='Tables_in_'.$DB;
        $tbls=DB::select('SHOW TABLES');
        foreach ($tbls as $key => $value) {
            $tbl[]=$value->$DB;
        }
        return $tbl;
    }

    public function gettable(Request $request)
    {
        $tname=$request->master;
        $tblcols = DB::select("SHOW COLUMNS FROM ". $tname);
        return $tblcols;
    }

    public function search(Request $request)
    {
        $datas="hiiii";
        
    }


    public function view() 
    {
    //    //$productLog = new ProductLog('admins');

    // //$data = ProductTable::query()
    //         ->table('admins');

    // //$data = ProductTable::count();
    //     return response($data, 200);
    // $tbls=DB::select('SHOW TABLES');
    // //$tbls=json_encode($tbls);
    // foreach ($tbls as $value) {
    //     $tbl=$value->Tables_in_hos_s4;

    //     print_r("elseif("."$"."tname=='".$tbl."'){
    //             "."$"."tname=".$tbl."::all();<br>}");
        
    // }
    // die;
    // $path="app/Models/".$tbl.".php";
    //     $myfile = fopen($path, "w") or die("Unable to open file");
    //     $txt = "<?php

    //     namespace App;
    //     use Illuminate\Database\Eloquent\Model;

    //     class ".$tbl." extends Model
    //     {
    //         protected "."$"."table = '".$tbl."';
    //         protected "."$"."guarded = [];
    //     }";
    //     fwrite($myfile, $txt);
    //     fclose($myfile);
    }
}
