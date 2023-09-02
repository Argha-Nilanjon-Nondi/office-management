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
        Schema::create('projects_assignment', function (Blueprint $table) {
            $table->uuid("assignment_id")->primary()->default(DB::raw('(UUID())'));
            $table->uuid("team_id");
            $table->uuid("project_id");
            $table->uuid("assigner_id"); // who gives the job
            $table->uuid("worker_id"); // who perform the job
            $table->string("assignment_name");
            $table->text("assignment_info");
            $table->enum("assignment_status",["initiate","pending","completed","not_completed","dropped"])->nullable();
            $table->json("extra")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_assignment');
    }
};
