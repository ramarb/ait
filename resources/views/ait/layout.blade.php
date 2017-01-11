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

    <div class="row" id="thumbnail-wrapper" scroll>
        <div class="col col-md-2 justify-content-center" ng-repeat="thumbnail in thumbnails" style="overflow-x: hidden; text-align: center; height: 180px; overflow-y: hidden">
            <img style="height: 180px;" class="responsive-img mx-auto justify-content-center" s ng-src="<%thumbnail.url_q%>" imageonload>
            <div class="mx-auto loader"></div>
        </div>
    </div>


    <div style="margin-top: 10px;" class="mx-auto loader" id="main-preloader"></div>

    @yield('inner_content')

</div>

<script>
    var URL = '{{url('')}}';
    var token = '{{csrf_token()}}';
    var page_nth = 0;
    var ajax_in_progress = false;
    var pages = 0;

    //Replace interpolate provider due to blade template conflict
    var app = angular.module('AitApp',[],function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });

    app.controller('AitCtrl',function($scope, $http, $location, $timeout){

        $scope.thumbnails = [];
        $scope.tag_name = 'inspection';

        $scope.get_photos = function(){

            ajax_in_progress = true;
            page_nth++;
            angular.element(document.querySelector("#main-preloader")).removeClass('hide-me');

            var ajax_url = URL + '/ait/photos';
            $http.post(ajax_url,{'_token':token,'page_nth':page_nth,'tag_name':$scope.tag_name},[]).then(function(response){

                //store the number of pages one time
                if(pages === 0){
                    pages = response.data.photos.pages;
                }

                angular.forEach(response.data.photos.photo, function(value, key){
                    $scope.thumbnails.push(value);
                });

                angular.element(document.querySelector("#main-preloader")).addClass('hide-me');
                ajax_in_progress = false;
            });
        };

        $scope.get_photos();

        $scope.search_now = function(){
            $scope.thumbnails = [];
            page_nth = 0;
            pages = 0;
            $scope.get_photos();

        };

    });

    //Show preloader when image not yet loaded
    app.directive('imageonload', function() {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                element.addClass('hide-me');
                element.bind('load', function() {
                    element.parent().children().remove("div.loader");
                    element.removeClass('hide-me');
                });
            }
        };
    });

    app.directive("scroll", function ($window) {
        return function(scope, element, attrs) {
            angular.element($window).bind("scroll", function() {
                console.log(this.scrollHeight);
                var is_near_to_bottom = (($(window).scrollTop() + $(window).height()) > $(document).height() - 100);

                if(is_near_to_bottom && ajax_in_progress === false && page_nth <= pages){
                    scope.get_photos();
                }
                scope.$apply();
            });
        };
    });


</script>

</body>
</html>