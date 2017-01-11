@extends('ait.layout')
@section('inner_content')
    <div class="row" id="thumbnail-wrapper" scroll>
        <div class="col col-md-2 justify-content-center" ng-repeat="thumbnail in thumbnails" style="overflow-x: hidden; text-align: center; height: 180px; overflow-y: hidden">
            <img style="height: 180px;" class="responsive-img mx-auto justify-content-center" s ng-src="<%thumbnail.url_q%>" imageonload>
            <div class="mx-auto loader"></div>
        </div>
    </div>
@stop