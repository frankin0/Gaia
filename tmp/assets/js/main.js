var AcecssPage = function(){

    $('.access_panel_btn').on('click', function(e){
        var leftclm = $('.left-clm');
        var rightClm = $('.right-clm');
        var href = $(this).attr('href');

        $('.container-column form').css('display', 'none');

        $(href).css('display', 'block');

        if(href == "#signin"){// btn btn-info btn-fab btn-round access_panel_btn
            $('[href="#login"].access_panel_btn').removeClass('btn-fab').html('Accedi<i class="material-icons">keyboard_arrow_right</i>');
            $('[href="#signin"].access_panel_btn').addClass('btn-fab').html('<i class="material-icons">keyboard_arrow_left</i>');
        }else{
            $('[href="#login"].access_panel_btn').addClass('btn-fab').html(' <i class="material-icons">keyboard_arrow_right</i>');
            $('[href="#signin"].access_panel_btn').removeClass('btn-fab').html('Registrati <i class="material-icons">keyboard_arrow_left</i>');
        }

        $('.access_panel').css('height', '');
        leftclm.addClass('hide-left-clm');
        
        rightClm.css('display', 'inline');
        setTimeout(function(){
            rightClm.addClass('show-right-clm');
        }, 10);
        e.preventDefault();

    });


    $('.registration-panel').on('submit', function(e){ e.preventDefault(); return; });
    $('#back-clm, .back-clm').on('click', function(e){
        var leftclm = $('.left-clm');
        var rightClm = $('.right-clm');

        rightClm.removeClass('show-right-clm');
        leftclm.css('transform', 'translate(0%)');
        $('.access_panel').css('height', '100vh');

        setTimeout(function(){
            leftclm.removeClass('hide-left-clm');
            rightClm.removeClass('show-right-clm');
            leftclm.css('transform', '');
        }, 400);

        e.preventDefault();

    });

    $('.act__').on('click', function(e){
        e.preventDefault();
        var $this = $(this);
        $('[data-link="' + $this.attr('href').replace('#', '') +'"]').click();
    });

    var profileArr = Array(1, 2, 3, 4, 5, 6);

    $('#input_profile').on('change', function(e){
        /**
         * Unlock registration element 
         */


        switch(this.value){
            case '1':   // Privati
                console.log('Privati');
                $('#personal_data').load('assets/public/nav/privated.html');
            break;
            case '2':   // Socità
                $('#personal_data').load('assets/public/nav/society.html');
                console.log('Socità');
            break;
            case '3':   // Autonomi
                $('#personal_data').load('assets/public/nav/autonomous.html');
                console.log('Autonomi');
            break;
            case '4':   // Enti Locali
                $('#personal_data').load('assets/public/nav/society.html');
                console.log('Enti Locali');
            break;
            case '5':   // No Profit
                $('#personal_data').load('assets/public/nav/society.html');
                console.log('No Profit');
            break;
            case '6':   // No Profit con P.IVA
                $('#personal_data').load('assets/public/nav/society.html');
                console.log('No Profit con P.IVA');
            break;

        }


        if(this.value == 1){
            $('#pr__').text('Residenza');
            $('.nav-pills .nav-item .nav-link').attr('data-toggle', 'tab').removeClass('disabled');
        }else if(this.value == 2 || this.value == 3 || this.value == 4 || this.value == 5 || this.value == 6){
            $('#pr__').text('Sede');
            $('.nav-pills .nav-item .nav-link').attr('data-toggle', 'tab').removeClass('disabled');
        }else if(this.value == 0){
            $('.nav-pills .nav-item .nav-link').attr('data-toggle', '').addClass('disabled');
        }

        e.preventDefault();
    });
};

    var slider_text = function($data){ 
        var dt = $('.slider-text').data();
        if($('.slider-text').length === 0){
            return
        }
        if(dt['time'] == null){
            console.error("Error on slide text $(..).slider_text(); data time is null");
            return;
        }
        
        var i_ =1;

        setInterval(function(){ 
            for (var i = 0; i < $data.length; i++) {
                $('.slider-text p').html('" '+$data[i_]+' "');
            }

            (i_ != $data.length - 1) ? i_ ++ : i_ = 0;
        }, dt['time']);
            
    }


$(function(){
    AcecssPage();
     // Register plugins
/*    FilePond.registerPlugin(
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
    var pond = FilePond.create(document.querySelector('input[type="file"]'));
*/


});
