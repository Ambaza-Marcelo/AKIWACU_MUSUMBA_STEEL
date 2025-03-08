
@extends('backend.layouts.master')

@section('title')
@lang('messages.dashboard') - @lang('messages.admin_panel')
@endsection


@section('admin-content')
<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">@lang('messages.dashboard')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{url('/404/muradutunge/ivyomwasavye-ntibishoboye-kuboneka')}}">@lang('messages.home')</a></li>
                    <li><span>@lang('messages.dashboard')</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

@if (Auth::guard('admin')->user()->can('musumba_steel_fuel_pump.view'))
<div class="main-content-inner">
  <div class="row">
    <div class="col-md-2" id="side-navbar">
    </div>

    <div class="col-lg-12"> 
        <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <canvas id="canvas" height="280" width="500"></canvas>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    </div>
    </div><br>
  <!-- ambaza marcellin -pink -->
</div>
@endif
@if (Auth::guard('admin')->user()->can('dashboard.view'))
<script type="text/javascript">
    var year = <?php echo $year; ?>;
    var gasoil_stockout = <?php echo $gasoil_stockout; ?>;
    var essence_stockout = <?php echo $essence_stockout; ?>;

    var barChartData = {
        labels: year,
        datasets: [
        {
            label: 'GASOIL',
            backgroundColor: "#077D92",
            data: gasoil_stockout
        },
        {
            label: 'ESSENCE',
            backgroundColor: "pink",
            data: essence_stockout
        }

        ]
    };

    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,  
                    text: 'STATISTIQUE DES SORTIES DU CARBURANT PAR AN'
                }
            }
        });
    };
</script>
@endif
@endsection