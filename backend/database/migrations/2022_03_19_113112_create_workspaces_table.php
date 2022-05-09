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
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->string('tableNumber');
            $table->integer('monitorsCount');
            $table->enum('mount',['Monitors on Mount','Seperated Monitors']);
            $table->enum('dockingStation',['Docking Station','PC']);
            $table->string('headPhones');
            $table->enum('tableType',['Non-Liftable','Liftable']);
            $table->timestamps();

            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workspaces');
    }
};
