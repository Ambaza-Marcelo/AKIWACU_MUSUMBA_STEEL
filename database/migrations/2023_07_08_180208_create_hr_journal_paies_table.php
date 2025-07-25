<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrJournalPaiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_journal_paies', function (Blueprint $table) {
            $table->id();
            $table->string('date_debut')->nullable(true);
            $table->string('date_fin')->nullable(true);
            $table->string('title')->nullable(true);
            $table->string('etat')->nullable(true);
            $table->string('code')->nullable(true);
            $table->string('cloture_par')->nullable(true);
            $table->string('created_by')->nullable(true);
            $table->bigInteger('company_id')->unsigned()->nullable(true);
            $table->foreign('company_id')
                    ->references('id')
                    ->on('hr_companies')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_journal_paies');
    }
}
