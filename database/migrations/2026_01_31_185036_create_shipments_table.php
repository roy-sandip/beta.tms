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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('awb')->unique()->nullable();
            $table->integer('shipper_address_id'); //FK
            $table->integer('receiver_address_id'); //FK
            $table->integer('customer_id')->nullable(); //FK
            $table->integer('origin_branch_id'); //FK 
            $table->integer('service_id')->nullable(); //FK


            $table->text('description_of_goods')->nullable();
            $table->string('operator')->nullable();
            $table->string('sender_reference')->nullable();
            
            $table->boolean('is_frazile')->default(false);
            $table->boolean('has_unusual_item')->default(false);
            $table->boolean('has_insurance')->default(false);

            $table->string('current_stage')->nullable(); //ENUM: (current location) AGENT_HUB/TMS_SYL/TMS_DAC/IN_TRANSIT/AT_DEST_CUSTOMS/AT_DEST_HUB etc. events table will store with details
        
            $table->dateTimeTz('received_at')->useCurrent();
            $table->dateTimeTz('est_delivery')->nullable();

            $table->timestamps();
            $table->index(['shipper_address_id', 'receiver_address_id', 'customer_id', 'agent_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
