function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function validateHttp(url) {
	var pattern = /(http|ftp|https)?(:\/\/)?[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/;
	return pattern.test(url);
}

$('[submit-log]').on('click', function(e){
    e.preventDefault();

    var herror = false;
    var d = new Date();
	var post_data = $('[form-login]').serializeArray();
	post_data.push({name: "log", value: d.getTime()});


    $('[form-login] [name="username"]').css({'border-bottom': ''});
    $('[form-login] [name="password"]').css({'border-bottom': ''});

    if($('[form-login] [name="username"]').val() == ''){
        herror = true;
        $('[form-login] [name="username"]').css({'border': '1px solid red'});
    }else if($('[form-login] [name="password"]').val().length <= 4){
        herror = true;
        $('[form-login] [name="password"]').css({'border': '1px solid red'});
    }


    if(herror == false){
        $.ajax({
			type: "POST",
			url: "/log",
			data: post_data,
			dataType: "html",
			beforeSend: function(msg){
                $('[submit-log]').html('<div class="lds-ring"><div></div></div>');
                $('[submit-log]').prop('disabled', true);
			},
			success: function(msg){
				if(JSON.parse(msg)['stat'] == '_success_'){
                    window.location.href = '/home';
                }else if(JSON.parse(msg)['stat'] == '_error_user_not_found_'){
                    $('[submit-log]').html('Login');
                    $('[submit-log]').prop('disabled', false);
                    notify('error: _type_error_2_ !', 'error');
                    console.log(msg);
                }else{
                    $('[submit-log]').prop('disabled', false);
                    notify('error: _type_error_ !', 'error');
                    $('[submit-log]').html('Login');
                    console.log(msg);
                }
			},
			error: function(){
				console.log("Errore: connessione assente o file mancante ['registration']...");
			}
		});
    }


});



$('[submit-ck]').on('click', function(e){
    e.preventDefault();
    var herror = false;
    var d = new Date();
	var post_data = $('[form-registration]').serializeArray();
	post_data.push({name: "reg", value: d.getTime()});

    $('[form-registration] [name="username"]').css({'border-bottom': ''});
    $('[form-registration] [name="email"]').css({'border-bottom': ''});
    $('[form-registration] [name="password"]').css({'border-bottom': ''});
    $('[form-registration] [name="repeatpassword"]').css({'border-bottom': ''});

    if($('[form-registration] [name="username"]').val() == '' ){
        herror = true;
        $('[form-registration] [name="username"]').css({'border-bottom': '1px solid red'});
    }else if($('[form-registration] [name="email"]').val() == '' || !validateEmail($('[form-registration] [name="email"]').val())){
        herror = true;
        $('[form-registration] [name="email"]').css({'border-bottom': '1px solid red'});
    }else if($('[form-registration] [name="password"]').val().length <= 4){
        herror = true;
        $('[form-registration] [name="password"]').css({'border-bottom': '1px solid red'});
    }else if($('[form-registration] [name="repeatpassword"]').val() != $('[form-registration] [name="password"]').val()){
        herror = true;
        $('[form-registration] [name="repeatpassword"]').css({'border-bottom': '1px solid red'});
        $('[form-registration] [name="password"]').css({'border-bottom': '1px solid red'});
    }

    if(herror == true) {return false;}

    if(herror == false){
        $.ajax({
			type: "POST",
			url: "/reg",
			data: post_data,
			dataType: "html",
			beforeSend: function(msg){
                $('[submit-ck]').html('<div class="lds-ring"><div></div></div>');
                $('[submit-ck]').prop('disabled', true);
			},
			success: function(msg){
				if(JSON.parse(msg)['stat'] == '_success_'){
                    $('[submit-ck]').html('SignUp');
                    notify('Registration Complete!', 'success');
                }else{
                    $('[submit-ck]').prop('disabled', false);
                    notify('error: _type_error_ !', 'error');
                }
			},
			error: function(){
				console.log("Errore: connessione assente o file mancante ['registration']...");
			}
		});
    }

});




function notify(text, type){

    $('body').append('<div class="notify ' + type + '">' + text + '</div>');

    setTimeout(function(){
        $('.notify').remove();
    }, 4000);
}
