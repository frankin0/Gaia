
  <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

      <link rel="stylesheet" href="style.css">

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>

        <div class="max-cont">
            <div class="container">
                <!-- Page Content goes here -->
                <header>
                    <nav class="transparent no-shadow">
                        <div class="nav-wrapper transparent nav-bar">
                            <a href="./" class="brand-logo black-text">Promoto</a>
                            <a href="#" data-activates="mobile-demo" class="button-collapse waves-effect btn-flat waves-light black-text"><i class="material-icons">menu</i></a>
                            <ul id="nav-mobile" class="right hide-on-med-and-down">
                                <li><a href="#signin" class="access black-text">Accedi</a></li>
                                <li><a href="#signup" class="access black-text">Registrati</a></li>
                            </ul>
                            <ul class="side-nav red darken-1" id="mobile-demo" style="transform: translateX(-100%);">
                                <li>
                                    <div class="user-view">
                                        <br>
                                        <div class="background">
                                            <a href="./" class="brand-logo">Promoto</a>
                                        </div>
                                        <br><br>
                                    </div>
                                </li>
                                <li><a href="#signin" class="access"><div class="rt-tdrb">Accedi</div></a></li>
                                <li><a href="#signup" class="access"><div class="rt-tdrb">Registrati</div></a></li>
                            </ul>
                        </div>
                    </nav>
                </header>

                <div class="body-container row" id="content" data-load="home">
                    <div class="col m6 s12">
                        <h2 style="font-size: 2rem;font-weight: 100;">Benvenuto in Promoto</h2>
                        <p style="font-size: 17px;">Promoto è un'innovativa piattaforma di biglietteria digitale che garantisce la completa transparenza ed efficenza ai propri clienti.</p>
                        
                        <center><a href="?event_type" class="waves-effect waves-light btn red darken-1" style="margin-top: 100px;">Visualizza tutti gli eventi</a></center>
                    </div>
                    <div class="col m6 s12">
                        <img src="https://www.promo-to.it/theme/basic/img/italia-map.png" style="width: 100%; margin-top: 40px; margin-bottom: 40px;" rel="Italy map">
                    </div>
                    <div class="col m12 s12">
                        &nbsp;<br>&nbsp;<br>
                    </div>
                </div>
            </div>
        </div>
        <footer class="page-footer transparent" style="margin-top: 0px;">
            <div class="container">
                <div class="ctrx">        

                    <div class="row">
                        <div class="col m6 s12">
                            <h5 class="red-text text-darken-1"></h5>
                            <ul>
                                <li><i class="material-icons icon-bk-gray grey-text">email</i> <a class="white-text email-footer-text" href="mailto:support@promo-to.it">support@promo-to.it</a></li>
                            </ul>
                        </div>
                        <div class="col m6 s12">
                            <h5 class="white-text">Chi siamo</h5>
                            <p class="white-text">Promoto Inc.</p>
                            <p class="white-text">www.promo-to.it</p><br>

                            <p class="white-text">Cel: +39 351 966 2296 - Lunedì e Venerdì 9:00 / 13:00</p>
                            <br>
                            <ul style="display: flex;" class="social-list">
                                <li><a href="https://www.facebook.com/pg/Promoto-2021179451533935" target="blank_"><i class="fa fa-facebook icon-style grey-text" aria-hidden="true"></i></a></li>
                                <li><a href="https://www.instagram.com/promoto_italia/" target="blank_"><i class="fa fa-instagram icon-style grey-text" aria-hidden="true"></i></a></li>
                            </ul>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    <div class="ctrx">
                        <span class="grey-text">© 2018 Copyright Promoto inc.</span>
                        <span class="right"><a href="?policies#help-01" class="grey-text underline">Condizioni Help</a> <font color="#212121">·</font> <a href="?policies#copyright" class="grey-text underline">Privacy &amp; Copyright</a></span>
                    </div>
                </div>
            </div>
        </footer>

        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    </body>
  </html>
        