angular.module('pecuswap')
.controller('CtrlContact',['$scope', 'title_site', function($scope, title_site){

    $(document).ready(function(){
        $('body').removeAttr('class');
        $('body').addClass('elab_box contact');
        
        $('body').bootstrapMaterialDesign(); 

        
        $('#map__').ready(function () {
            setTimeout(function(){
                $('.load_map').fadeOut();
            }, 900);
        });
    });

}]);