<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Login Form/Register form</title>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

        <link rel="stylesheet" href="<?php echo URL ?>application/views/login_register/css/style.css">
        <link rel="stylesheet" href="<?php echo URL ?>application/views/login_register/css/stylePopUp.css">

        <link rel="icon" href="<?php echo URL ?>application/views/_templates/favicon.ico">
    </head>

    <body>
        <!-- JQUERY, FONTAWESOME AND NORMALIZED CSS INSTALLED-->
        <!-- View settings for more info.-->
        <div id="formContainer">

            <!-- Popup per i dati errati -->
            <div class="cd-popup wrongPass" role="alert">
                <div class="cd-popup-container">
                    <p>Email e/o Password errati</p>
                    <ul class="cd-buttons" style="list-style-type: none;">
                        <li><a href="#0" class="ok-close">OK</a></li>
                    </ul>
                    <a href="#0" class="cd-popup-close img-replace">Close</a>
                </div> <!-- cd-popup-container -->
            </div> <!-- cd-popup -->

            <!-- Popup per l'utente inesistente -->
            <div class="cd-popup noUser" role="alert">
                <div class="cd-popup-container">
                    <p>Utente inesistente</p>
                    <ul class="cd-buttons" style="list-style-type: none;">
                        <li><a href="#0" class="ok-close">OK</a></li>
                    </ul>
                    <a href="#0" class="cd-popup-close img-replace">Close</a>
                </div> <!-- cd-popup-container -->
            </div> <!-- cd-popup -->