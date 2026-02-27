<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('manager_post', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('category_id'); // foreign key

            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('category_id')
                ->references('id')
                ->on('manager_category')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manager_post');
    }
};
