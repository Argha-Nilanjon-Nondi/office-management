<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects_history', function (Blueprint $table) {
            $table->uuid("history_id")->primary()->default(DB::raw('(UUID())'));
            $table->uuid("project_id");
            $table->uuid("team_id");
            $table->uuid("project_manager_id");
            $table->text("progress_info");
            $table->enum("project_status",["initiate","pending","completed","dropped"])->nullable();
            $table->json("extra")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_history');
    }
};
