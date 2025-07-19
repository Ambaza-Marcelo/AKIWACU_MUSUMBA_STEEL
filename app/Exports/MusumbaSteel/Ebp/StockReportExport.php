<?php

namespace App\Exports\MusumbaSteel\Ebp;
use Carbon\Carbon;
use App\Models\MsEbpStockReport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockReportExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $d1 = request()->input('start_date');
        $d2 = request()->input('end_date');

        $startDate = \Carbon\Carbon::parse($d1)->format('Y-m-d');
        $endDate = \Carbon\Carbon::parse($d2)->format('Y-m-d');

        $start_date = $startDate.' 00:00:00';
        $end_date = $endDate.' 23:59:59';

        return MsEbpStockReport::select(
                        DB::raw('id,date,type_transaction,document_no,created_at,article_id,quantity_stock_initial,value_stock_initial,quantity_stockin,value_stockin,quantity_stockout,value_stockout,quantity_stock_final,value_stock_final,created_by,description'))->whereBetween('created_at',[$start_date,$end_date])->groupBy('id','date','type_transaction','document_no','created_at','article_id','quantity_stock_initial','value_stock_initial','quantity_stockin','value_stockin','quantity_stockout','value_stockout','quantity_stock_final','value_stock_final','description','created_by')->orderBy('id','asc')->get();
    }

    public function map($data) : array {

        return [
            $data->id,
            Carbon::parse($data->created_at)->format('d/m/Y'),
            $data->article->name,
            $data->article->code,
            $data->quantity_stock_initial,
            ($data->quantity_stock_initial * $data->cump),
            $data->quantity_stockin,
            $data->value_stockin,
            $data->quantity_stockout,
            ($data->quantity_stockout * $data->cump),
            ($data->quantity_stock_initial - $data->quantity_stockin) - $data->quantity_stockout,
            (($data->quantity_stock_initial - $data->quantity_stockin) * $data->cump),
            $data->type_transaction,
            $data->document_no,
            $data->created_by,
            $data->description,
        ];
 
 
    }

    public function headings() : array {
        return [
            '#',
            'Date',
            'Article',
            'Code',
            'Quantite Stock Initial',
            'Valeur Stock Initial',
            'Quantite Entree',
            'Valeur Entree',
            'Quantite Sortie',
            'Valeur Sortie',
            'Quantite Stock Final',
            'Valeur Stock Final',
            'Type de Mouvement',
            'Document No',
            'Auteur',
            'Description'
        ] ;
    }
}
