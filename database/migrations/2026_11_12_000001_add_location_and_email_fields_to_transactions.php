<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('membership_transactions')) {
            return;
        }

        Schema::table('membership_transactions', function (Blueprint $table): void {
            if (! Schema::hasColumn('membership_transactions', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable();
            }

            if (! Schema::hasColumn('membership_transactions', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable();
            }

            if (! Schema::hasColumn('membership_transactions', 'verification_sent_at')) {
                $table->timestamp('verification_sent_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('membership_transactions')) {
            return;
        }

        Schema::table('membership_transactions', function (Blueprint $table): void {
            $columns = [];

            foreach (['latitude', 'longitude', 'verification_sent_at'] as $column) {
                if (Schema::hasColumn('membership_transactions', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
