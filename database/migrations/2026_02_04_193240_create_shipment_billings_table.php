<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipment_billings', function (Blueprint $table) {
            $table->id();
            $table->integer('shipment_id')->index();
            $table->integer('administrator_agent_id')->index(); //who billed: TMS Express to agents or agent to its sub-agent
            $table->integer('invoice_id')->index()->nullable();
            $table->integer('account_id')->index()->nullable();
            $table->decimal('base_charge', 10, 2)->nullable();
            $table->decimal('other_charges', 10, 2)->nullable();
            $table->decimal('taxable_amount', 10, 2)->nullable();
            $table->decimal('tax_rate', 3, 2)->nullable();
            $table->decimal('total_tax_amount', 8, 2)->nullable();
            $table->decimal('total_bill', 8, 2)->nullable();
            $table->string('comment')->nullable();
            $table->string('status')->index(); //PENDING/DUE/PAID/INVOICED
            $table->string('currency')->default('BDT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_billings');
    }
};
