(function(){
    'use strict';

    angular.module('pecuswap').directive('header', function(){
        return{
            templateUrl: 'template/view/wrapper/header.html',
            controller: toolbarController,
            controllerAs: 'header'
        }
    });

    angular.module('pecuswap').directive('footer', function(){
        return{
            templateUrl: 'template/view/wrapper/footer.html',
            controller: footerController,
            controllerAs: 'footer'
        }
    });

    function toolbarController($scope, title_site, $routeParams, $http, $location, user, site_url){
        $scope.userid = user.getUserLoggedIn();
        $scope.logged = user.isUserLoggedIn();
        $scope.title_site = title_site;
        $scope.beforeSend = true;
        $scope.base64Img = "assets/img/guest-male.png";

        if($scope.logged != false){
            $http.get(site_url + 'rest/users/' + $scope.userid.id + '/profileimage')
            .then(function(response){ 
                $scope.beforeSend = false;
                $scope.base64Img = "data:image/png;base64,"+response.data.base64Img;
            }).catch(function(error_det){
                $scope.beforeSend = false;
                $scope.base64Img = "assets/img/guest-male.png";
            });    
        }
        
    }

    function footerController($scope, title_site, user, site_url){
        $scope.userid = user.getUserLoggedIn();
        $scope.logged = user.isUserLoggedIn();
        $scope.title_site = title_site;
    }
})();