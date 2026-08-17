<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->index('published');
            $table->index('category');
            $table->index(['published', 'date', 'sort_order']);
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->index('published');
            $table->index('sort_order');
            $table->index(['published', 'sort_order']);
            $table->index('category');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->index('sort_order');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->index('is_read');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex(['published']);
            $table->dropIndex(['category']);
            $table->dropIndex(['published', 'date', 'sort_order']);
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropIndex(['published']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['published', 'sort_order']);
            $table->dropIndex(['category']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['sort_order']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['is_read']);
            $table->dropIndex(['created_at']);
        });
    }
};
