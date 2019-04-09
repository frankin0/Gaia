angular.module('pecuswap')
.controller('CtrlHome',['$scope', 'title_site', '$window', 'user', function($scope, title_site, $window, user){
    $scope.user = user.getID;
    $scope.title_site = title_site;

    $scope.userid = user.getUserLoggedIn();
    $scope.logged = user.isUserLoggedIn();

    $(document).ready(function(){
        $('body').removeAttr('class');
        
        $('body').bootstrapMaterialDesign(); 

        var swiper = new Swiper('.slider-for', {
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            }
        });
    });
  
}]);