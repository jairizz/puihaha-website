<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('membership_categories')) {
            Schema::table('membership_categories', function (Blueprint $table): void {
                if (! Schema::hasColumn('membership_categories', 'name')) {
                    $table->string('name')->nullable();
                }

                if (! Schema::hasColumn('membership_categories', 'description')) {
                    $table->text('description')->nullable();
                }
            });
        }

        if (Schema::hasTable('membership_levels')) {
            Schema::table('membership_levels', function (Blueprint $table): void {
                if (! Schema::hasColumn('membership_levels', 'name')) {
                    $table->string('name')->nullable();
                }

                if (! Schema::hasColumn('membership_levels', 'fee')) {
                    $table->decimal('fee', 10, 2)->default(0);
                }

                if (! Schema::hasColumn('membership_levels', 'validity_period')) {
                    $table->unsignedInteger('validity_period')->default(12);
                }

                if (! Schema::hasColumn('membership_levels', 'benefits')) {
                    $table->text('benefits')->nullable();
                }
            });
        }

        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table): void {
                if (! Schema::hasColumn('members', 'membership_no')) {
                    $table->string('membership_no')->nullable()->unique();
                }

                if (! Schema::hasColumn('members', 'first_name')) {
                    $table->string('first_name')->nullable();
                }

                if (! Schema::hasColumn('members', 'last_name')) {
                    $table->string('last_name')->nullable();
                }

                if (! Schema::hasColumn('members', 'email')) {
                    $table->string('email')->nullable()->index();
                }

                if (! Schema::hasColumn('members', 'phone')) {
                    $table->string('phone')->nullable();
                }

                if (! Schema::hasColumn('members', 'address')) {
                    $table->text('address')->nullable();
                }

                if (! Schema::hasColumn('members', 'category_id')) {
                    $table->unsignedBigInteger('category_id')->nullable()->index();
                }

                if (! Schema::hasColumn('members', 'level_id')) {
                    $table->unsignedBigInteger('level_id')->nullable()->index();
                }

                if (! Schema::hasColumn('members', 'status')) {
                    $table->string('status')->default('active')->index();
                }
            });
        }
    }

    public function down(): void
    {
        // Existing project tables are intentionally preserved on rollback.
    }
};
