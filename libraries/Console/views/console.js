
$(document).ready(function(){
	var heightX, draggable = true;
	
    $('.drag').on('mousedown', function(e){
		if(draggable){
			var $dragable = $(this).parent(),
				startHeight = $dragable.height(),
				pX = e.pageX,
				pY = e.pageY;
			
			$(document).on('mouseup', function(e){
				$(document).off('mouseup').off('mousemove');
			});
			$(document).on('mousemove', function(me){
				var my = (me.pageY - pY);
				heightX = startHeight - my;
				$dragable.css({
					left: 0,
					height: startHeight - my,
				});
			});
        }   
    });
	
	$('.hide-box').on('click', function(){
		if(!$('.console').hasClass('hidden')){
			$('.console .main .body, .console .main').css('height', '0px');
			$(this).children('.material-icons').remove();
			$(this).html('<i class="material-icons">keyboard_arrow_up</i>');
			$('.console').addClass('hidden');
			draggable = false;
		}else{
			$('.console .main .body, .console .main').css('height', 'auto');
			$('.console .main').css('height', heightX + "px");
			$(this).children('.material-icons').remove();
			$(this).html('<i class="material-icons">keyboard_arrow_down</i>');
			$('.console').removeClass('hidden');
			draggable = true;
		}
	});
	
	$('.close-box').on('click', function(){
		$('.console').remove();
	});
	
	$('.list-links li a').on('click', function(e){
		e.preventDefault();
		var hash = this.hash;
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("table");

		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("links");
		for (i = 0; i < tablinks.length; i++) { 
			$(tablinks[i].parentNode).removeClass("active");
		}
		document.getElementById(hash.replace('#','')).style.display = "block";
		$(e.currentTarget.parentNode).addClass("active");
	});
	
	$('.buttonUnistall').on('click', function(){
		var name = $(this).attr('id');
		var isTrue = false;
		if(name == 'Console'){
			if (confirm('Are you sure you disable the console?')) {
				isTrue = true;
			}else{
				isTrue = false;
			}
		}else{
			isTrue = true;
		}
			
		if(isTrue){
			$.ajax({
				type: "POST",
				url: "libraries/Console/Command.php",
				data: "route=console/unistall/" + name,
				dataType: "html",
				beforeSend: function(){
					//$('.listPrj').html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
				},
				success: function(msg){
					$('.list-links li a[href="#log"]').trigger('click');
					$('#log ul').append('<li>Unistallation ' + name + '...</li>');
					$('#log ul').append(msg);
				},
				error: function(){
					$('#log ul').html('<li><font color="red"><b>Error Unistall</b>: Connection error to Unistall ' + name + '</font></li>');
				}
			});
		}
	});
	
	$('.buttonInstall').on('click', function(){
		var name = $(this).attr('id');
			
			$.ajax({
				type: "POST",
				url: "libraries/Console/Command.php",
				data: "route=console/install/" + name,
				dataType: "html",
				beforeSend: function(){
					//$('.listPrj').html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
				},
				success: function(msg){
					$('.list-links li a[href="#log"]').trigger('click');
					$('#log ul').append('<li>Installation of ' + name + '...</li>');
					$('#log ul').append(msg);
				},
				error: function(){
					$('#log ul').html('<li><font color="red"><b>Error Unistall</b>: Connection error to Unistall ' + name + '</font></li>');
				}
			});
	});

	$('.list_stgs li a').on('click', function(e){

		$(this).children().children("input").focus();
	});

	
	$('.buttonUpdate').on('click', function(e){ 
		e.preventDefault();

		var input_val = $(this).parent().children("input").val();
		var input_id = $(this).parent().children("button").data("key");
		var old_TX = $(this).parent().children("input").data("oldtx");
		var hError = false;

		if(input_val == '' || input_val == undefined){
			hError = true;
			$('#log ul').html('<li><font color="red"><b>Error Update</b>: Error irreversible!</font></li>');
		}

		if(hError == false){
			$.ajax({
				type: "POST",
				url: "libraries/Console/Command.php",
				data: "route=console/settings/update/&input_val=" + input_val + "&id=" + input_id + "&old_TX=" + old_TX,
				dataType: "html",
				beforeSend: function(){
					//$('.listPrj').html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
				},
				success: function(msg){
					console.log(msg);
				},
				error: function(){
					$('#log ul').html('<li><font color="red"><b>Error Update</b>: Connection error to Unistall ' + name + '</font></li>');
				}
			});
		}
		
	});

	$('#load_file_form').on('submit', function(e){
		e.preventDefault();
		var file_data = $('#file_plgs__').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);
		if(file_data){
			if(file_data.type == "application/x-zip-compressed"){ 
				$.ajax({
					url: 'libraries/Console/Command.php', // point to server-side PHP script 
					dataType: 'text',  // what to expect back from the PHP script, if anything
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,                         
					type: 'post',
					success: function(msg){
						$('.list-links li a[href="#log"]').trigger('click');
						$('#log ul').append(msg);
					}
				});
			}
		}
	});
	
});
