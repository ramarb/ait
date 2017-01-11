<?php
/**
 * Created by PhpStorm.
 * User: ramon
 * Date: 1/10/17
 * Time: 9:54 AM
 */?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{url('/css/bootstrap-4.0.0-alpha.5-dist/css/bootstrap.min.css')}}" />
    <script type="text/javascript" src="{{url('/js/jquery-1.11.2.min.js')}}" ></script>
    <script type="text/javascript" src="{{url('/js/bootstrap-4.0.0-alpha.5-dist/js/bootstrap.min.js')}}" ></script>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        .col{
            /*border: solid red 1px;*/
        }
        .b{
            border: solid red 1px;
        }
        .boxing{
            height: 100px;
            width: 100px;
        }
        .hide-me{
            display: none;
        }
        .float{
            float:left;
        }
        .loader {
            border: 10px solid #dddddd;
            border-radius: 50%;
            border-top: 10px solid #3498db;
            width: 60px;
            height: 60px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .col{
            padding: 3px;
        }
    </style>
</head>

<body>

@foreach($ng_libs as $lib)
    <script type="text/javascript" src="{{url($lib)}}"></script>
@endforeach

<div ng-app="AitApp" ng-controller="AitCtrl" class="container">

    <nav class="navbar navbar-light bg-faded">
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="text" ng-model="tag_name" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" ng-click="search_now()">Search</button>
        </form>
    </nav>

    @yield('inner_content')

    <div style="margin-top: 10px;" class="mx-auto loader" id="main-preloader"></div>

</div>

<script>
    var URL = '{{url('')}}';
    var token = '{{csrf_token()}}';
</script>
<script type="text/javascript" src="{{url('js/flickr.js')}}"></script>


</body>
</html>