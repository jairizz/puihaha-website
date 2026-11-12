<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('membership_transactions')) {
            Schema::create('membership_transactions', function (Blueprint $table): void {
                $table->id();
                $table->string('transaction_no')->unique();
                $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
                $table->foreignId('membership_level_id')->constrained('membership_levels')->restrictOnDelete();
                $table->enum('transaction_type', ['application', 'renewal'])->default('application');
                $table->decimal('amount', 10, 2);
                $table->enum('status', ['pending', 'paid', 'approved', 'expired', 'cancelled'])->default('pending');
                $table->text('notes')->nullable();
                $table->timestamp('applied_at')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('transaction_id')->constrained('membership_transactions')->cascadeOnDelete();
                $table->string('payment_reference')->unique();
                $table->decimal('amount', 10, 2);
                $table->string('payment_method')->default('cash');
                $table->enum('status', ['paid', 'refunded', 'voided'])->default('paid');
                $table->timestamp('paid_at');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('membership_transactions');
    }
};
