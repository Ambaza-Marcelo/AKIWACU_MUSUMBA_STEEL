<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsEbpStockoutDetail extends Model
{
    //
    protected $fillable = [
        'date',
        'quantity',
        'unit',
        'price',
        'stockout_no',
        'stockout_signature',
        'requisition_no',
        'description',
        'rejected_motif',
        'total_value',
        'created_by',
        'updated_by',
        'validated_by',
        'confirmed_by',
        'approuved_by',
        'rejected_by',
        'reseted_by',
        'status',
        'asker',
        'destination',
        'store_type',
        'article_id',
        'item_movement_type'
    ];

    public function article(){
        return $this->belongsTo('App\Models\MsEbpArticle');
    }
}
