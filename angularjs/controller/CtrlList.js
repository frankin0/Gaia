angular.module('pecuswap')
.controller('CtrlList', ['$scope', '$http', 'title_site', '$routeParams', 'user', function($scope, $http, title_site, $routeParams, user){

    $scope.title_site = title_site;
    $scope.type = $routeParams.type;
    $scope.cat_beni = [];
    $scope.cat_servizi = [];
    $scope.item_list = [];
    $scope.cod_cat_merc = '';
    $scope.cat_tag = '';

    $scope.userid = user.getUserLoggedIn();
    $scope.logged = user.isUserLoggedIn();

    $scope.page_ = 0;

    var url = "http://ns325217.ip-91-121-6.eu:8081/pecuswap_test/";
    //var url = "assets/";

    $scope.read_categories = function(type){
        var cat_beni = {c2c:'PRI-B',b2c:'BUS-B',b2b:'BUS-B'};
        var cat_serv = {c2c:'PRI-S',b2c:'BUS-S',b2b:'BUS-S'};
        
        var cat_beni_sel =  cat_beni[type]; //da sostituire in base all'utente loggato
        var cat_serv_sel =  cat_serv[type];

        /**
        * Carico gli elementi dal json
        */
    
        /* Cat tag Beni */
        $scope.cat_tag = cat_beni_sel;

        $http.get(url + "rest/categories?start=0&count=20", {headers: {"accept": "application/json", "content-type": "application/x-www-form-urlencoded"}})
            .then(function(response){
            
            for(var i =0; i < response.data.results.length; i++){
                if(response.data.results[i].radice == cat_beni_sel){
                    $scope.cat_beni = response.data.results[i].righiCategorie;
                }
            }
            
        })
        .catch(function(error){
            console.error("Error: ", error);
        });

        /* Cat tag Servizi */
        $scope.cat_serv = cat_serv_sel;

        $http.get(url + "rest/categories?start=0&count=20", {headers: {"accept": "application/json", "content-type": "application/x-www-form-urlencoded"}})
            .then(function(response){
            
            for(var i =0; i < response.data.results.length; i++){ 
                if(response.data.results[i].radice == cat_serv_sel){
                    $scope.cat_servizi = response.data.results[i].righiCategorie;
                }
            }
            
        })
        .catch(function(error){
            console.error("Error: ", error);
        });
        
        $scope.load();
        
    }

    $scope.load = function(){
        $scope.rec_number = 0;
        $scope.pag_number = 0;
        $scope.load_page(0);
    };

    $scope.load_page = function(pagination_n){ //console.log($scope.cat_serv);
        var arr = [];
        $http.get(url + 'rest/categories/'+$scope.cat_tag+'/posts?start=0&count=100&sort=data_pubblicazione:DESC', {headers: {"accept": "application/json", "content-type": "application/x-www-form-urlencoded"}})
            .then(function(response){ //console.log(response.data);
                if($scope.cod_cat_merc != ""){
                    for(var i = 0; i < response.data.results.length; i++){ 
                        
                        if(response.data.results[i].cod_cat_merc == $scope.cod_cat_merc){
                            arr.push(response.data.results[i]);
                        }
                    }
                    
                    $scope.item_list= arr;
                    $scope.page_ = pagination_n;
                }else{
                    $scope.item_list= response.data.results;
                    $scope.page_ = pagination_n;
                }
            }).catch(function(error){

                console.error("Error: ", error);

            });

            
    };

    

    $scope.selezionaCategoria = function(item_sel){ 
        if ("undefined" === typeof item_sel || item_sel == '') {
            $scope.cod_cat_merc = '';
            for (var j = 0; j < $scope.cat_beni.length; j++){
                item = $scope.cat_beni[j];
                if (item.livello == 2){
                    item.visibile = false;
                }
            }	
            for (var j = 0; j < $scope.cat_servizi.length; j++){
                item = $scope.cat_servizi[j];
                if (item.livello == 2){
                    item.visibile = false;
                }
            }							
        
        } else { 
            $scope.cod_cat_merc = item_sel.cod_cat_merc;
            $scope.cat_descrizione = item_sel.descrizione;
            
            if (item_sel.livello == 1){
                for (var j = 0; j < $scope.cat_beni.length; j++){
                item = $scope.cat_beni[j];
                if (item.livello == 2){
                    if (item.cod_cat_merc.substring(0, item_sel.cod_cat_merc.length) == item_sel.cod_cat_merc){
                    item.visibile = !item.visibile;
                    } else {
                    item.visibile = false;
                    } 
                }
                }
                for (var j = 0; j < $scope.cat_servizi.length; j++){
                item = $scope.cat_servizi[j];
                if (item.livello == 2){
                    if (item.cod_cat_merc.substring(0, item_sel.cod_cat_merc.length) == item_sel.cod_cat_merc){
                    item.visibile = !item.visibile;
                    } else {
                    item.visibile = false;
                    } 
                }
                }
            }			
        }	

        $scope.load(0);
    };

    
    if($routeParams.type == "mercato"){
        $scope.read_categories('b2c');
    }else if($routeParams.type == "piazzetta"){
        $scope.read_categories('c2c');
    }else if($routeParams.type == "fiera"){
        $scope.read_categories('b2b');
    }else{
        $scope.read_categories('b2c');
    }

    $(document).ready(function(){
        $('body').removeAttr('class');
        
        $('body').bootstrapMaterialDesign(); 

    });


}]).filter('range', function() {
    return function(input, total) {
        total = parseInt(total);
        for (var i=0; i<total; i++)
            input.push(i);
        return input;
    };
});