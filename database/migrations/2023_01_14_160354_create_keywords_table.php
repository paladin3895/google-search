<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keywords', function (Blueprint $table) {
            $table->id();
            $table->string('key')->index();
            $table->string('file_name')->nullable();
            $table->string('state')->nullable()->index();

            $table->unsignedInteger('adwords')->nullable();
            $table->unsignedInteger('links')->nullable();
            $table->string('results')->nullable();

            $table->json('stats')->nullable();
            $table->longText('html')->nullable();
            $table->timestamps();

            $table->foreignId('user_id')
                  ->constrained('users', 'id')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keywords');
    }
};
