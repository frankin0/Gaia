var app = angular.module('pecuswap', ['ngRoute','ngStorage']);
app.value('title_site', 'pecuswap');
app.value('site_url', 'http://ns325217.ip-91-121-6.eu:8081/pecuswap_test/');
app.config(function($routeProvider, $locationProvider){
    $routeProvider
    .when('/', {
        controller: 'CtrlHome',
        templateUrl: 'template/view/home.html'
    })
    .when('/contact', {
        controller: 'CtrlContact',
        templateUrl: 'template/view/pages/contact.html'
    })
    .when('/getting-started', {
        controller: 'CtrlGlobGettingStarted',
        templateUrl: 'template/view/pages/getting-started.html'
    })
    .when('/faq', {
        controller: 'CtrlGlobFaq',
        templateUrl: 'template/view/pages/faq.html'
    })
    .when('/policies', {
        controller: 'CtrlGlobPolicies',
        templateUrl: 'template/view/pages/policies.html'
    })
    .when('/privacy', {
        controller: 'CtrlGlobPrivacy',
        templateUrl: 'template/view/pages/privacy.html'
    })
    .when('/access/:type', {
        resolve: { // if you don't have logged in
            check: function($location, user){
                if(user.isUserLoggedIn()){
                    $location.path('/');
                }
            }
        },
        controller: 'CtrlAccess',
        templateUrl: 'template/view/pages/access.html'
    })
    .when('/desk/:type', {
        controller: 'CtrlList',
        templateUrl: 'template/view/pages/list.html'
    }) 
    .when('/item/:id', {
        controller: 'CtrlItem',
        templateUrl: 'template/view/pages/item.html'
    })
    .when('/user/:id', {
        controller: 'CtrlUser',
        templateUrl: 'template/view/backoffice/user.html'
    })
    .when('/user/:id/:pg', {
        controller: 'CtrlUser',
        templateUrl: 'template/view/backoffice/user.html'
    })
    .when('/logout', {
        resolve: {
            
            deadResolve: function($location, user){
                if(user.isUserLoggedIn()){
                    user.clearData();
                    window.location.reload();
                    //$location.path('/');
                }
            }, 
            check: function($location, user){
                if(!user.isUserLoggedIn()){
                    $location.path('/');
                }
            }
        }
    })
    
    .otherwise({
        redirectTo : '/'
    });
    
    /*$locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });*/
})
.service('user', function(){
    
	var loggedin = false;
    var id, name, id_tipo, nome_utente, email;

	this.setID = function(userID) {
		id = userID;
	};
	this.getID = function() {
		return id;
    };
    
    this.getUserLoggedIn = function(){
        var data = JSON.parse(localStorage.getItem('login'));
        return data;
    }

	this.isUserLoggedIn = function() {
		if(!!localStorage.getItem('login')) {
			loggedin = true;
			var data = JSON.parse(localStorage.getItem('login'));
			id = data.id;
		}
		return loggedin;
	};
	this.saveData = function(data) {
        id = data.id_utente;
        name = data.denominazione;
        id_tipo = data.id_tipo;
        nome_utente = data.nome_utente;
        email = data.email;

		loggedin = true;
		localStorage.setItem('login', JSON.stringify({
            id: id,
            name: name,
            id_tipo: id_tipo,
            nome_utente: nome_utente,
            email: email
		}));
	};

    this.clearData = function() {
		localStorage.removeItem('login');
        id = "";
        name = "";
        id_tipo = "";
        nome_utente = "";
        email = "";
		loggedin = false;
    }
    
});