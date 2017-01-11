/**
 * Created by ramon on 1/11/17.
 */
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
