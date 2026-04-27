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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->dateTime('invoice_date');
            $table->string('description')->nullable();
            $table->integer('tax_base');
           // $table->enum('tax_rate',['S6 - IVA 21%','S7 - IVA 10%','S0 - IVA 0%','P1 - IRPF 15% y 0% IVA','P5 - IRPF 15% y 21% IVA']);
            $table->foreignId('type_rate_id')->nullable()->constrained('type_rate')->onDelete('set null');
            $table->string('total');
            $table->enum('status',['Pendiente','Pagada', 'Anulada']);
            $table->text('nota')->nullable();
            $table->foreignId('client_id')->constrained('client');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
