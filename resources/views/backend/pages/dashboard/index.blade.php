
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
    </div>  

                    <div class="row">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <div class="card">
                                <div class="seo-fact sbg4">
                                    <a href="">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon">
                                                <img src="{{ asset('img/undraw_toy_car_-7-umw.svg') }}" width="60">
                                              
                                            </div>
                                            <h2>
                                            </h2>
                                        </div>
                                    </a>
                                </div>
                            </div><br>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="seo-fact sbg3">
                                    <a href="">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon">
                                                <img src="{{ asset('img/undraw_resume_folder_re_e0bi.svg') }}" width="100">
                                            </div>
                                            <h2>
                                                DOSSIER DES RAPPORTS
                                            </h2>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                </div>       
  <!-- ambaza marcellin -pink -->
</div>
@endsection