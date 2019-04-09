angular.module('pecuswap')

.controller('CtrlUser',['$scope', '$routeParams', 'title_site', 'site_url', 'user', '$http', 'dateFilter', '$location', function($scope, $routeParams, title_site, site_url, user, $http, dateFilter, $location){
    $scope.user = user.getUserLoggedIn();
    $scope.logged = user.isUserLoggedIn();

    if($scope.logged == false){
        $location.path('/access/login');
        return;
    }
    
    
    var uploadFilepond = [ ];
    $scope.beforeSend = true;
    $scope.userType = {};
    $scope.GetUserInfo = Array();

    /* Dichiare pass var */
    $scope.ledit = {};

    $scope.userInfo = function($data = Array()){
        return {
            account_paypal: $data.account_paypal,
            cap : $data.cap,
            cellulare : $data.cellulare,
            comune : $data.comune,
            data_nascita: $data.data_nascita,
            comune_nascita: $data.comune_nascita,
            codice_fiscale: $data.codice_fiscale,
            denominazione: $data.denominazione,
            descrizione_attivita: $data.descrizione_attivita,
            email: $data.email,
            esperienze_lavorative: $data.esperienze_lavorative,
            fax: $data.fax,
            id_tipo: $data.id_tipo,
            id_utente: $data.id_utente,
            indirizzo: $data.indirizzo,
            interessi: $data.interessi,
            nazione: $data.nazione,
            nome_utente: $data.nome_utente,
            operativita_limitata: $data.operativita_limitata,
            partita_iva: $data.partita_iva,
            prefessione: $data.prefessione,
            pec: $data.pec,
            sesso: $data.sesso,
            telefono: $data.telefono,
            titolo_studio: $data.titolo_studio,
            /*Social */
            fb_feedback_inviati: $data.fb_feedback_inviati,
            fb_feedback_ricevuti: $data.fb_feedback_ricevuti,
            fb_acquisti: $data.fb_acquisti,
            fb_annunci: $data.fb_annunci,
            /* Privacy */
            data_nascita_vis: $data.data_nascita_vis,
            comune_nascita_vis: $data.comune_nascita_vis,
            codice_fiscale_vis: $data.codice_fiscale_vis,
            email_vis: $data.email_vis,
            comune_vis: $data.comune_vis,
            telefono_vis: $data.telefono_vis,
            partita_iva_vis: $data.partita_iva_vis,
            indirizzo_vis: $data.indirizzo_vis,
        };
    };

        
    $scope.getDescrTipo = function(){
		var m = {PRIV:'Privato',
		    AZIE:'Azienda',
		    PROF:'Autonomo',
		    PUBA:'Ente locale',
		    NPCF: 'No Profit',
		    NPPI: 'No Profit con P.IVA'
		}; 
		return m[$scope.GetUserInfo.id_tipo]; 	
    };

    $scope.userId = $routeParams.id;
    $scope.pg = $routeParams.pg;

    $scope.userType.id_utente = $scope.user.id;

    /**
     * User Personal Info
     */
    $http.get(site_url + 'rest/users/' + $scope.userId)
    .then(function(response){ 
        $scope.GetUserInfo = $scope.userInfo(response.data);
        $scope.userType = $scope.userInfo(response.data);
        $scope.data_nascita = new Date($scope.GetUserInfo.data_nascita);
        $scope.userType.passwd = response.data.passwd;
    }).catch(function(error_det){
        console.error(error_det);
    });   
    
    $scope.base64Img = "assets/img/guest-"+($scope.GetUserInfo.sesso == 'F' ? 'female' : 'male')+".png";
    
    /**
     * User Image
     */
    $http.get(site_url + 'rest/users/' + $scope.userId + '/profileimage')
    .then(function(response){ 
        $scope.beforeSend = false;
        $scope.base64Img = "data:image/png;base64,"+response.data.base64Img;
    }).catch(function(error_det){
        $scope.beforeSend = false;
        $scope.base64Img = "assets/img/guest-"+($scope.GetUserInfo.sesso == 'F' ? 'female' : 'male')+".png";
    });    

    /**
     * Settings Account
     */
    $scope.selNazioni = { 
        options: [{"nazione":"AF","descrizione":"Afghanistan"},{"nazione":"AL","descrizione":"Albania"},{"nazione":"DZ","descrizione":"Algeria"},{"nazione":"AD","descrizione":"Andorra"},{"nazione":"AO","descrizione":"Angola"},{"nazione":"AI","descrizione":"Anguilla"},{"nazione":"AQ","descrizione":"Antartide"},{"nazione":"AG","descrizione":"Antigua e Barbuda"},{"nazione":"AN","descrizione":"Antille Olandesi"},{"nazione":"SA","descrizione":"Arabia Saudita"},{"nazione":"AR","descrizione":"Argentina"},{"nazione":"AM","descrizione":"Armenia"},{"nazione":"AW","descrizione":"Aruba"},{"nazione":"AU","descrizione":"Australia"},{"nazione":"AT","descrizione":"Austria"},{"nazione":"AZ","descrizione":"Azerbaijan"},{"nazione":"BS","descrizione":"Bahamas"},{"nazione":"BH","descrizione":"Bahrain"},{"nazione":"BD","descrizione":"Bangladesh"},{"nazione":"BB","descrizione":"Barbados"},{"nazione":"BE","descrizione":"Belgio"},{"nazione":"BZ","descrizione":"Belize"},{"nazione":"BJ","descrizione":"Benin"},{"nazione":"BM","descrizione":"Bermuda"},{"nazione":"BT","descrizione":"Bhutan"},{"nazione":"BY","descrizione":"Bielorussia"},{"nazione":"BO","descrizione":"Bolivia"},{"nazione":"BA","descrizione":"Bosnia Erzegovina"},{"nazione":"BW","descrizione":"Botswana"},{"nazione":"BR","descrizione":"Brasile"},{"nazione":"BN","descrizione":"Brunei Darussalam"},{"nazione":"BG","descrizione":"Bulgaria"},{"nazione":"BF","descrizione":"Burkina Faso"},{"nazione":"BI","descrizione":"Burundi"},{"nazione":"KH","descrizione":"Cambogia"},{"nazione":"CM","descrizione":"Camerun"},{"nazione":"CA","descrizione":"Canada"},{"nazione":"CV","descrizione":"Capo Verde"},{"nazione":"TD","descrizione":"Ciad"},{"nazione":"CL","descrizione":"Cile"},{"nazione":"CN","descrizione":"Cina"},{"nazione":"CY","descrizione":"Cipro"},{"nazione":"VA","descrizione":"Città del Vaticano"},{"nazione":"CO","descrizione":"Colombia"},{"nazione":"KM","descrizione":"Comore"},{"nazione":"KP","descrizione":"Corea del Nord"},{"nazione":"KR","descrizione":"Corea del Sud"},{"nazione":"CI","descrizione":"Costa d'Avorio"},{"nazione":"CR","descrizione":"Costa Rica"},{"nazione":"HR","descrizione":"Croazia"},{"nazione":"CU","descrizione":"Cuba"},{"nazione":"DK","descrizione":"Danimarca"},{"nazione":"DM","descrizione":"Dominica"},{"nazione":"EC","descrizione":"Ecuador"},{"nazione":"EG","descrizione":"Egitto"},{"nazione":"IE","descrizione":"Eire"},{"nazione":"SV","descrizione":"El Salvador"},{"nazione":"AE","descrizione":"Emirati Arabi Uniti"},{"nazione":"ER","descrizione":"Eritrea"},{"nazione":"EE","descrizione":"Estonia"},{"nazione":"ET","descrizione":"Etiopia"},{"nazione":"RU","descrizione":"Federazione Russa"},{"nazione":"FJ","descrizione":"Fiji"},{"nazione":"PH","descrizione":"Filippine"},{"nazione":"FI","descrizione":"Finlandia"},{"nazione":"FR","descrizione":"Francia"},{"nazione":"GA","descrizione":"Gabon"},{"nazione":"GM","descrizione":"Gambia"},{"nazione":"GE","descrizione":"Georgia"},{"nazione":"DE","descrizione":"Germania"},{"nazione":"GH","descrizione":"Ghana"},{"nazione":"JM","descrizione":"Giamaica"},{"nazione":"JP","descrizione":"Giappone"},{"nazione":"GI","descrizione":"Gibilterra"},{"nazione":"DJ","descrizione":"Gibuti"},{"nazione":"JO","descrizione":"Giordania"},{"nazione":"GR","descrizione":"Grecia"},{"nazione":"GD","descrizione":"Grenada"},{"nazione":"GL","descrizione":"Groenlandia"},{"nazione":"GP","descrizione":"Guadalupa"},{"nazione":"GU","descrizione":"Guam"},{"nazione":"GT","descrizione":"Guatemala"},{"nazione":"GG","descrizione":"Guernsey"},{"nazione":"GN","descrizione":"Guinea"},{"nazione":"GW","descrizione":"Guinea-Bissau"},{"nazione":"GQ","descrizione":"Guinea Equatoriale"},{"nazione":"GY","descrizione":"Guyana"},{"nazione":"GF","descrizione":"Guyana Francese"},{"nazione":"HT","descrizione":"Haiti"},{"nazione":"HN","descrizione":"Honduras"},{"nazione":"HK","descrizione":"Hong Kong"},{"nazione":"IN","descrizione":"India"},{"nazione":"ID","descrizione":"Indonesia"},{"nazione":"IR","descrizione":"Iran"},{"nazione":"IQ","descrizione":"Iraq"},{"nazione":"IS","descrizione":"Islanda"},{"nazione":"BV","descrizione":"Isola di Bouvet"},{"nazione":"IM","descrizione":"Isola di Man"},{"nazione":"CX","descrizione":"Isola di Natale"},{"nazione":"HM","descrizione":"Isola Heard e Isole McDonald"},{"nazione":"NF","descrizione":"Isola Norfolk"},{"nazione":"KY","descrizione":"Isole Cayman"},{"nazione":"CC","descrizione":"Isole Cocos"},{"nazione":"CK","descrizione":"Isole Cook"},{"nazione":"FK","descrizione":"Isole Falkland"},{"nazione":"FO","descrizione":"Isole Faroe"},{"nazione":"MP","descrizione":"Isole Marianne Settentrionali"},{"nazione":"MH","descrizione":"Isole Marshall"},{"nazione":"UM","descrizione":"Isole Minori degli Stati Uniti d'America"},{"nazione":"SB","descrizione":"Isole Solomon"},{"nazione":"TC","descrizione":"Isole Turks e Caicos"},{"nazione":"VI","descrizione":"Isole Vergini Americane"},{"nazione":"VG","descrizione":"Isole Vergini Britanniche"},{"nazione":"IL","descrizione":"Israele"},{"nazione":"IT","descrizione":"Italia"},{"nazione":"KZ","descrizione":"Kazakhistan"},{"nazione":"KE","descrizione":"Kenya"},{"nazione":"KG","descrizione":"Kirghizistan"},{"nazione":"KI","descrizione":"Kiribati"},{"nazione":"XK","descrizione":"Kosovo"},{"nazione":"KW","descrizione":"Kuwait"},{"nazione":"LA","descrizione":"Laos"},{"nazione":"LS","descrizione":"Lesotho"},{"nazione":"LV","descrizione":"Lettonia"},{"nazione":"LB","descrizione":"Libano"},{"nazione":"LR","descrizione":"Liberia"},{"nazione":"LY","descrizione":"Libia"},{"nazione":"LI","descrizione":"Liechtenstein"},{"nazione":"LT","descrizione":"Lituania"},{"nazione":"LU","descrizione":"Lussemburgo"},{"nazione":"MO","descrizione":"Macao"},{"nazione":"MK","descrizione":"Macedonia"},{"nazione":"MG","descrizione":"Madagascar"},{"nazione":"MW","descrizione":"Malawi"},{"nazione":"MV","descrizione":"Maldive"},{"nazione":"MY","descrizione":"Malesia"},{"nazione":"ML","descrizione":"Mali"},{"nazione":"MT","descrizione":"Malta"},{"nazione":"MA","descrizione":"Marocco"},{"nazione":"MQ","descrizione":"Martinica"},{"nazione":"MR","descrizione":"Mauritania"},{"nazione":"MU","descrizione":"Maurizius"},{"nazione":"YT","descrizione":"Mayotte"},{"nazione":"MX","descrizione":"Messico"},{"nazione":"MD","descrizione":"Moldavia"},{"nazione":"MC","descrizione":"Monaco"},{"nazione":"MN","descrizione":"Mongolia"},{"nazione":"ME","descrizione":"Montenegro"},{"nazione":"MS","descrizione":"Montserrat"},{"nazione":"MZ","descrizione":"Mozambico"},{"nazione":"MM","descrizione":"Myanmar"},{"nazione":"NA","descrizione":"Namibia"},{"nazione":"NR","descrizione":"Nauru"},{"nazione":"NP","descrizione":"Nepal"},{"nazione":"NI","descrizione":"Nicaragua"},{"nazione":"NE","descrizione":"Niger"},{"nazione":"NG","descrizione":"Nigeria"},{"nazione":"NU","descrizione":"Niue"},{"nazione":"NO","descrizione":"Norvegia"},{"nazione":"NC","descrizione":"Nuova Caledonia"},{"nazione":"NZ","descrizione":"Nuova Zelanda"},{"nazione":"OM","descrizione":"Oman"},{"nazione":"NL","descrizione":"Paesi Bassi"},{"nazione":"PK","descrizione":"Pakistan"},{"nazione":"PW","descrizione":"Palau"},{"nazione":"PA","descrizione":"Panamá"},{"nazione":"PG","descrizione":"Papua Nuova Guinea"},{"nazione":"PY","descrizione":"Paraguay"},{"nazione":"PE","descrizione":"Peru"},{"nazione":"PN","descrizione":"Pitcairn"},{"nazione":"PF","descrizione":"Polinesia Francese"},{"nazione":"PL","descrizione":"Polonia"},{"nazione":"PT","descrizione":"Portogallo"},{"nazione":"PR","descrizione":"Porto Rico"},{"nazione":"QA","descrizione":"Qatar"},{"nazione":"GB","descrizione":"Regno Unito"},{"nazione":"CZ","descrizione":"Repubblica Ceca"},{"nazione":"CF","descrizione":"Repubblica Centroafricana"},{"nazione":"CG","descrizione":"Repubblica del Congo"},{"nazione":"CD","descrizione":"Repubblica Democratica del Congo"},{"nazione":"DO","descrizione":"Repubblica Dominicana"},{"nazione":"RE","descrizione":"Reunion"},{"nazione":"RO","descrizione":"Romania"},{"nazione":"RW","descrizione":"Ruanda"},{"nazione":"EH","descrizione":"Sahara Occidentale"},{"nazione":"KN","descrizione":"Saint Kitts e Nevis"},{"nazione":"PM","descrizione":"Saint Pierre e Miquelon"},{"nazione":"VC","descrizione":"Saint Vincent e Grenadine"},{"nazione":"WS","descrizione":"Samoa"},{"nazione":"AS","descrizione":"Samoa Americane"},{"nazione":"SM","descrizione":"San Marino"},{"nazione":"LC","descrizione":"Santa Lucia"},{"nazione":"SH","descrizione":"Sant'Elena"},{"nazione":"ST","descrizione":"Sao Tome e Principe"},{"nazione":"SN","descrizione":"Senegal"},{"nazione":"RS","descrizione":"Serbia"},{"nazione":"SC","descrizione":"Seychelles"},{"nazione":"SL","descrizione":"Sierra Leone"},{"nazione":"SG","descrizione":"Singapore"},{"nazione":"SY","descrizione":"Siria"},{"nazione":"SK","descrizione":"Slovacchia"},{"nazione":"SI","descrizione":"Slovenia"},{"nazione":"SO","descrizione":"Somalia"},{"nazione":"ES","descrizione":"Spagna"},{"nazione":"LK","descrizione":"Sri Lanka"},{"nazione":"FM","descrizione":"Stati Federati della Micronesia"},{"nazione":"US","descrizione":"Stati Uniti d'America"},{"nazione":"ZA","descrizione":"Sud Africa"},{"nazione":"SD","descrizione":"Sudan"},{"nazione":"GS","descrizione":"Sud Georgia e Isole Sandwich"},{"nazione":"SR","descrizione":"Suriname"},{"nazione":"SJ","descrizione":"Svalbard e Jan Mayen"},{"nazione":"SE","descrizione":"Svezia"},{"nazione":"CH","descrizione":"Svizzera"},{"nazione":"SZ","descrizione":"Swaziland"},{"nazione":"TJ","descrizione":"Tagikistan"},{"nazione":"TH","descrizione":"Tailandia"},{"nazione":"TW","descrizione":"Taiwan"},{"nazione":"TZ","descrizione":"Tanzania"},{"nazione":"IO","descrizione":"Territori Britannici dell'Oceano Indiano"},{"nazione":"TF","descrizione":"Territori Francesi del Sud"},{"nazione":"PS","descrizione":"Territori Palestinesi Occupati"},{"nazione":"TL","descrizione":"Timor Est"},{"nazione":"TG","descrizione":"Togo"},{"nazione":"TK","descrizione":"Tokelau"},{"nazione":"TO","descrizione":"Tonga"},{"nazione":"TT","descrizione":"Trinidad e Tobago"},{"nazione":"TN","descrizione":"Tunisia"},{"nazione":"TR","descrizione":"Turchia"},{"nazione":"TM","descrizione":"Turkmenistan"},{"nazione":"TV","descrizione":"Tuvalu"},{"nazione":"UA","descrizione":"Ucraina"},{"nazione":"UG","descrizione":"Uganda"},{"nazione":"HU","descrizione":"Ungheria"},{"nazione":"UY","descrizione":"Uruguay"},{"nazione":"UZ","descrizione":"Uzbekistan"},{"nazione":"VU","descrizione":"Vanuatu"},{"nazione":"VE","descrizione":"Venezuela"},{"nazione":"VN","descrizione":"Vietnam"},{"nazione":"WF","descrizione":"Wallis e Futuna"},{"nazione":"YE","descrizione":"Yemen"},{"nazione":"ZM","descrizione":"Zambia"},{"nazione":"ZW","descrizione":"Zimbabwe"}],
                            personal: {denominazione:'Italia', nazione:'IT'}
    };
    $scope.userType.nazione = $scope.selNazioni.personal.nazione;

    $scope.panelSel = function($event){
        $event.preventDefault($event);

        var href =  $event.currentTarget.hash;

        /* Add class to evidentiate panel show */
        angular.element('.section__card ul li a').removeClass('selezionato');
        angular.element($event.currentTarget).addClass('selezionato');

        angular.element('.panel-res').addClass('hidden');
        angular.element(href).removeClass('hidden');
    }
    
    $scope.descrDenominazione = function(){
		if (['PRIV','PROF'].indexOf($scope.GetUserInfo.id_tipo) > -1){
			return "Nome e Cognome";
		} else if  (['NPCF','NPPI', 'PUBA'].indexOf($scope.GetUserInfo.id_tipo) > -1){
			return "Denominazione";
		} else if  (['AZIE'].indexOf($scope.GetUserInfo.id_tipo) > -1){
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


    $scope.editProfile = function(){ 
        /**
         * Convert DATE 
         */
        $scope.userType.data_nascita = dateFilter($scope.data_nascita, 'yyyy-MM-ddT00:00:00');

        $http({
            url: site_url + 'rest/users/' + $scope.user.id,
            method: 'PUT',
            data: $scope.userType,
        }).then(function(response){ // validate access
            if (response.data.code == 'OK'){
                var userID = $scope.user.id;
                show_message('Success', 'Informazioni Aggiornate.');
                $(document).ready(function(){
                    if(uploadFilepond[0]){
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
                                show_message('Success', 'Immagine di profilo aggioranta.');

                            }
                            else {
                                // Can call the error method if something is wrong, should exit after
                                //error('oh no');
                                show_message('Error', 'Non è stato possibile aggiornare la tua immagine di copertina.');
                                console.log(request.status, formData, "Failed");
                            }
                        };
            
                        request.send(formData);
                    }
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

    /**
     * Edit Password
     */

    $scope.editPasswd = function(){  console.log($scope.ledit);
        var hErr = false;
        if($scope.ledit.passwd == null){
            hErr = true;
            show_message('Error', "Inserisci una password valida!");
        }

        if($scope.ledit.passwd_conferma != $scope.ledit.passwd){
            hErr = true;
            show_message('Error', "Attenzione, le password non coincidono!");
        }

        if(hErr == true) return;
        
        $scope.userType.passwd = $scope.ledit.passwd;
        $scope.userType.passwd_conferma = $scope.ledit.passwd_conferma;

        $http({
            url: site_url + 'rest/users/' + $scope.user.id,
            method: 'PUT',
            data: $scope.userType,
        }).then(function(response){ // validate access
            show_message('Success', 'Password aggiornata, verrai disconnesso tra 5 secondi, rieffettua l\'accesso.');
            user.clearData();
            setTimeout(function(){
                window.location.reload();
            }, 5000);
        }).catch(function (error, status){
            show_message('Error', error.data.message);
            console.log(error, status);
        }); 
    }

    /**
     * Edit Privacy 
     */
    $scope.data = {
        model: null,
        options: [
            {id: 'V', name: 'Pubblico'},
            {id: 'N', name: 'Privato'},
            {id: 'G', name: 'I tuoi Gruppi'},
        ]
    };

    $scope.changePrivacy = function($event){
        $http({
            url: site_url + 'rest/users/' + $scope.user.id,
            method: 'PUT',
            data: $scope.userType,
        }).then(function(response){ // validate access
        }).catch(function (error, status){
            show_message('Error', error.data.message);
            console.log(error, status);
        }); 
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
        }, 8000);
        
    };

    $(document).ready(function(){
        $('body').removeAttr('class');
        $('body').addClass('elab_box contact');
        
        $('body').bootstrapMaterialDesign(); 

        $('#editAccount input').focus();

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
        
        $('#map__').ready(function () {
            setTimeout(function(){
                $('.load_map').fadeOut();
            }, 900);
        });
    });

}]);