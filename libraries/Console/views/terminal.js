$('#terminal').on('click', function(e){
    $('console.console .terminal.table .input-terminal').focus();
    $('console.console .terminal.table .terminal-cursor').addClass("active-anim");
});

$('console.console .terminal.table .input-terminal').on('keyup', function(e){
    $('.text-writing').text($(this).val());
    if(e.keyCode == 13){
        let Terminal_ = new Terminal();
        if( Terminal_.checking($(this).val().replace(/\n/g, "")) == undefined){
            $('.terminal-output').append("<span>Gaia@localhost:~$ " + Terminal_.checking($(this).val().replace(/\n/g, "")) + "</span>");
        }else{
            $('.terminal-output').append("<span>Gaia@localhost:~$ " + Terminal_.errors(1) + "</span>");
        }
        $('.text-writing').text("");
        $(this).val("");
    }
});
$('console.console .terminal.table .input-terminal').on('blur', function(e){
    $('console.console .terminal.table .terminal-cursor').removeClass("active-anim");
});

 
class Terminal{
    help(){
        return "help>>> <br> Welcome to Cloud Shell! Type \"help\" to get started."+
                "<br>ECHO &emsp; Generate an ouput string"+
                "<br>-V &emsp; Visualize framework version<br>";
    }

    versionFrmc(){

        $.ajax({
            type: "POST",
            url: "libraries/Console/Command.php",
            data: "route=console/terminal/versionFrm",
            dataType: "html",
            success: function(msg){
                var decode = JSON.parse(msg);
                return "-v>>> <br> Framework Version: V"+ decode['framework_version'] +
                    "<br> Console Version: V"+ decode['terminal_version'] +
                    "<br> Update current: V" +decode['current_framework_version'];
            },
            error: function(){
                return this.errors(2);
            }
        });

    }

    checking(value){
        switch(value){
            case "help":
                return this.help();
            break;
            case "-v":
                return this.versionFrmc();
            break;
            default:
                return this.errors(1);
            break;
        }

    }

    errors(type){ 
        switch(type){
            case 1:
                return "<font color='red'>Error not found ;</font>";
            break;
            case 2:
                return "<font color='red'>Error Connection refused!</font>";
            break;
        }
    }
}