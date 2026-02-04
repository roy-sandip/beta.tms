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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('administrator_agent_id')->index(); //who manages the account: TMS Express / Agent
            $table->string('account_code')->unique()->index(); //AG01/P01
            $table->integer('agent_id')->nullable()->index();
            $table->string('account_type')->index(); //Principal:P, Agent: AG
            $table->boolean('is_active')->default(true);
            $table->decimal('opening_balance', 10, 2)->nullable();
            $table->timestamp('opening_date')->useCurrent();
            $table->timestamp('closing_date')->nullable();
            $table->string('remark')->nullable();
            $table->string('currency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
