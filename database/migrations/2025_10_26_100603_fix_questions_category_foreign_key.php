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
        //
        Schema::table('questions', function (Blueprint $table) {
            // Drop the old foreign key
            $table->dropForeign(['category_id']);
            
            // Add the new foreign key pointing to 'categories' table
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')
                ->on('question_categories')
                ->onDelete('cascade');
        });
    }
};
