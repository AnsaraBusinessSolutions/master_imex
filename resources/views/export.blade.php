@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <a href="home" class="col-md-6 center btn">
                            {{ __('Import') }}
                        </a>
                        <a href="export" class="col-md-6 btn">
                            {{ __('Export') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('exports') }}" method="post" enctype="multipart/form-data">

                        @csrf

                        <label>Choose Master:</label>

                        <select id="master" name="master">

                            <option value="" disabled selected>Select Table</option>
                            <option value="account_groups">account_groups </option>
                            <option value="admins">admins </option>
                            <option value="assortment_lists">assortment_lists </option>
                            <option value="assortment_masters">assortment_masters </option>
                            <option value="auom">auom </option>
                            <option value="auom_api_logs">auom_api_logs </option>
                            <option value="batch_list">batch_list </option>
                            <option value="bom_assignments">bom_assignments </option>
                            <option value="countries">countries </option>
                            <option value="custodian_hss_connection">custodian_hss_connection </option>
                            <option value="cust_category">cust_category </option>
                            <option value="departments">departments </option>
                            <option value="department_order_details">department_order_details </option>
                            <option value="failed_jobs">failed_jobs </option>
                            <option value="gi_details">gi_details </option>
                            <option value="grn_details">grn_details </option>
                            <option value="gtin">gtin </option>
                            <option value="gtin_api_logs">gtin_api_logs </option>
                            <option value="hss_master">hss_master </option>
                            <option value="hss_master_logs">hss_master_logs </option>
                            <option value="ibd_asn_batch_tmps">ibd_asn_batch_tmps </option>
                            <option value="ibd_asn_details">ibd_asn_details </option>
                            <option value="ibd_asn_gr_details">ibd_asn_gr_details </option>
                            <option value="ibd_asn_gr_item_logs">ibd_asn_gr_item_logs </option>
                            <option value="ibd_asn_gr_logs">ibd_asn_gr_logs </option>
                            <option value="ibd_grns">ibd_grns </option>
                            <option value="ibd_grn_logs">ibd_grn_logs </option>
                            <option value="ibd_invoice_attachments">ibd_invoice_attachments </option>
                            <option value="ibd_invoice_attachment_tmps">ibd_invoice_attachment_tmps </option>
                            <option value="ibd_invoice_details">ibd_invoice_details </option>
                            <option value="ibd_invoice_masters">ibd_invoice_masters </option>
                            <option value="ibd_pallet_count">ibd_pallet_count </option>
                            <option value="ibd_plant_details">ibd_plant_details </option>
                            <option value="ibd_po_details">ibd_po_details </option>
                            <option value="ibd_po_detail_api_logs">ibd_po_detail_api_logs </option>
                            <option value="ibd_po_req">ibd_po_req </option>
                            <option value="ibd_request_po">ibd_request_po </option>
                            <option value="ibd_reservation_req">ibd_reservation_req </option>
                            <option value="ibd_reservation_req_item_logs">ibd_reservation_req_item_logs </option>
                            <option value="ibd_reservation_req_logs">ibd_reservation_req_logs </option>
                            <option value="ibd_rgr_batch_tmps">ibd_rgr_batch_tmps </option>
                            <option value="ibd_rgr_details">ibd_rgr_details </option>
                            <option value="ibd_rgr_wh">ibd_rgr_wh </option>
                            <option value="ibd_str_type">ibd_str_type </option>
                            <option value="ibd_users">ibd_users </option>
                            <option value="material_category_masters">material_category_masters </option>
                            <option value="material_master">material_master </option>
                            <option value="material_master_logs">material_master_logs </option>
                            <option value="migrations">migrations </option>
                            <option value="ministry_logo">ministry_logo </option>
                            <option value="order_details">order_details </option>
                            <option value="password_resets">password_resets </option>
                            <option value="pgi_details">pgi_details </option>
                            <option value="planning_parameters">planning_parameters </option>
                            <option value="planning_result">planning_result </option>
                            <option value="plant_data">plant_data </option>
                            <option value="plant_data_api_logs">plant_data_api_logs </option>
                            <option value="regions">regions </option>
                            <option value="report_users">report_users </option>
                            <option value="reservations">reservations </option>
                            <option value="reservation_logs">reservation_logs </option>
                            <option value="return_order_details">return_order_details </option>
                            <option value="sales_order">sales_order </option>
                            <option value="sales_order_log">sales_order_log </option>
                            <option value="sales_order_status">sales_order_status </option>
                            <option value="sales_order_status_logs">sales_order_status_logs </option>
                            <option value="sales_org">sales_org </option>
                            <option value="sloc_api_logs">sloc_api_logs </option>
                            <option value="sloc_master">sloc_master </option>
                            <option value="stock">stock </option>
                            <option value="stock_adjustments">stock_adjustments </option>
                            <option value="stock_consumption">stock_consumption </option>
                            <option value="stock_logs">stock_logs </option>
                            <option value="stock_old">stock_old </option>
                            <option value="supplier_banks">supplier_banks </option>
                            <option value="supplier_company_infos">supplier_company_infos </option>
                            <option value="supplier_contact_infos">supplier_contact_infos </option>
                            <option value="supplier_products">supplier_products </option>
                            <option value="supplier_vat_details">supplier_vat_details </option>
                            <option value="supplier_vat_file_types">supplier_vat_file_types </option>
                            <option value="supplying_plant">supplying_plant </option>
                            <option value="talend_webservices">talend_webservices </option>
                            <option value="users">users </option>
                            <option value="vaccine_bom">vaccine_bom </option>
                            <option value="vendor_masters">vendor_masters </option>
                            <option value="vendor_master_logs">vendor_master_logs </option>
                            <option value="vendor_types">vendor_types </option>
                            <option value="webservices">webservices </option>

                        </select> 

                        <br>
                        
                        <button type="submit" class="btn btn-success">Export Data</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
