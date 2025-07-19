<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsEbpStockReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_ebp_stock_reports', function (Blueprint $table) {
            $table->id();
            $table->string('quantity_stock_initial')->nullable();
            $table->string('value_stock_initial')->nullable();
            $table->string('quantity_stockin')->nullable();
            $table->string('value_stockin')->nullable();
            $table->string('stock_total')->nullable();
            $table->string('quantity_stockout')->nullable();
            $table->string('value_stockout')->nullable();
            $table->string('quantity_stock_final')->nullable();
            $table->string('value_stock_final')->nullable();
            $table->string('cump')->nullable();
            $table->string('date')->nullable(true);
            $table->string('created_by')->nullable(true);
            $table->string('updated_by')->nullable(true);
            $table->string('validated_by')->nullable(true);
            $table->string('confirmed_by')->nullable(true);
            $table->string('approuved_by')->nullable(true);
            $table->string('rejected_by')->nullable(true);
            $table->text('description')->nullable(true);
            $table->string('type_transaction')->nullable(true);
            $table->string('document_no')->nullable(true);
            $table->bigInteger('article_id')->unsigned();
            $table->foreign('article_id')
                    ->references('id')
                    ->on('ms_ebp_articles')
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
        Schema::dropIfExists('ms_ebp_stock_reports');
    }
}
