
@extends('backend.layouts.master')

@section('title')
@lang('Details sur facture') - @lang('messages.admin_panel')
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">@lang('Details sur facture')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><span>@lang('messages.list')</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->
<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Details sur le Facture No {{ $facture->invoice_number }}</h4>
                    @include('backend.layouts.partials.messages')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Date Facture</label>
                                <input type="text" value="{{ $facture->invoice_date}}" class="form-control" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label>Signature Electronique Facture</label>
                                <input type="text" value="{{ $facture->invoice_signature}}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="invoice_date">Date Facture</label>
                                <input type="datetime-local" name="invoice_date" class="form-control" value="{{ $facture->invoice_date }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="invoice_number">Facture No</label>
                                <input type="text" name="invoice_number" value="{{ $facture->invoice_number }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="invoice_type">Type Facture</label>
                                <div class="form-group">
                                    <label class="text">F. Normale
                                    <input type="checkbox" name="invoice_type" value="FN" @if($facture->invoice_type == 'FN') checked="checked" @endif class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">R. Caution
                                    <input type="checkbox" disabled name="invoice_type" value="RC" @if($facture->invoice_type == 'RC') checked="checked" @endif class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">Reduction HF
                                    <input type="checkbox" name="invoice_type" disabled value="RHF" @if($facture->invoice_type == 'RHF') checked="checked" @endif class="form-control">
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="tp_type">Type Contribuable</label>
                                <div class="form-group">
                                    <label class="text">Personne Physique
                                    <input type="checkbox" name="tp_type" value="1" @if($setting->tp_type == '1') checked="checked" @endif class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">Société
                                    <input type="checkbox" name="tp_type" value="2" @if($setting->tp_type == '2') checked="checked" @endif class="form-control">
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="vat_taxpayer">Assujetti à la TVA</label>
                                <div class="form-group">
                                    <label class="text">Non Assujetti
                                    <input type="checkbox" name="vat_taxpayer" value="0" @if($setting->vat_taxpayer == '0') checked="checked" @endif class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">Assujetti
                                    <input type="checkbox" name="vat_taxpayer" value="1" @if($setting->vat_taxpayer == '1') checked="checked" @endif class="form-control">
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if($setting)
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="tp_name">Nom et Prenom</label>
                                <input type="text" value="{{ $setting->name }}" name="tp_name" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label for="tp_TIN">NIF Contribuable</label>
                                <input type="text" value="{{ $setting->nif }}" name="tp_TIN" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label for="tp_trade_number">RC du Contribuable</label>
                                <input type="text" value="{{ $setting->rc }}" name="tp_trade_number" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="tp_postal_number">Boite Postal</label>
                                <input type="text" value="0000" name="tp_postal_number" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label for="tp_phone_number">Tel. du Contribuable</label>
                                <input type="text" value="{{ $setting->telephone1 }}" name="tp_phone_number" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label for="tp_address_province">Province</label>
                                <input type="text" value="BUJUMBURA" name="tp_address_province" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="tp_address_commune">Commune</label>
                                <input type="text" value="{{ $setting->commune }}" name="tp_address_commune" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label for="tp_address_quartier">Quartier</label>
                                <input type="text" value="{{ $setting->quartier }}" name="tp_address_quartier" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label for="tp_address_avenue">Avenue</label>
                                <input type="text" value="{{ $setting->rue }}" name="tp_address_avenue" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="tp_address_rue">Rue</label>
                                <input type="text" value="{{ $setting->rue }}" name="tp_address_rue" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label for="tp_address_number">Numero</label>
                                <input type="text" value="0" name="tp_address_number" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label for="ct_taxpayer">Assujetti à la taxe de conso.</label>
                                <div class="form-group">
                                    <label class="text">Non Assujetti
                                    <input type="checkbox" name="ct_taxpayer" value="0" @if($setting->ct_taxpayer == '0') checked="checked" @endif  class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">Assujetti
                                    <input type="checkbox" name="ct_taxpayer" value="1" @if($setting->ct_taxpayer == '1') checked="checked" @endif class="form-control">
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="tl_taxpayer">Assujetti au PFL</label>
                                <div class="form-group">
                                    <label class="text">Non Assujetti
                                    <input type="checkbox" name="tl_taxpayer" value="0" @if($setting->tl_taxpayer == '0') checked="checked" @endif class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">Assujetti
                                    <input type="checkbox" name="tl_taxpayer" value="1" @if($setting->tl_taxpayer == '1') checked="checked" @endif class="form-control">
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="tp_fiscal_center">Centre Fiscale</label>
                                <div class="form-group">
                                    <label class="text">DGC
                                    <input type="checkbox" name="tp_fiscal_center" value="DGC" @if($setting->tp_fiscal_center == 'DGC') checked="checked" @endif class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">DMC
                                    <input type="checkbox" name="tp_fiscal_center" value="DMC" @if($setting->tp_fiscal_center == 'DMC') checked="checked" @endif class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">DPMC
                                    <input type="checkbox" name="tp_fiscal_center" value="DPMC" @if($setting->tp_fiscal_center == 'DPMC') checked="checked" @endif class="form-control">
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="tp_activity_sector">Secteur d'activité</label>
                                <input type="text" name="tp_activity_sector" class="form-control" value="{{ $setting->tp_activity_sector }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="tp_legal_form">Forme Juridique</label>
                                <input type="text" name="tp_legal_form" value="{{ $setting->tp_legal_form }}" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label for="payment_type">Type de Paiement</label>
                                <div class="form-group">
                                    <label class="text">Espece
                                    <input type="checkbox" name="payment_type" value="1" @if($facture->payment_type == '1') checked="checked" @endif class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">Banque
                                    <input type="checkbox" name="payment_type" value="2" @if($facture->payment_type == '2') checked="checked" @endif class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">Credit
                                    <input type="checkbox" name="payment_type" value="3" @if($facture->payment_type == '3') checked="checked" @endif class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">Autres
                                    <input type="checkbox" name="payment_type" value="4" @if($facture->payment_type == '4') checked="checked" @endif class="form-control">
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="invoice_currency">Type de Monaie</label>
                                <div class="form-group">
                                    <label class="text">BIF
                                    <input type="checkbox" name="invoice_currency" value="BIF" @if($facture->invoice_currency == 'BIF') checked="checked" @endif class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">USD
                                    <input type="checkbox" name="invoice_currency" value="USD" @if($facture->invoice_currency == 'USD') checked="checked" @endif class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">EUR
                                    <input type="checkbox" name="invoice_currency" value="EUR" @if($facture->invoice_currency == 'EUR') checked="checked" @endif class="form-control">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="customer_name">Nom du client</label>
                                <input type="text" value="@if($facture->client_id) {{ $facture->client->customer_name }} @else {{ $facture->customer_name}} @endif" class="form-control" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label for="customer_TIN">NIF du client</label>
                                <input type="text" value="@if($facture->client_id) {{ $facture->client->customer_TIN }} @else {{ $facture->customer_TIN}} @endif" class="form-control" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label for="customer_address">Adresse du client</label>
                                <input type="text" value="@if($facture->client_id) {{ $facture->client->customer_address }} @else {{ $facture->customer_address}} @endif" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="vat_customer_payer">client est assujetti TVA?</label>
                                <div class="form-group">
                                    <label class="text">Non Assujetti
                                    <input type="checkbox" name="vat_customer_payer" value="0" @if($facture->client->vat_customer_payer == '0') checked="checked" @endif class="form-control">
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="text">Assujetti
                                    <input type="checkbox" name="vat_customer_payer" value="1" @if($facture->client->vat_customer_payer == '1') checked="checked" @endif class="form-control">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <br>
                         <table class="table table-bordered" id="dynamicTable">  
                            <tr>
                                <th>Article</th>
                                <th>Quantite</th>
                                <th>Prix Unitaire</th>
                                <th>PVU HTVA</th>
                                <th>TVA</th>
                                <th>TTC</th>
                            </tr>
                            @foreach($factureDetails as $factureDetail)
                            <tr>  
                                <td><input type="text" value="{{ $factureDetail->article->name }}" class="form-control" readonly></td>  
                                <td><input type="text" value="{{ $factureDetail->item_quantity }}" class="form-control" readonly /></td>  
                                <td><input type="text" value="{{ $factureDetail->item_price }}" class="form-control" readonly /></td> 
                                <td><input type="text" value="{{ $factureDetail->item_price_nvat }}" class="form-control" readonly /></td> 
                                <td><input type="text" value="{{ $factureDetail->vat }}" class="form-control" readonly /></td>
                                <td><input type="text" value="{{ $factureDetail->item_total_amount }}" class="form-control" readonly /></td>
                            </tr> 
                            @endforeach
                        </table> 
                        <div class="col-md-2 pull-right">
                            <input type="text" class="form-control" value="{{ number_format($total_amount,0,',',' ')}}" readonly>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection
