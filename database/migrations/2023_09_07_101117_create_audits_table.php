<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up() {
    $connection = config('audit.drivers.database.connection', config('database.default'));
    $table = config('audit.drivers.database.table', 'audits');

    Schema::connection($connection)->create($table, function (Blueprint $table) {

      $morphPrefix = config('audit.user.morph_prefix', 'user');
      $table->string('user_type')->nullable();
      $table->uuid('user_id')->nullable();
      $table->index([
        'user_type',
        'user_id',
      ]);
      $table->bigIncrements('id');
      //$table->string($morphPrefix . '_type')->nullable();
      //$table->unsignedBigInteger($morphPrefix . '_id')->nullable();
      $table->string('event');
      $table->string('auditable_type');
      $table->uuid('auditable_id');
      $table->index([
        'auditable_type',
        'auditable_id',
      ]);
      $table->json('old_values')->nullable();
      $table->json('new_values')->nullable();

      $table->ipAddress('ip_address')->nullable();
      $table->text('url')->nullable();
      $table->text('user_agent')->nullable();
      $table->text('tags')->nullable();
      $table->timestamps();

      $table->index([$morphPrefix . '_id', $morphPrefix . '_type']);
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down() {
    $connection = config('audit.drivers.database.connection', config('database.default'));
    $table = config('audit.drivers.database.table', 'audits');

    Schema::connection($connection)->drop($table);
  }
}