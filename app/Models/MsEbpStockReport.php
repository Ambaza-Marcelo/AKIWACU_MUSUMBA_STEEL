<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsEbpStockReport extends Model
{
    //
    protected $fillable = [
        'quantity_stock_initial',
        'value_stock_initial',
        'quantity_stockin',
        'value_stockin',
        'stock_total',
        'quantity_stockout',
        'value_stockout',
        'quantity_stock_final',
        'value_stock_final',
        'cump',
        'date',
        'created_by',
        'updated_by',
        'validated_by',
        'confirmed_by',
        'approuved_by',
        'rejected_by',
        'description',
        'type_transaction',
        'document_no',
        'article_id',
    ];

    public function article(){
        return $this->belongsTo('App\Models\MsEbpArticle');
    }
}
