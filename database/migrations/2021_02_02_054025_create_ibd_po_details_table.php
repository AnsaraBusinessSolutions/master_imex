<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIbdPoDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ibd_po_details')) {
            Schema::create('ibd_po_details', function(Blueprint $table)
            {
                $table->integer('id', true);
                $table->bigInteger('nupco_po_no')->nullable();
                $table->integer('nupco_po_item')->nullable();
                $table->string('plant', 4)->nullable();
                $table->bigInteger('nupco_material')->nullable();
                $table->string('po_date', 10)->nullable();
                $table->string('nupco_material_description', 40)->nullable();
                $table->decimal('order_quantity', 10)->nullable();
                $table->decimal('open_qty', 9)->nullable();
                $table->string('order_unit', 3)->nullable();
                $table->string('price_unit', 6)->nullable();
                $table->decimal('net_order_price')->nullable();
                $table->decimal('net_order_value', 10)->nullable();
                $table->string('currency', 3)->nullable();
                $table->string('storage_location', 4)->nullable();
                $table->integer('vendor_no')->nullable();
                $table->string('vendor_name', 35)->nullable();
                $table->string('status', 8)->nullable();
                $table->string('valuation_type', 10)->nullable();
                $table->string('po_delivery_date', 10)->nullable();
                $table->string('moh_tender_no', 11)->nullable();
                $table->string('moh_generic_code', 15)->nullable();
                $table->string('delivery_address', 16)->nullable();
                $table->string('cust_no', 5)->nullable();
                $table->string('cust_name', 18)->nullable();
                $table->string('cust_cont_no', 15)->nullable();
                $table->string('moh_po_no', 12)->nullable();
                $table->string('moh_description', 50)->nullable();
                $table->string('country_of_origin', 100)->nullable();
                $table->string('concentration', 100)->nullable();
                $table->string('sfda', 100)->nullable();
                $table->string('pack_size', 100)->nullable();
                $table->string('volume', 100)->nullable();
                $table->string('so_ref', 100)->nullable();
                $table->string('manufacturer', 100)->nullable();
                $table->string('delivery_completed', 100)->nullable();
                $table->string('deletion_indicator', 100)->nullable();
                $table->string('item_status', 100)->nullable();
                $table->timestamp('last_update')->default(DB::raw('CURRENT_TIMESTAMP'));
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ibd_po_details');
    }
}
