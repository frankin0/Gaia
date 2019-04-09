angular.module('pecuswap')
.directive('compareTo', function() {
    return {
      require: "ngModel",
      scope: {
        otherModelValue: "=compareTo"
      },
      link: function(scope, element, attributes, ngModel) {

        ngModel.$validators.compareTo = function(modelValue) {
          return modelValue == scope.otherModelValue;
        };

        scope.$watch("otherModelValue", function() {
          ngModel.$validate();
        });
      }
    };			

})

.directive('reCaptcha', function(){
    var ddo = {
        restrict: 'AE',
        scope: {},
        require: 'ngModel',
        link: link,
    };
    return ddo;


    function link(scope, elm, attrs, ngModel) {
        var id;
        ngModel.$validators.captcha = function(modelValue, ViewValue) {
            return !!ViewValue;
        };

        function update(response) {
            ngModel.$setViewValue(response);
            ngModel.$render();
        }
        
        function expired() {
            grecaptcha.reset(id);
            ngModel.$setViewValue('');
            ngModel.$render();
            // scope.$apply();
        }

        function iscaptchaReady() {
            if (typeof grecaptcha !== "object") {
                return setTimeout(iscaptchaReady, 250);
            }
            id = grecaptcha.render(
                elm[0], {
                    "sitekey": "6LcTMUYUAAAAAMu1FOG_wvIPjCA1tNU6HH7wayHL",
                    callback: update,
                    "expired-callback": expired
                }
            );
        }
        iscaptchaReady();
    }
})
.controller('CtrlAccess', ['$scope', 'title_site', '$routeParams','$http', '$location','user','site_url', function($scope, title_site, $routeParams, $http, $location, user, site_url){

    $scope.title_site = title_site;
    $scope.userLog = {};
    $scope.userType = {};
    $scope.userType.chaptcha = false;

    /* reCHAPTCHA */
    

    /* TEST */
    $scope.userType.denominazione = "ciao";
    $scope.userType.comune_nascita = "bari";
    $scope.userType.codice_fiscale = "SPSFNC93R11A662V";
    $scope.userType.prefessione = "professione X";
    $scope.userType.pec = "pec@pec.it";
    $scope.userType.indirizzo = "via di casa n3";
    $scope.userType.comune = "bari";
    $scope.userType.cap = "70100";
    $scope.userType.telefono = "3270000000";
    $scope.userType.nome_utente = "frankin0";
    $scope.userType.email = "francescoe15@gmail.com";
    $scope.userType.passwd = "1234567890";
    $scope.userType.passwd_conferma = "1234567890";
    $scope.userType.descrizione_attivita = "Questa è una desc";

    $scope.data = {
        model: null,
        options: [
            {id: 'NULL', name: 'Scegli', url : null},
            {id: 'PRIV', name: 'Privati', url : 'template/view/registration/privated.html'},
            {id: 'AZIE', name: 'Società', url : 'template/view/registration/society.html'},
            {id: 'PROF', name: 'Autonomi', url : 'template/view/registration/autonomous.html'},
            {id: 'PUBA', name: 'Enti Locali', url : 'template/view/registration/society.html'},
            {id: 'NPCF', name: 'No Profit', url : 'template/view/registration/society.html'},
            {id: 'NPPI', name: 'No Profit con P.IVA', url : 'template/view/registration/society.html'}
        ],
        personal: {id: 'NULL', name: 'Scegli', url: null}
    }
    $scope.userType.sesso = 'U';

    $scope.selNazioni = { options: [{"nazione":"AF","descrizione":"Afghanistan"},{"nazione":"AL","descrizione":"Albania"},{"nazione":"DZ","descrizione":"Algeria"},{"nazione":"AD","descrizione":"Andorra"},{"nazione":"AO","descrizione":"Angola"},{"nazione":"AI","descrizione":"Anguilla"},{"nazione":"AQ","descrizione":"Antartide"},{"nazione":"AG","descrizione":"Antigua e Barbuda"},{"nazione":"AN","descrizione":"Antille Olandesi"},{"nazione":"SA","descrizione":"Arabia Saudita"},{"nazione":"AR","descrizione":"Argentina"},{"nazione":"AM","descrizione":"Armenia"},{"nazione":"AW","descrizione":"Aruba"},{"nazione":"AU","descrizione":"Australia"},{"nazione":"AT","descrizione":"Austria"},{"nazione":"AZ","descrizione":"Azerbaijan"},{"nazione":"BS","descrizione":"Bahamas"},{"nazione":"BH","descrizione":"Bahrain"},{"nazione":"BD","descrizione":"Bangladesh"},{"nazione":"BB","descrizione":"Barbados"},{"nazione":"BE","descrizione":"Belgio"},{"nazione":"BZ","descrizione":"Belize"},{"nazione":"BJ","descrizione":"Benin"},{"nazione":"BM","descrizione":"Bermuda"},{"nazione":"BT","descrizione":"Bhutan"},{"nazione":"BY","descrizione":"Bielorussia"},{"nazione":"BO","descrizione":"Bolivia"},{"nazione":"BA","descrizione":"Bosnia Erzegovina"},{"nazione":"BW","descrizione":"Botswana"},{"nazione":"BR","descrizione":"Brasile"},{"nazione":"BN","descrizione":"Brunei Darussalam"},{"nazione":"BG","descrizione":"Bulgaria"},{"nazione":"BF","descrizione":"Burkina Faso"},{"nazione":"BI","descrizione":"Burundi"},{"nazione":"KH","descrizione":"Cambogia"},{"nazione":"CM","descrizione":"Camerun"},{"nazione":"CA","descrizione":"Canada"},{"nazione":"CV","descrizione":"Capo Verde"},{"nazione":"TD","descrizione":"Ciad"},{"nazione":"CL","descrizione":"Cile"},{"nazione":"CN","descrizione":"Cina"},{"nazione":"CY","descrizione":"Cipro"},{"nazione":"VA","descrizione":"Città del Vaticano"},{"nazione":"CO","descrizione":"Colombia"},{"nazione":"KM","descrizione":"Comore"},{"nazione":"KP","descrizione":"Corea del Nord"},{"nazione":"KR","descrizione":"Corea del Sud"},{"nazione":"CI","descrizione":"Costa d'Avorio"},{"nazione":"CR","descrizione":"Costa Rica"},{"nazione":"HR","descrizione":"Croazia"},{"nazione":"CU","descrizione":"Cuba"},{"nazione":"DK","descrizione":"Danimarca"},{"nazione":"DM","descrizione":"Dominica"},{"nazione":"EC","descrizione":"Ecuador"},{"nazione":"EG","descrizione":"Egitto"},{"nazione":"IE","descrizione":"Eire"},{"nazione":"SV","descrizione":"El Salvador"},{"nazione":"AE","descrizione":"Emirati Arabi Uniti"},{"nazione":"ER","descrizione":"Eritrea"},{"nazione":"EE","descrizione":"Estonia"},{"nazione":"ET","descrizione":"Etiopia"},{"nazione":"RU","descrizione":"Federazione Russa"},{"nazione":"FJ","descrizione":"Fiji"},{"nazione":"PH","descrizione":"Filippine"},{"nazione":"FI","descrizione":"Finlandia"},{"nazione":"FR","descrizione":"Francia"},{"nazione":"GA","descrizione":"Gabon"},{"nazione":"GM","descrizione":"Gambia"},{"nazione":"GE","descrizione":"Georgia"},{"nazione":"DE","descrizione":"Germania"},{"nazione":"GH","descrizione":"Ghana"},{"nazione":"JM","descrizione":"Giamaica"},{"nazione":"JP","descrizione":"Giappone"},{"nazione":"GI","descrizione":"Gibilterra"},{"nazione":"DJ","descrizione":"Gibuti"},{"nazione":"JO","descrizione":"Giordania"},{"nazione":"GR","descrizione":"Grecia"},{"nazione":"GD","descrizione":"Grenada"},{"nazione":"GL","descrizione":"Groenlandia"},{"nazione":"GP","descrizione":"Guadalupa"},{"nazione":"GU","descrizione":"Guam"},{"nazione":"GT","descrizione":"Guatemala"},{"nazione":"GG","descrizione":"Guernsey"},{"nazione":"GN","descrizione":"Guinea"},{"nazione":"GW","descrizione":"Guinea-Bissau"},{"nazione":"GQ","descrizione":"Guinea Equatoriale"},{"nazione":"GY","descrizione":"Guyana"},{"nazione":"GF","descrizione":"Guyana Francese"},{"nazione":"HT","descrizione":"Haiti"},{"nazione":"HN","descrizione":"Honduras"},{"nazione":"HK","descrizione":"Hong Kong"},{"nazione":"IN","descrizione":"India"},{"nazione":"ID","descrizione":"Indonesia"},{"nazione":"IR","descrizione":"Iran"},{"nazione":"IQ","descrizione":"Iraq"},{"nazione":"IS","descrizione":"Islanda"},{"nazione":"BV","descrizione":"Isola di Bouvet"},{"nazione":"IM","descrizione":"Isola di Man"},{"nazione":"CX","descrizione":"Isola di Natale"},{"nazione":"HM","descrizione":"Isola Heard e Isole McDonald"},{"nazione":"NF","descrizione":"Isola Norfolk"},{"nazione":"KY","descrizione":"Isole Cayman"},{"nazione":"CC","descrizione":"Isole Cocos"},{"nazione":"CK","descrizione":"Isole Cook"},{"nazione":"FK","descrizione":"Isole Falkland"},{"nazione":"FO","descrizione":"Isole Faroe"},{"nazione":"MP","descrizione":"Isole Marianne Settentrionali"},{"nazione":"MH","descrizione":"Isole Marshall"},{"nazione":"UM","descrizione":"Isole Minori degli Stati Uniti d'America"},{"nazione":"SB","descrizione":"Isole Solomon"},{"nazione":"TC","descrizione":"Isole Turks e Caicos"},{"nazione":"VI","descrizione":"Isole Vergini Americane"},{"nazione":"VG","descrizione":"Isole Vergini Britanniche"},{"nazione":"IL","descrizione":"Israele"},{"nazione":"IT","descrizione":"Italia"},{"nazione":"KZ","descrizione":"Kazakhistan"},{"nazione":"KE","descrizione":"Kenya"},{"nazione":"KG","descrizione":"Kirghizistan"},{"nazione":"KI","descrizione":"Kiribati"},{"nazione":"XK","descrizione":"Kosovo"},{"nazione":"KW","descrizione":"Kuwait"},{"nazione":"LA","descrizione":"Laos"},{"nazione":"LS","descrizione":"Lesotho"},{"nazione":"LV","descrizione":"Lettonia"},{"nazione":"LB","descrizione":"Libano"},{"nazione":"LR","descrizione":"Liberia"},{"nazione":"LY","descrizione":"Libia"},{"nazione":"LI","descrizione":"Liechtenstein"},{"nazione":"LT","descrizione":"Lituania"},{"nazione":"LU","descrizione":"Lussemburgo"},{"nazione":"MO","descrizione":"Macao"},{"nazione":"MK","descrizione":"Macedonia"},{"nazione":"MG","descrizione":"Madagascar"},{"nazione":"MW","descrizione":"Malawi"},{"nazione":"MV","descrizione":"Maldive"},{"nazione":"MY","descrizione":"Malesia"},{"nazione":"ML","descrizione":"Mali"},{"nazione":"MT","descrizione":"Malta"},{"nazione":"MA","descrizione":"Marocco"},{"nazione":"MQ","descrizione":"Martinica"},{"nazione":"MR","descrizione":"Mauritania"},{"nazione":"MU","descrizione":"Maurizius"},{"nazione":"YT","descrizione":"Mayotte"},{"nazione":"MX","descrizione":"Messico"},{"nazione":"MD","descrizione":"Moldavia"},{"nazione":"MC","descrizione":"Monaco"},{"nazione":"MN","descrizione":"Mongolia"},{"nazione":"ME","descrizione":"Montenegro"},{"nazione":"MS","descrizione":"Montserrat"},{"nazione":"MZ","descrizione":"Mozambico"},{"nazione":"MM","descrizione":"Myanmar"},{"nazione":"NA","descrizione":"Namibia"},{"nazione":"NR","descrizione":"Nauru"},{"nazione":"NP","descrizione":"Nepal"},{"nazione":"NI","descrizione":"Nicaragua"},{"nazione":"NE","descrizione":"Niger"},{"nazione":"NG","descrizione":"Nigeria"},{"nazione":"NU","descrizione":"Niue"},{"nazione":"NO","descrizione":"Norvegia"},{"nazione":"NC","descrizione":"Nuova Caledonia"},{"nazione":"NZ","descrizione":"Nuova Zelanda"},{"nazione":"OM","descrizione":"Oman"},{"nazione":"NL","descrizione":"Paesi Bassi"},{"nazione":"PK","descrizione":"Pakistan"},{"nazione":"PW","descrizione":"Palau"},{"nazione":"PA","descrizione":"Panamá"},{"nazione":"PG","descrizione":"Papua Nuova Guinea"},{"nazione":"PY","descrizione":"Paraguay"},{"nazione":"PE","descrizione":"Peru"},{"nazione":"PN","descrizione":"Pitcairn"},{"nazione":"PF","descrizione":"Polinesia Francese"},{"nazione":"PL","descrizione":"Polonia"},{"nazione":"PT","descrizione":"Portogallo"},{"nazione":"PR","descrizione":"Porto Rico"},{"nazione":"QA","descrizione":"Qatar"},{"nazione":"GB","descrizione":"Regno Unito"},{"nazione":"CZ","descrizione":"Repubblica Ceca"},{"nazione":"CF","descrizione":"Repubblica Centroafricana"},{"nazione":"CG","descrizione":"Repubblica del Congo"},{"nazione":"CD","descrizione":"Repubblica Democratica del Congo"},{"nazione":"DO","descrizione":"Repubblica Dominicana"},{"nazione":"RE","descrizione":"Reunion"},{"nazione":"RO","descrizione":"Romania"},{"nazione":"RW","descrizione":"Ruanda"},{"nazione":"EH","descrizione":"Sahara Occidentale"},{"nazione":"KN","descrizione":"Saint Kitts e Nevis"},{"nazione":"PM","descrizione":"Saint Pierre e Miquelon"},{"nazione":"VC","descrizione":"Saint Vincent e Grenadine"},{"nazione":"WS","descrizione":"Samoa"},{"nazione":"AS","descrizione":"Samoa Americane"},{"nazione":"SM","descrizione":"San Marino"},{"nazione":"LC","descrizione":"Santa Lucia"},{"nazione":"SH","descrizione":"Sant'Elena"},{"nazione":"ST","descrizione":"Sao Tome e Principe"},{"nazione":"SN","descrizione":"Senegal"},{"nazione":"RS","descrizione":"Serbia"},{"nazione":"SC","descrizione":"Seychelles"},{"nazione":"SL","descrizione":"Sierra Leone"},{"nazione":"SG","descrizione":"Singapore"},{"nazione":"SY","descrizione":"Siria"},{"nazione":"SK","descrizione":"Slovacchia"},{"nazione":"SI","descrizione":"Slovenia"},{"nazione":"SO","descrizione":"Somalia"},{"nazione":"ES","descrizione":"Spagna"},{"nazione":"LK","descrizione":"Sri Lanka"},{"nazione":"FM","descrizione":"Stati Federati della Micronesia"},{"nazione":"US","descrizione":"Stati Uniti d'America"},{"nazione":"ZA","descrizione":"Sud Africa"},{"nazione":"SD","descrizione":"Sudan"},{"nazione":"GS","descrizione":"Sud Georgia e Isole Sandwich"},{"nazione":"SR","descrizione":"Suriname"},{"nazione":"SJ","descrizione":"Svalbard e Jan Mayen"},{"nazione":"SE","descrizione":"Svezia"},{"nazione":"CH","descrizione":"Svizzera"},{"nazione":"SZ","descrizione":"Swaziland"},{"nazione":"TJ","descrizione":"Tagikistan"},{"nazione":"TH","descrizione":"Tailandia"},{"nazione":"TW","descrizione":"Taiwan"},{"nazione":"TZ","descrizione":"Tanzania"},{"nazione":"IO","descrizione":"Territori Britannici dell'Oceano Indiano"},{"nazione":"TF","descrizione":"Territori Francesi del Sud"},{"nazione":"PS","descrizione":"Territori Palestinesi Occupati"},{"nazione":"TL","descrizione":"Timor Est"},{"nazione":"TG","descrizione":"Togo"},{"nazione":"TK","descrizione":"Tokelau"},{"nazione":"TO","descrizione":"Tonga"},{"nazione":"TT","descrizione":"Trinidad e Tobago"},{"nazione":"TN","descrizione":"Tunisia"},{"nazione":"TR","descrizione":"Turchia"},{"nazione":"TM","descrizione":"Turkmenistan"},{"nazione":"TV","descrizione":"Tuvalu"},{"nazione":"UA","descrizione":"Ucraina"},{"nazione":"UG","descrizione":"Uganda"},{"nazione":"HU","descrizione":"Ungheria"},{"nazione":"UY","descrizione":"Uruguay"},{"nazione":"UZ","descrizione":"Uzbekistan"},{"nazione":"VU","descrizione":"Vanuatu"},{"nazione":"VE","descrizione":"Venezuela"},{"nazione":"VN","descrizione":"Vietnam"},{"nazione":"WF","descrizione":"Wallis e Futuna"},{"nazione":"YE","descrizione":"Yemen"},{"nazione":"ZM","descrizione":"Zambia"},{"nazione":"ZW","descrizione":"Zimbabwe"}],
                            personal: {denominazione:'Italia', nazione:'IT'}
                        };

    $scope.userType.nazione = $scope.selNazioni.personal.nazione;

    $scope.selComune = function(item){
		$scope.userType.cap = item.cap;
		$scope.userType.nazione = "IT";
    };
    
    $scope.getDescrTipo = function(){
		var m = {PRIV:'Privati',
		    AZIE:'Aziende',
		    PROF:'Autonomi',
		    PUBA:'Enti locali',
		    NPCF: 'No Profit',
		    NPPI: 'No Profit con P.IVA'
		}; 
		return m[$scope.userType.id_tipo]; 	
    };
    
    $scope.descrDenominazione = function(){
		if (['PRIV','PROF'].indexOf($scope.userType.id_tipo) > -1){
			return "Nome e Cognome";
		} else if  (['NPCF','NPPI', 'PUBA'].indexOf($scope.userType.id_tipo) > -1){
			return "Denominazione";
		} else if  (['AZIE'].indexOf($scope.userType.id_tipo) > -1){
			return "Ragione Sociale";
		} else {
			return "Denominazione";
		}
    };
    
    $scope.descrIndirizzo = function(){
		if (['PRIV'].indexOf($scope.userType.id_tipo) > -1){
			return "Residenza";
		} else if  (['NPCF','NPPI', 'PUBA', 'AZIE'].indexOf($scope.userType.id_tipo) > -1){
			return "Sede";
		} else if  (['PROF'].indexOf($scope.userType.id_tipo) > -1){
			return "Studio";
		} else {
			return "Indirizzo";
		}
	};	

    $scope.riepilogo = function($event){
        $event.preventDefault();
        $scope.tabSpace = "auto-width";
    }


   //ng-click act
    $scope.act__ = function($event){
        $event.preventDefault();
        var id = $event.target.hash.replace('#', '');

        setTimeout(function () {
            angular.element('[data-link="'+id+'"]').trigger('click');
        }, 0);
    }


    $scope.changeProfile = function($event){
        var id = $scope.data.personal.id;

        $scope.userType.id_tipo = id;
    
        $scope.tabOk = "tab";
        console.log($scope.userType.chaptcha);
    }

    $scope.access_panel_btn = function($event){
        $event.preventDefault($event);
        var leftclm = angular.element('.left-clm');
        var rightClm = angular.element('.right-clm');
        var hash = $event.target.hash;

        $('.container-column form').css('display', 'none');

        $(hash).css('display', 'block');

        angular.element('.back-clm').attr('data-st', hash.replace('#',''));
        angular.element('.access_panel').css('height', '');
        leftclm.addClass('hide-left-clm');
        
        rightClm.css('display', 'inline');
        setTimeout(function(){
            rightClm.addClass('show-right-clm');
        }, 10);
    }

    $scope.back_clm = function($event){
        $event.preventDefault($event);

        console.log($event.target.dataset.st);
        if($event.target.dataset.st == "login"){
            angular.element('[href="#login"].access_panel_btn').addClass('display_none').html('Accedi <i class="material-icons">keyboard_arrow_right</i>');
            angular.element('[href="#signin"].access_panel_btn').removeClass('display_none').html('Registrati <i class="material-icons">keyboard_arrow_right</i>');    
        }else{
            angular.element('[href="#login"].access_panel_btn').removeClass('display_none').html('Accedi <i class="material-icons">keyboard_arrow_right</i>');
            angular.element('[href="#signin"].access_panel_btn').addClass('display_none').html('Registrati <i class="material-icons">keyboard_arrow_right</i>');    
        }

        var leftclm = angular.element('.left-clm');
        var rightClm = angular.element('.right-clm');

        rightClm.removeClass('show-right-clm');
        leftclm.css('transform', 'translate(0%)');
        angular.element('.access_panel').css('height', '100vh');

        setTimeout(function(){
            leftclm.removeClass('hide-left-clm');
            rightClm.removeClass('show-right-clm');
            leftclm.css('transform', '');
        }, 400);
    }
    

    if($routeParams.type == "signin"){
        $scope.type = "signin";
        angular.element('[href="#login"].access_panel_btn').addClass('display_none').html('Accedi <i class="material-icons">keyboard_arrow_right</i>');
        angular.element('[href="#signin"].access_panel_btn').removeClass('display_none').html('Registrati <i class="material-icons">keyboard_arrow_right</i>');

    }else{  //login default
        $scope.type = "login";
        angular.element('[href="#login"].access_panel_btn').removeClass('display_none').html('Accedi <i class="material-icons">keyboard_arrow_right</i>');
        angular.element('[href="#signin"].access_panel_btn').addClass('display_none').html('Registrati <i class="material-icons">keyboard_arrow_right</i>');
    }

    var uploadFilepond = [ ];
    /* Create Profile */
    $scope.createProfile = function(){
        var hErr = false;
        $scope.errori = [];
        /*
        *   Controllo errori
        */
       

            
        if($scope.userType.chaptcha === false){ //if string is empty
            alert("Please resolve the captcha and submit!")
        }else {

            $http({
                url: site_url + 'rest/users',
                method: 'POST',
                data: $scope.userType
            }).then(function(response){ // validate access
                if (response.data.code == 'OK'){
                    var userID = response.data.objectId;
                    $(document).ready(function(){
                        const formData = new FormData();
                        formData.append(uploadFilepond[0], uploadFilepond[1], uploadFilepond[1].name);
                        formData.append('id', userID) // id ricevuto id dell'utente
                                    
                        const request = new XMLHttpRequest();
                        request.open('PUT', site_url + 'rest/users/'+userID+'/profileimage');
            
                        // Should call the progress method to update the progress to 100% before calling load
                        // Setting computable to false switches the loading indicator to infinite mode
                        request.upload.onprogress = (e) => {
                            //progress(e.lengthComputable, e.loaded, e.total);
                        };
            
                        // Should call the load method when done and pass the returned server file id
                        // this server file id is then used later on when reverting or restoring a file
                        // so your server knows which file to return without exposing that info to the client
                        request.onload = function() {
                            if (request.status >= 200 && request.status < 300) {
                                // the load method accepts either a string (id) or an object
                                //load(request.responseText);
                                show_message('Success', 'Complimenti ti sei iscritto a Pecuswap! Attendi la mail per completare la registrazione e segui il link indicato.');

                            }
                            else {
                                // Can call the error method if something is wrong, should exit after
                                //error('oh no');
                                show_message('Info', 'La registrazione è andata a buon fine, ma abbiamo riscontrato un problema nel caricamento dell\'immagine.');
                                console.log(request.status, formData, "Failed");
                            }
                        };
            
                        request.send(formData);
                    });
                }else{
                    $scope.errori = response.data.messaggi;
                    show_message('Error', error.data.message);
                }
            }).catch(function (error, status){
                show_message('Error', error.data.message);
                console.log(error, status);
            }); 
        }
    }

    
    /* Authentication Access */
    $scope.acces_login = function(){
        var hErr = false;
        uname = $scope.userLog.username;
        pass = $scope.userLog.password;

        if(uname == undefined || uname == ''){
            $scope.username_log_error = 'Please insert Username!';
            hErr = true;
            return;
        }
        if(pass == undefined || pass == ''){
            $scope.password_log_error = 'Please insert Password!';
            hErr = true;
            return;
        }

        if(hErr == false){
            $http({
                url: site_url + 'rest/login',
                method: 'POST',
                data: $scope.userLog
            }).then(function(response){ // validate access
                $http({
                    url: site_url + 'rest/users/' + response.data.objectId,
                    method: 'GET'
                }).then(function(response_details){ // validate access
                    user.saveData(response_details.data);
    
                    window.location.reload();
                }).catch(function(error_det){ //Invalid Access
    
                    if ("undefined" !== typeof error_det.data){
                        show_message('Error', 'Username or password wrong!');
                    }
    
                    console.log(error_det);
                });
            }).catch(function(error){ //Invalid Access

                if ("undefined" !== typeof error.data){
                    show_message('Error','Username or password wrong!');
                }

                console.log(error);

            });
        }
    }


    function show_message(type = "Error", message = ""){
        var type_ = "";
        if(type == "Error"){
            type_ = "danger";
        }else if(type == "Info"){
            type_ = "warning"
        }else if(type == "Success"){
            type_ = "success"
        }else{
            type_ = "info"
        }
        var all_id = new Date().getTime();
        $('.error_log').append('<div class="alert alert-'+type_+' alert-dismissible fade show" id="'+all_id+'" role="alert">'+
                                    '<strong>'+type+':</strong> '+ message +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                        '<span aria-hidden="true">&times;</span>'+
                                    '</button>'+
                                '</div>');

        var timoff = setTimeout(function(){
            $('#'+all_id).fadeOut('slow', function(){
                $('#'+all_id).remove();
            });
            clearTimeout(timoff);
        }, 12000);
        
    };



    $(document).ready(function(){
        $('body').removeAttr('class');
        $('body').addClass('no-footer access-page');
        
        $('body').bootstrapMaterialDesign(); 
        /*$('.datetimepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
            }
        });*/

        function btn_acces_(){
            if($(window).width() >= 768){
                $('[href="#login"].access_panel_btn').on('click', function(){
                    window.location.href = '#!/access/login';
                });
                $('[href="#signin"].access_panel_btn').on('click', function(){
                    window.location.href = '#!/access/signin';
                });

                if($routeParams.type == "signin"){
                    $scope.type = "signin";
                    angular.element('[href="#login"].access_panel_btn').removeClass('display_none').html('Accedi <i class="material-icons">keyboard_arrow_right</i>');
                    angular.element('[href="#signin"].access_panel_btn').addClass('display_none').html('Registrati <i class="material-icons">keyboard_arrow_right</i>');
            
                }else{  //login default
                    $scope.type = "login";
                    angular.element('[href="#login"].access_panel_btn').addClass('display_none').html('Accedi <i class="material-icons">keyboard_arrow_right</i>');
                    angular.element('[href="#signin"].access_panel_btn').removeClass('display_none').html('Registrati <i class="material-icons">keyboard_arrow_right</i>');
                }
            }
        }
        btn_acces_();

        $(window).on('resize', function(e){
            btn_acces_();
        });

        FilePond.registerPlugin(
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType,
            FilePondPluginImageExifOrientation,
            FilePondPluginImageCrop,
            FilePondPluginImageResize,
            FilePondPluginImagePreview,
            FilePondPluginImageTransform,
        );

        FilePond.setOptions({
            acceptedFileTypes: ['image/*'],
            maxFileSize: '5MB',
            server: {
                process:(fieldName, file, metadata, load, error, progress, abort) => {
                    // fieldName is the name of the input field
                    // file is the actual file object to send
                    uploadFilepond = [];
                    uploadFilepond.push(fieldName, file);
                    load();
                    
                    // Should expose an abort method so the request can be cancelled
                    return {
                        abort: () => {
                            // This function is entered if the user has tapped the cancel button
                            request.abort();
    
                            // Let FilePond know the request has been cancelled
                            abort();
                        }
                    };
                }
            }
        });
        // Turn a file input into a file pond
        var pond = FilePond.create(
            document.querySelector('input[type="file"]'),
            {
              labelIdle: `Drag & Drop your picture or <span class="filepond--label-action">Browse</span>`,
              imagePreviewHeight: 170,
              imageCropAspectRatio: '1:1',
              imageResizeTargetWidth: 200,
              imageResizeTargetHeight: 200,
              stylePanelLayout: 'compact circle',
              styleLoadIndicatorPosition: 'center bottom',
              styleProgressIndicatorPosition: 'center bottom',
              styleButtonRemoveItemPosition: 'center bottom',
              styleButtonProcessItemPosition: 'center bottom',
          
            });

    });

}]);