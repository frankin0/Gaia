angular.module('pecuswap')
.controller('CtrlItem', ['$scope', 'title_site', '$routeParams', 'site_url', '$http', 'user', function($scope, title_site, $routeParams, site_url, $http, user){

    $scope.title_site = title_site;
    $scope.site_url = site_url;
    $scope.id = $routeParams.id;

    $scope.user = user.getUserLoggedIn();
    $scope.logged = user.isUserLoggedIn();

    $scope.dataArr = [];
    $scope.userOwnerItem = [];
    $scope.galleryItem = [];
    $scope.similarItems = [];
    $scope.endItem = null;
    $scope.cons = null; 
    $scope.idPlatform = null;
    var cat_itm = {c2c:'La Piazzetta', b2c:'Il Mercato', b2b:'La Fiera'};
    var cat_url_itm = {c2c:'piazzetta', b2c:'mercato', b2b:'fiera'};


    //Estrapolate category item
    var categoryID = $scope.id.split('_')[0];
    var itemID = $scope.id.split('_')[1];
    $scope.CategoryId = categoryID;

    /**
     * ICN
     */
    $scope.print = function($event){
        $event.preventDefault($event);
        window.print();	
    }

    
    /**
     * Item Details
     */

    $http.get(site_url + 'rest/categories/'+categoryID+'/posts/' + itemID)
        .then(function(response){ 
            $scope.dataArr = response.data;

            if(response.data.mod_cosenga == "R"){
                $scope.cons = "Ritiro presso l'indirizzo del venditore";
            }else if(response.data.mod_cosenga == "C"){
                $scope.cons = "Spedizione al cliente";
            }else if(response.data.mod_cosenga == "S"){
                $scope.cons = "Ritiro presso indirizzo specificato";
            }else{
                $scope.cons = response.data.mod_cosenga;
            }

            $scope.idPlatform = cat_itm[response.data.id_piattaforma];
            $scope.lPlatform = cat_url_itm[response.data.id_piattaforma];

            $scope.endItem = new Date(response.data.data_scadenza).toDateString();
            $http.get(site_url + 'rest/users/' + $scope.dataArr.id_utente)
                .then(function(response){
                    $scope.userOwnerItem = response.data.nome_utente;
                }).catch(function(error_det){
                    console.log(error_det);
                });

        }).catch(function(error_det){
            console.log(error_det);
        });

        /**
         * Object Observed
         */
/*
        $http.get(site_url + 'rest/categories/'+categoryID+'/posts/'+itemID+'/observedusers')
            .then(function(response){
                if(response.data.code == "OK"){
                    console.log(response.data.message);
                }
            }).catch(function(error_det){
                console.error(error_det);
            });
*/
        $scope.osserved = function(){ console.log($scope.user.id);
            $http.put(site_url + 'rest/users/'+$scope.user.id+'/observedobjects/' + itemID)
                .then(function(response){
                    if(response.data.code == "OK"){
                        console.log(response.data.message);
                    }
                }).catch(function(error_det){
                    console.error(error_det);
                });
        }


        /**
         * Gallery Items
         */
    $http.get(site_url + 'rest/categories/'+categoryID+'/posts/'+itemID+'/images')
        .then(function(response){ 
            if(response.data.images.length == 0){
                $scope.galleryItem = {"images" : [{"image_large": "file/annunci/531_L.png"}]};
            }else{
                $scope.galleryItem = response.data;
            }
        }).catch(function(error_det){
            console.log(error_det);
        });

        /**
         * Similar Items
         */
    $http.get(site_url + 'rest/categories/'+categoryID+'/posts/'+itemID+'/similarposts')
        .then(function(response){
            if(response.statusText == "OK"){
                $scope.similarItems = response.data.results;
            }
        }).catch(function(error_det){
            if(error_det.data.errorCode != "GENERIC"){
                console.log(error_det);
            }
        });
        

    $(document).ready(function(){
        $('body').bootstrapMaterialDesign(); 
        $('.btn-tooltip').tooltip();
    });
}]);