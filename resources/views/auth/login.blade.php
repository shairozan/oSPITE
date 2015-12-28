<!DOCTYPE html>
<html lang="en">

<!--================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 3.0
	Author: GeeksLabs
	Author URL: http://www.themeforest.net/user/geekslabs
================================================================================ -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
    <title>oSPITE Campaign Manager</title>

    <!-- Favicons-->
    <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon/apple-touch-icon-152x152.png') }}">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="{{ asset('images/favicon/mstile-144x144.png') }}">
    <!-- For Windows Phone -->

    <!-- jQuery Library -->
    <script type="text/javascript" src="{{ asset('js/plugins/jquery-1.11.2.min.js') }}"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


    <!-- CORE CSS-->
    <link href="{{ asset('css/materialize.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ asset('css/style.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- CSS for full screen (Layout-2)-->
    <link href="{{ asset('css/layouts/style-fullscreen.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->
    <link href="{{asset('css/custom/custom-style.css') }}" type="text/css" rel="stylesheet" media="screen,projection">


    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="{{ asset('js/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ asset('js/plugins/jvectormap/jquery-jvectormap.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ asset('js/plugins/chartist-js/chartist.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">




</head>

<body>
<div class="container">

    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="card-panel">
                <h4 class="header2">Abandon all hope ye who enter here</h4>

                <div class="row">
                    <form class="formValidate" id="formValidate" method="post" action="">
                        <div class="row">
                            {!! csrf_field() !!}
                            
                            <div class="input-field col s12">

                            <div class="input-field col s12">
                                <label for="cemail">E-Mail *</label>
                                <input id="cemail" type="email" name="cemail" data-error=".errorTxt2">
                                <div class="errorTxt2"></div>
                            </div>

                            <div class="input-field col s12">
                                <label for="password">Password *</label>
                                <input id="password" type="password" name="password" data-error=".errorTxt3">
                                <div class="errorTxt3"></div>
                            </div>

                            <div class="input-field col s12">
                                <button class="btn waves-effect waves-light right submit" type="submit" name="action">Submit
                                    <i class="mdi-content-send right"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>

</div>
</div>

</body>
</html>