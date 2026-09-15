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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();

            $table->string('quotation_number')->unique();
            $table->foreignId('customer_id')->constrained('customers');

            $table->date('quotation_date');
            $table->date('valid_until')->nullable();

            $table->string('subject')->nullable();
            $table->text('service_agreement')->nullable();

            $table->boolean('gst_applicable')->default(false);
            $table->decimal('gst_rate', 5, 2)->default(18.00);

            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('gst_amount', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);

            $table->string('status')->default('Draft');

            $table->text('notes')->nullable();
            $table->text('terms')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
