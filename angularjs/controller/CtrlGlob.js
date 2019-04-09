angular.module('pecuswap')
.directive('ngDir', function(){
    return function($scope, $element, $attrs){
        $scope.doSomething($element);
    }
})
.run(function($rootScope, $templateCache) {
    $rootScope.$on('$viewContentLoaded', function() {
       $templateCache.removeAll();
    });
 })
.controller('CtrlGlobGettingStarted',['$scope', 'title_site', '$location', 'user', function($scope, title_site, $location, user){
    $scope.user = user.getID;
    $scope.title_site = title_site;

    $scope.userid = user.getUserLoggedIn();
    $scope.logged = user.isUserLoggedIn();

    $scope.start = function(){
        $location.path('/access/signin');
    }

    $(window).resize(function(){
        $('.swiper-container').css({
            "width": ($(window).width() >= 460 ? ($(window).width() - 100) : $(window).width())
        });
    });

    $(document).ready(function(){
        $('body').removeAttr('class');
        $('body').addClass('elab_box access-page');
        
        $('body').bootstrapMaterialDesign(); 

        $('.swiper-container').css({
            "width": ($(window).width() >= 460 ? ($(window).width() - 100) : $(window).width())
        });

        var swiper = new Swiper('.swiper-container', {
            spaceBetween: 30,
            effect: 'fade',
            speed: 1000,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            
            on: {
                init: function () {
                    $('.swiper-container').find('.swiper-slide.swiper-slide-active .slide-setAnim').fadeIn('fast').addClass('fadein');
                },
                slideChange : function(){
                    $('.swiper-container').find('.swiper-slide .slide-setAnim').fadeOut(0).removeClass('fadein');
                    $('.swiper-container').find('.swiper-slide.swiper-slide-next .slide-setAnim').fadeIn('fast').addClass('fadein');
                    $('.swiper-container').find('.swiper-slide.swiper-slide-prev .slide-setAnim').fadeIn('fast').addClass('fadein');
                    /*var thm = $('.swiper-container').find('.swiper-slide.swiper-slide-next').css('background-color');
                    var metaThemeColor = document.querySelector("meta[name=theme-color]");
                    metaThemeColor.setAttribute("content", thm);*/
                }
            },
        });

    });
  
}])
.controller('CtrlGlobFaq',['$scope', 'title_site', '$location', 'user', function($scope, title_site, $location, user){
    $scope.user = user.getID;
    $scope.title_site = title_site;

    $scope.userid = user.getUserLoggedIn();
    $scope.logged = user.isUserLoggedIn();


    $(document).ready(function(){
        $('body').removeAttr('class');
        $('body').addClass('elab_box contact');

        $('body').bootstrapMaterialDesign(); 

    });
  
}])
.controller('CtrlGlobPolicies',['$scope', 'title_site', '$location', 'user', function($scope, title_site, $location, user){
    $scope.user = user.getID;
    $scope.title_site = title_site;

    $scope.userid = user.getUserLoggedIn();
    $scope.logged = user.isUserLoggedIn();

    if($scope.logged == false){
        $location.path('/access/login');
    }

    $(document).ready(function(){
        $('body').removeAttr('class');
        $('body').addClass('elab_box contact');

        $('body').bootstrapMaterialDesign(); 

    });
  
}])
.controller('CtrlGlobPrivacy',['$scope', 'title_site', '$location', 'user', function($scope, title_site, $location, user){
    $scope.user = user.getID;
    $scope.title_site = title_site;

    $scope.userid = user.getUserLoggedIn();
    $scope.logged = user.isUserLoggedIn();

    if($scope.logged == false){
        $location.path('/access/login');
    }

    $(document).ready(function(){
        $('body').removeAttr('class');
        $('body').addClass('elab_box contact');
        
        $('body').bootstrapMaterialDesign(); 

    });
  
}]);