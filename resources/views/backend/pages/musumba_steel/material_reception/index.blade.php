
@extends('backend.layouts.master')

@section('title')
@lang('reception') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('messages.reception')</h4>
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
                    <h4 class="header-title float-left">material reception List</h4>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">@lang('messages.date')</th>
                                    <th width="10%">Reception No</th>
                                    <th width="10%">Order/Purchase No</th>
                                    <th width="5%">@lang('messages.status')</th>
                                    <th width="10%">Invoice No</th>
                                    <th width="10%">Invoice Currency</th>
                                    <th width="10%">Handingover</th>
                                    <th width="10%">Receptionist</th>
                                    <th width="10%">Stock Destination</th>
                                    <th width="10%">Supplier</th>
                                    <th width="20%">@lang('messages.description')</th>
                                    <th width="10%">@lang('messages.created_by')</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($receptions as $reception)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $reception->date }}</td>
                                    <td><a href="{{ route('admin.ms-material-receptions.show',$reception->reception_no)}}">{{ $reception->reception_no }}</a></td>
                                    <td><a href="@if($reception->order_no){{ route('admin.sotb-material-supplier-orders.show',$reception->order_no)}} @else {{ route('admin.ms-material-requisitions.show',$reception->purchase_no)}} @endif">@if($reception->order_no){{ $reception->order_no }} @else {{ $reception->purchase_no }} @endif</a></td>
                                    <td>@if($reception->status == 1)<img src="{{ asset('img/warning3.gif')}}" width="35">@elseif($reception->status == 1)<span class="badge badge-info">Encours</span> @elseif($reception->status == 2)<span class="badge badge-info">Validé</span> @elseif($reception->status == 3)<span class="badge badge-info">Confirmé</span> @elseif($reception->status == 4)<span class="badge badge-info">Approuvé</span> @elseif($reception->status == -1)<span class="badge badge-danger">Rejeté</span>@endif</td>
                                    <td>{{ $reception->invoice_no }}</td>
                                    <td>{{ $reception->invoice_currency }}</td>
                                    <td>{{ $reception->handingover }}</td>
                                    <td>{{ $reception->receptionist }}</td>
                                    <td>@if($reception->destination_store_id) {{ $reception->destination_store_id }} @endif</td>
                                    <td>{{ $reception->supplier_id }}</td>
                                    <td>{{ $reception->description }}</td>
                                    <td>{{ $reception->created_by }}</td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('musumba_steel_material_reception.validate'))
                                        @if($reception->status == 1)
                                            <a class="btn btn-primary text-white" href="{{ route('admin.ms-material-receptions.validate', $reception->reception_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('validate-form-{{ $reception->reception_no }}').submit();this.style.visibility='hidden';" ondblclick="this.style.visibility='hidden';">
                                                Valider
                                            </a>

                                            <form id="validate-form-{{ $reception->reception_no }}" action="{{ route('admin.ms-material-receptions.validate', $reception->reception_no) }}" method="POST" style="display: none;">
                                                @method('PUT')
                                                @csrf
                                            </form>
                                        @endif
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('musumba_steel_material_reception.confirm'))
                                        @if($reception->status == 2)
                                            <a class="btn btn-primary text-white" href="{{ route('admin.ms-material-receptions.confirm', $reception->reception_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('confirm-form-{{ $reception->reception_no }}').submit();">
                                                Confirmer
                                            </a>

                                            <form id="confirm-form-{{ $reception->reception_no }}" action="{{ route('admin.ms-material-receptions.confirm', $reception->reception_no) }}" method="POST" style="display: none;">
                                                @method('PUT')
                                                @csrf
                                            </form>
                                        @endif
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('musumba_steel_material_reception.approuve'))
                                        @if($reception->status == 3)
                                            <a class="btn btn-primary text-white" href="{{ route('admin.ms-material-receptions.approuve', $reception->reception_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('approuve-form-{{ $reception->reception_no }}').submit();" onclick="this.style.visibility='hidden';" ondblclick="this.style.visibility='hidden';">
                                                Approuver
                                            </a>

                                            <form id="approuve-form-{{ $reception->reception_no }}" action="{{ route('admin.ms-material-receptions.approuve', $reception->reception_no) }}" method="POST" style="display: none;">
                                                @method('PUT')
                                                @csrf
                                            </form>
                                        @endif
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('musumba_steel_material_reception.reject'))
                                            @if($reception->status == 1 || $reception->status == 2 || $reception->status == 3)
                                            <a class="btn btn-primary text-white" href="{{ route('admin.ms-material-receptions.reject', $reception->reception_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('reject-form-{{ $reception->reception_no }}').submit();">
                                                Rejeter
                                            </a>
                                            @endif
                                            <form id="reject-form-{{ $reception->reception_no }}" action="{{ route('admin.ms-material-receptions.reject', $reception->reception_no) }}" method="POST" style="display: none;">
                                                @method('PUT')
                                                @csrf
                                            </form>
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('musumba_steel_material_reception.reset'))
                                            @if($reception->status == -1 || $reception->status == 2 || $reception->status == 3 || $reception->status == 4)
                                            <a class="btn btn-primary text-white" href="{{ route('admin.ms-material-receptions.reset', $reception->reception_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('reset-form-{{ $reception->reception_no }}').submit();">
                                                Annuler
                                            </a>
                                            @endif
                                            <form id="reset-form-{{ $reception->reception_no }}" action="{{ route('admin.ms-material-receptions.reset', $reception->reception_no) }}" method="POST" style="display: none;">
                                                @method('PUT')
                                                @csrf
                                            </form>
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('musumba_steel_material_reception.edit'))
                                            <a class="btn btn-success text-white" href="{{ route('admin.ms-material-receptions.edit', $reception->reception_no) }}">@lang('messages.edit')</a>
                                        @endif

                                        @if (Auth::guard('admin')->user()->can('musumba_steel_material_reception.delete'))
                                            @if($reception->status == -1 || $reception->status == 1)
                                            <a class="btn btn-danger text-white" href="{{ route('admin.ms-material-receptions.destroy', $reception->reception_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $reception->reception_no }}').submit();">
                                                @lang('messages.delete')
                                            </a>

                                            <form id="delete-form-{{ $reception->reception_no }}" action="{{ route('admin.ms-material-receptions.destroy', $reception->reception_no) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                            @endif
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('musumba_steel_material_reception.create'))
                                        
                                        <a href="{{ route('admin.ms-material-receptions.fiche_reception',$reception->reception_no) }}"><img src="{{ asset('img/ISSh.gif') }}" width="60" title="Télécharger d'abord le document et puis imprimer"></a>
                                        
                                        @endif
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection


@section('scripts')
     <!-- Start datatable js -->
     <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
     
     <script>
         /*================================
        datatable active
        ==================================*/
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }

     </script>
@endsection