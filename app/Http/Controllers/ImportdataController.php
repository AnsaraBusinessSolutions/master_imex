<?php

namespace App\Http\Controllers;

// use App\ProductTable;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Box\Spout\Writer\Style\StyleBuilder;
use Carbon\Carbon;
use DB;

use App\Models\account_groups;
use App\Models\admins;
use App\Models\assortment_lists;
use App\Models\assortment_masters;
use App\Models\auom;
use App\Models\auom_api_logs;
use App\Models\batch_list;
use App\Models\countries;
use App\Models\cust_category;
use App\Models\custodian_hss_connection;
use App\Models\department_order_details;
use App\Models\departments;
use App\Models\failed_jobs;
use App\Models\gi_details;
use App\Models\grn_details;
use App\Models\gtin;
use App\Models\gtin_api_logs;
use App\Models\hss_master;
use App\Models\hss_master_logs;
use App\Models\ibd_asn_batch_tmps;
use App\Models\ibd_asn_details;
use App\Models\ibd_asn_gr_details;
use App\Models\ibd_asn_gr_item_logs;
use App\Models\ibd_asn_gr_logs;
use App\Models\ibd_grn_logs;
use App\Models\ibd_grns;
use App\Models\ibd_invoice_attachment_tmps;
use App\Models\ibd_invoice_attachments;
use App\Models\ibd_invoice_details;
use App\Models\ibd_invoice_masters;
use App\Models\ibd_pallet_count;
use App\Models\ibd_plant_details;
use App\Models\ibd_po_detail_api_logs;
use App\Models\ibd_po_details;
use App\Models\ibd_po_req;
use App\Models\ibd_request_po;
use App\Models\ibd_reservation_req;
use App\Models\ibd_reservation_req_logs;
use App\Models\ibd_rgr_batch_tmps;
use App\Models\ibd_rgr_details;
use App\Models\ibd_rgr_wh;
use App\Models\ibd_str_type;
use App\Models\ibd_users;
use App\Models\material_category_masters;
use App\Models\material_master;
use App\Models\material_master_logs;
use App\Models\migrations;
use App\Models\ministry_logo;
use App\Models\order_details;
use App\Models\password_resets;
use App\Models\pgi_details;
use App\Models\planning_parameters;
use App\Models\plant_data;
use App\Models\plant_data_api_logs;
use App\Models\regions;
use App\Models\report_users;
use App\Models\reservation_logs;
use App\Models\reservations;
use App\Models\return_order_details;
use App\Models\sales_order;
use App\Models\sales_order_log;
use App\Models\sales_order_status;
use App\Models\sales_order_status_logs;
use App\Models\sales_org;
use App\Models\sloc_api_logs;
use App\Models\sloc_master;
use App\Models\stock;
use App\Models\stock_consumption;
use App\Models\stock_logs;
use App\Models\stock_old;
use App\Models\supplier_banks;
use App\Models\supplier_company_infos;
use App\Models\supplier_contact_infos;
use App\Models\supplier_products;
use App\Models\supplier_vat_details;
use App\Models\supplier_vat_file_types;
use App\Models\supplying_plant;
use App\Models\talend_webservices;
use App\Models\users;
use App\Models\vaccine_bom;
use App\Models\vendor_master_logs;
use App\Models\vendor_masters;
use App\Models\vendor_types;
use App\Models\webservices;

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
        $tim=Carbon::now()->toDateTimeString();
        $ename=$tname.'_'.$tim;
        if($tname=='account_groups'){ $tname=account_groups::all();
        }elseif($tname=='admins'){ $tname=admins::all();
        }elseif($tname=='assortment_lists'){ $tname=assortment_lists::all();
        }elseif($tname=='assortment_masters'){ $tname=assortment_masters::all();
        }elseif($tname=='auom'){ $tname=auom::all();
        }elseif($tname=='auom_api_logs'){ $tname=auom_api_logs::all();
        }elseif($tname=='batch_list'){ $tname=batch_list::all();
        }elseif($tname=='countries'){ $tname=countries::all();
        }elseif($tname=='cust_category'){ $tname=cust_category::all();
        }elseif($tname=='custodian_hss_connection'){ $tname=custodian_hss_connection::all();
        }elseif($tname=='department_order_details'){ $tname=department_order_details::all();
        }elseif($tname=='departments'){ $tname=departments::all();
        }elseif($tname=='failed_jobs'){ $tname=failed_jobs::all();
        }elseif($tname=='gi_details'){ $tname=gi_details::all();
        }elseif($tname=='grn_details'){ $tname=grn_details::all();
        }elseif($tname=='gtin'){ $tname=gtin::all();
        }elseif($tname=='gtin_api_logs'){ $tname=gtin_api_logs::all();
        }elseif($tname=='hss_master'){ $tname=hss_master::all();
        }elseif($tname=='hss_master_logs'){ $tname=hss_master_logs::all();
        }elseif($tname=='ibd_asn_batch_tmps'){ $tname=ibd_asn_batch_tmps::all();
        }elseif($tname=='ibd_asn_details'){ $tname=ibd_asn_details::all();
        }elseif($tname=='ibd_asn_gr_details'){ $tname=ibd_asn_gr_details::all();
        }elseif($tname=='ibd_asn_gr_item_logs'){ $tname=ibd_asn_gr_item_logs::all();
        }elseif($tname=='ibd_asn_gr_logs'){ $tname=ibd_asn_gr_logs::all();
        }elseif($tname=='ibd_grn_logs'){ $tname=ibd_grn_logs::all();
        }elseif($tname=='ibd_grns'){ $tname=ibd_grns::all();
        }elseif($tname=='ibd_invoice_attachment_tmps'){ $tname=ibd_invoice_attachment_tmps::all();
        }elseif($tname=='ibd_invoice_attachments'){ $tname=ibd_invoice_attachments::all();
        }elseif($tname=='ibd_invoice_details'){ $tname=ibd_invoice_details::all();
        }elseif($tname=='ibd_invoice_masters'){ $tname=ibd_invoice_masters::all();
        }elseif($tname=='ibd_pallet_count'){ $tname=ibd_pallet_count::all();
        }elseif($tname=='ibd_plant_details'){ $tname=ibd_plant_details::all();
        }elseif($tname=='ibd_po_detail_api_logs'){ $tname=ibd_po_detail_api_logs::all();
        }elseif($tname=='ibd_po_details'){ $tname=ibd_po_details::all();
        }elseif($tname=='ibd_po_req'){ $tname=ibd_po_req::all();
        }elseif($tname=='ibd_request_po'){ $tname=ibd_request_po::all();
        }elseif($tname=='ibd_reservation_req'){ $tname=ibd_reservation_req::all();
        }elseif($tname=='ibd_reservation_req_logs'){ $tname=ibd_reservation_req_logs::all();
        }elseif($tname=='ibd_rgr_batch_tmps'){ $tname=ibd_rgr_batch_tmps::all();
        }elseif($tname=='ibd_rgr_details'){ $tname=ibd_rgr_details::all();
        }elseif($tname=='ibd_rgr_wh'){ $tname=ibd_rgr_wh::all();
        }elseif($tname=='ibd_str_type'){ $tname=ibd_str_type::all();
        }elseif($tname=='ibd_users'){ $tname=ibd_users::all();
        }elseif($tname=='material_category_masters'){ $tname=material_category_masters::all();
        }elseif($tname=='material_master'){ $tname=material_master::all();
        }elseif($tname=='material_master_logs'){ $tname=material_master_logs::all();
        }elseif($tname=='migrations'){ $tname=migrations::all();
        }elseif($tname=='ministry_logo'){ $tname=ministry_logo::all();
        }elseif($tname=='order_details'){ $tname=order_details::all();
        }elseif($tname=='password_resets'){ $tname=password_resets::all();
        }elseif($tname=='pgi_details'){ $tname=pgi_details::all();
        }elseif($tname=='planning_parameters'){ $tname=planning_parameters::all();
        }elseif($tname=='plant_data'){ $tname=plant_data::all();
        }elseif($tname=='plant_data_api_logs'){ $tname=plant_data_api_logs::all();
        }elseif($tname=='regions'){ $tname=regions::all();
        }elseif($tname=='report_users'){ $tname=report_users::all();
        }elseif($tname=='reservation_logs'){ $tname=reservation_logs::all();
        }elseif($tname=='reservations'){ $tname=reservations::all();
        }elseif($tname=='return_order_details'){ $tname=return_order_details::all();
        }elseif($tname=='sales_order'){ $tname=sales_order::all();
        }elseif($tname=='sales_order_log'){ $tname=sales_order_log::all();
        }elseif($tname=='sales_order_status'){ $tname=sales_order_status::all();
        }elseif($tname=='sales_order_status_logs'){ $tname=sales_order_status_logs::all();
        }elseif($tname=='sales_org'){ $tname=sales_org::all();
        }elseif($tname=='sloc_api_logs'){ $tname=sloc_api_logs::all();
        }elseif($tname=='sloc_master'){ $tname=sloc_master::all();
        }elseif($tname=='stock'){ $tname=stock::all();
        }elseif($tname=='stock_consumption'){ $tname=stock_consumption::all();
        }elseif($tname=='stock_logs'){ $tname=stock_logs::all();
        }elseif($tname=='stock_old'){ $tname=stock_old::all();
        }elseif($tname=='supplier_banks'){ $tname=supplier_banks::all();
        }elseif($tname=='supplier_company_infos'){ $tname=supplier_company_infos::all();
        }elseif($tname=='supplier_contact_infos'){ $tname=supplier_contact_infos::all();
        }elseif($tname=='supplier_products'){ $tname=supplier_products::all();
        }elseif($tname=='supplier_vat_details'){ $tname=supplier_vat_details::all();
        }elseif($tname=='supplier_vat_file_types'){ $tname=supplier_vat_file_types::all();
        }elseif($tname=='supplying_plant'){ $tname=supplying_plant::all();
        }elseif($tname=='talend_webservices'){ $tname=talend_webservices::all();
        }elseif($tname=='users'){ $tname=users::all();
        }elseif($tname=='vaccine_bom'){ $tname=vaccine_bom::all();
        }elseif($tname=='vendor_master_logs'){ $tname=vendor_master_logs::all();
        }elseif($tname=='vendor_masters'){ $tname=vendor_masters::all();
        }elseif($tname=='vendor_types'){ $tname=vendor_types::all();
        }elseif($tname=='webservices'){ $tname=webservices::all();
        }else{$tname='';}
        //$tname=$tname::all();
        //print_r($tname);die;
        
        // if($tname=='stock'){$tname=importdata::all();$ename='Stock_'.$tim;}
        // elseif($tname=='hss_master'){$tname=Hssmaster::all();$ename='HSS_Master_'.$tim;}
        // elseif($tname=='material_master'){$tname=Materialmaster::all();$ename='Material_Master'.$tim;}
        //return ($ename);
        $header_style = (new StyleBuilder())->setFontBold()->build();

        $rows_style = (new StyleBuilder())
            ->setFontSize(11)
            ->setShouldWrapText(false)
            ->build();

        return (new FastExcel($tname))
            ->headerStyle($header_style)
            ->rowsStyle($rows_style)
            ->download($ename.'.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function master(Request $request)
    {
        $tname=$request->master;
        if($tname=='account_groups'){ $tname=account_groups::count();
        }elseif($tname=='admins'){ $tname=admins::count();
        }elseif($tname=='assortment_lists'){ $tname=assortment_lists::count();
        }elseif($tname=='assortment_masters'){ $tname=assortment_masters::count();
        }elseif($tname=='auom'){ $tname=auom::count();
        }elseif($tname=='auom_api_logs'){ $tname=auom_api_logs::count();
        }elseif($tname=='batch_list'){ $tname=batch_list::count();
        }elseif($tname=='countries'){ $tname=countries::count();
        }elseif($tname=='cust_category'){ $tname=cust_category::count();
        }elseif($tname=='custodian_hss_connection'){ $tname=custodian_hss_connection::count();
        }elseif($tname=='department_order_details'){ $tname=department_order_details::count();
        }elseif($tname=='departments'){ $tname=departments::count();
        }elseif($tname=='failed_jobs'){ $tname=failed_jobs::count();
        }elseif($tname=='gi_details'){ $tname=gi_details::count();
        }elseif($tname=='grn_details'){ $tname=grn_details::count();
        }elseif($tname=='gtin'){ $tname=gtin::count();
        }elseif($tname=='gtin_api_logs'){ $tname=gtin_api_logs::count();
        }elseif($tname=='hss_master'){ $tname=hss_master::count();
        }elseif($tname=='hss_master_logs'){ $tname=hss_master_logs::count();
        }elseif($tname=='ibd_asn_batch_tmps'){ $tname=ibd_asn_batch_tmps::count();
        }elseif($tname=='ibd_asn_details'){ $tname=ibd_asn_details::count();
        }elseif($tname=='ibd_asn_gr_details'){ $tname=ibd_asn_gr_details::count();
        }elseif($tname=='ibd_asn_gr_item_logs'){ $tname=ibd_asn_gr_item_logs::count();
        }elseif($tname=='ibd_asn_gr_logs'){ $tname=ibd_asn_gr_logs::count();
        }elseif($tname=='ibd_grn_logs'){ $tname=ibd_grn_logs::count();
        }elseif($tname=='ibd_grns'){ $tname=ibd_grns::count();
        }elseif($tname=='ibd_invoice_attachment_tmps'){ $tname=ibd_invoice_attachment_tmps::count();
        }elseif($tname=='ibd_invoice_attachments'){ $tname=ibd_invoice_attachments::count();
        }elseif($tname=='ibd_invoice_details'){ $tname=ibd_invoice_details::count();
        }elseif($tname=='ibd_invoice_masters'){ $tname=ibd_invoice_masters::count();
        }elseif($tname=='ibd_pcountet_count'){ $tname=ibd_pcountet_count::count();
        }elseif($tname=='ibd_plant_details'){ $tname=ibd_plant_details::count();
        }elseif($tname=='ibd_po_detail_api_logs'){ $tname=ibd_po_detail_api_logs::count();
        }elseif($tname=='ibd_po_details'){ $tname=ibd_po_details::count();
        }elseif($tname=='ibd_po_req'){ $tname=ibd_po_req::count();
        }elseif($tname=='ibd_request_po'){ $tname=ibd_request_po::count();
        }elseif($tname=='ibd_reservation_req'){ $tname=ibd_reservation_req::count();
        }elseif($tname=='ibd_reservation_req_logs'){ $tname=ibd_reservation_req_logs::count();
        }elseif($tname=='ibd_rgr_batch_tmps'){ $tname=ibd_rgr_batch_tmps::count();
        }elseif($tname=='ibd_rgr_details'){ $tname=ibd_rgr_details::count();
        }elseif($tname=='ibd_rgr_wh'){ $tname=ibd_rgr_wh::count();
        }elseif($tname=='ibd_str_type'){ $tname=ibd_str_type::count();
        }elseif($tname=='ibd_users'){ $tname=ibd_users::count();
        }elseif($tname=='material_category_masters'){ $tname=material_category_masters::count();
        }elseif($tname=='material_master'){ $tname=material_master::count();
        }elseif($tname=='material_master_logs'){ $tname=material_master_logs::count();
        }elseif($tname=='migrations'){ $tname=migrations::count();
        }elseif($tname=='ministry_logo'){ $tname=ministry_logo::count();
        }elseif($tname=='order_details'){ $tname=order_details::count();
        }elseif($tname=='password_resets'){ $tname=password_resets::count();
        }elseif($tname=='pgi_details'){ $tname=pgi_details::count();
        }elseif($tname=='planning_parameters'){ $tname=planning_parameters::count();
        }elseif($tname=='plant_data'){ $tname=plant_data::count();
        }elseif($tname=='plant_data_api_logs'){ $tname=plant_data_api_logs::count();
        }elseif($tname=='regions'){ $tname=regions::count();
        }elseif($tname=='report_users'){ $tname=report_users::count();
        }elseif($tname=='reservation_logs'){ $tname=reservation_logs::count();
        }elseif($tname=='reservations'){ $tname=reservations::count();
        }elseif($tname=='return_order_details'){ $tname=return_order_details::count();
        }elseif($tname=='sales_order'){ $tname=sales_order::count();
        }elseif($tname=='sales_order_log'){ $tname=sales_order_log::count();
        }elseif($tname=='sales_order_status'){ $tname=sales_order_status::count();
        }elseif($tname=='sales_order_status_logs'){ $tname=sales_order_status_logs::count();
        }elseif($tname=='sales_org'){ $tname=sales_org::count();
        }elseif($tname=='sloc_api_logs'){ $tname=sloc_api_logs::count();
        }elseif($tname=='sloc_master'){ $tname=sloc_master::count();
        }elseif($tname=='stock'){ $tname=stock::count();
        }elseif($tname=='stock_consumption'){ $tname=stock_consumption::count();
        }elseif($tname=='stock_logs'){ $tname=stock_logs::count();
        }elseif($tname=='stock_old'){ $tname=stock_old::count();
        }elseif($tname=='supplier_banks'){ $tname=supplier_banks::count();
        }elseif($tname=='supplier_company_infos'){ $tname=supplier_company_infos::count();
        }elseif($tname=='supplier_contact_infos'){ $tname=supplier_contact_infos::count();
        }elseif($tname=='supplier_products'){ $tname=supplier_products::count();
        }elseif($tname=='supplier_vat_details'){ $tname=supplier_vat_details::count();
        }elseif($tname=='supplier_vat_file_types'){ $tname=supplier_vat_file_types::count();
        }elseif($tname=='supplying_plant'){ $tname=supplying_plant::count();
        }elseif($tname=='talend_webservices'){ $tname=talend_webservices::count();
        }elseif($tname=='users'){ $tname=users::count();
        }elseif($tname=='vaccine_bom'){ $tname=vaccine_bom::count();
        }elseif($tname=='vendor_master_logs'){ $tname=vendor_master_logs::count();
        }elseif($tname=='vendor_masters'){ $tname=vendor_masters::count();
        }elseif($tname=='vendor_types'){ $tname=vendor_types::count();
        }elseif($tname=='webservices'){ $tname=webservices::count();
        }else{$tname='';}
        return 'Total : '.$tname;
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
