
@extends('backend.layouts.master')

@section('title')
@lang('messages.stockout_create') - @lang('messages.admin_panel')
@endsection

@section('styles')
<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
@endsection


@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">@lang('messages.stockout_create')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><a href="{{ route('admin.stockouts.index') }}">@lang('messages.list')</a></li>
                    <li><span>@lang('messages.stockout_create')</span></li>
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
                    <h4 class="header-title">Nouvelle Sortie</h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.stockouts.store') }}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-md-6" id="dynamicDiv">
                            <div class="form-group">
                             <label for="date">@lang('messages.date')</label>
                                <input type="date" class="form-control" id="date" name="date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="asker">Demandeur</label>
                                <input type="text" class="form-control" id="asker" name="asker" placeholder="Enter asker">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="destination">Destination</label>
                                <input type="text" class="form-control" id="destination" name="destination" placeholder="Enter destination">
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="item_movement_type">@lang('Type de Sortie')</label>
                                    <select class="form-control" name="item_movement_type" id="item_movement_type" required>
                                    <option disabled="disabled" selected="selected">Merci de choisir</option>
                                        <option value="SN">Sortie Normale</option>
                                        <option value="SP">Sortie Perte</option>
                                        <option value="SV">Sortie Vol</option>
                                        <option value="SD">Sortie Désuétude</option>
                                        <option value="SC">Sortie Casse</option>
                                        <option value="SAJ">Sortie Ajustement</option>
                                        <option value="ST">Sortie Transfert</option>
                                        <option value="SAU">Sortie Autre</option>
                                </select>
                                </div>
                            </div>
                    </div>
                         <table class="table table-bordered" id="dynamicTable">  
                            <tr>
                                <th>@lang('messages.item')</th>
                                <th>@lang('messages.quantity')</th>
                                <th>Action</th>
                            </tr>
                            <tr>  
                                <td> <select class="form-control" name="article_id[]" id="article_id">
                                <option disabled="disabled" selected="selected">merci de choisir</option>
                            @foreach ($articles as $article)
                                <option value="{{ $article->id }}" class="form-control">{{$article->name}}/{{ number_format($article->cump,0,',',' ') }}/{{ $article->unit }}</option>
                            @endforeach
                            </select></td>  
                                <td><input type="number" name="quantity[]" placeholder="Enter quantity" class="form-control" /></td>    
                                <td><button type="button" name="add" id="add" class="btn btn-success">@lang('messages.addmore')</button></td>  
                            </tr>  
                        </table> 
                        <div class="col-lg-12">
                            <label for="description"> @lang('messages.description')</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Entrer description">
                                SORTIE DES ARTICLES
                            </textarea>
                        </div>
                        <div style="margin-top: 15px;margin-left: 15px;">
                            <button type="submit" onclick="this.style.visibility='hidden';" ondblclick="this.style.visibility='hidden';" class="btn btn-primary">@lang('messages.save')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript">
    var i = 0;
       
    $("#add").click(function(){
   
        ++i;

         var markup = "<tr>"+
                      "<td>"+
                         "<select class='form-control' name='article_id[]'"+
                            "<option>merci de choisir</option>"+
                             "@foreach($articles as $article)"+
                                 "<option value='{{ $article->id }}'>{{$article->name}}/{{ number_format($article->cump,0,',',' ') }}/{{ $article->unit }}</option>"+
                             "@endforeach>"+
                          "</select>"+
                        "</td>"+
                        "<td>"+
                          "<input type='number' name='quantity[]' placeholder='Enter Quantity' class='form-control' />"+
                        "</td>"+
                        "<td>"+
                          "<button type='button' class='btn btn-danger remove-tr'>@lang('messages.delete')</button>"+
                        "</td>"+
                    "</tr>";
   
        $("#dynamicTable").append(markup);
    });
   
    $(document).on('click', '.remove-tr', function(){  
         $(this).parents('tr').remove();
    }); 

    function preventBack() {
        window.history.forward();
    }
    setTimeout("preventBack()", 0);
    window.onunload = function () {
        null
    };

</script>
@endsection
