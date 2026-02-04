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
        Schema::create('money_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_no')->unique();
            $table->integer('issuer_agent_id')->index(); 
            $table->integer('shipment_id')->index()->nullable();
            $table->string('payer_name')->nullable();
            $table->string('payer_address')->nullable();
            $table->string('payer_contact')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('description')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->string('received_by')->nullable();
            $table->integer('user_id');
            $table->timestamp('received_date')->useCurrent();
            $table->string('receipt_hash', 64)->unique(); //SHA256 hash of json_encode([receipt_no,issuer,amount,date], JSON_UNESCAPED_SLASHES)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('money_receipts');
    }
};
