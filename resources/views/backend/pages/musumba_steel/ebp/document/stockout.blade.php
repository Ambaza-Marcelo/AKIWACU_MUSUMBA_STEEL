<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        tr,th,td{
             border: 1px solid black;
             text-align: center;
             width: auto;
        }

    </style>

<body>
<div>
    <div>
        <div>
            <div>
                <div>
                   <img src="img/logo_musumba.jpg" width="700" height="85">
                </div><br>
                <div>
                    <div style="float: right; border-top-right-radius: 10px solid black;border-top-left-radius: 10px solid black;border-bottom-right-radius: 10px solid black;border-bottom-left-radius: 10px solid black; background-color: rgb(150,150,150);width: 242px;padding: 20px;">
                        <small>
                           &nbsp;&nbsp; <img src="data:image/png;base64, {!! base64_encode(QrCode::size(50)->generate('eSIGNATURE : '.$stockout_signature.' www.musumba_steel.bi')) !!} ">
                        </small><br>
                        <small>
                           &nbsp;&nbsp;Stockout Number: {{ $stockout_no }}
                        </small><br>
                        <small>
                           &nbsp;&nbsp;Type Mouvement : @if($data->item_movement_type == 'SN') Sortie Normale @elseif($data->item_movement_type == 'SP') Sortie Perte @elseif($data->item_movement_type == 'SV') Sortie Vol @elseif($data->item_movement_type == 'SD') Sortie Désuétude @elseif($data->item_movement_type == 'SC') Sortie Casse @elseif($data->item_movement_type == 'SAJ') Sortie Ajustement @elseif($data->item_movement_type == 'ST') Sortie Transfert @else Sortie Autre @endif
                        </small><br>
                        <small>
                           &nbsp;&nbsp;Demandeur: {{ $data->asker }}
                        </small><br>
                        <small>
                           &nbsp;&nbsp; Date : Le {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                        </small>
                    </div>
                    <br><br><br><br><br>
                    <br><br><br><br><br>
                    <div>
                        <h3 style="text-align: center;text-decoration: underline;">BON DE SORTIE DES ARTICLES</h3>
                    </div>
                    <div>
                        <table style="border: 1px solid black;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Article</th>
                                    <th>Code</th>
                                    <th>Quantité</th>
                                    <th>Unité</th>
                                    <th>Prix Unitaire</th>
                                    <th>Prix Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                               <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->article->name }}</td>
                                    <td>{{ $data->article->code }}</td>
                                    <td>{{ $data->quantity }}</td>
                                    <td>{{ $data->article->unit }}</td>
                                    <td>{{ number_format($data->purchase_price,0,',',' ' )}}</td>
                                    <td>{{ number_format($data->total_purchase_value,0,',',' ' )}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th style="background-color: rgb(150,150,150);" colspan="5"></th>
                                    <th>{{ number_format($totalValue,0,',',' ') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <br><br>
                <div>
                    &nbsp;&nbsp;{{ $description }}
                </div>
                    <br>
                    <div style="display: flex;">
                        <div style="float: left;">
                            &nbsp;&nbsp;Nom et signature
                            <div>
                                &nbsp;&nbsp;
                            </div>
                        </div>

                        <div style="float: center;margin-left: 65%;">
                            &nbsp;&nbsp;Nom et signature
                            <div>
                            &nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

