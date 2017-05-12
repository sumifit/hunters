<!DOCTYPE html>
<?php
ob_start();
session_start();

if(isset($_SESSION['_id']) && !empty($_SESSION['_id'])){
    header("Location: candidates/profile.php");
}

include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."application".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."bootstrap.php";

?>
<html ng-app="hunters">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hunters | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="google-signin-clientid" content="<?php if(DEBUG) echo GOOGLEPLUS_DEBUG; else echo GOOGLEPLUS_PROD; ?>">

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- CheckBox-->
    <!-- Custom styles for this template -->
    <link href="bootstrap/css/bootstrap-switch.css" rel="stylesheet">

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oxygen:400,300,700">
    <link rel="stylesheet" href="dist/css/video_style.css">
    <link rel="stylesheet" href="dist/css/geral.css">
    <link rel="stylesheet" href="node_modules/angular-loading-bar/build/loading-bar.min.css">

    <script type="text/javascript" src="//platform.linkedin.com/in.js">
        api_key: 78a31asbikx1we
        authorize: true
</script>

    <script src="node_modules/angular/angular.min.js"></script>
    <script src="node_modules/angular-promise-buttons/dist/angular-promise-buttons.min.js"></script>
    <script src="node_modules/alertify.js/dist/js/ngAlertify.js"></script>
    <script src="node_modules/angular-loading-bar/build/loading-bar.min.js"></script>
    <!-- google+ login -->
    <!--<script src="bower_components/angular-directive.g-signin/google-plus-signin.js"></script>-->

    <script src="dist/js/hunters.js"></script>
    <script>
        hunters.controller('loginController', function ($scope, $http, configs, alertify) {

            $("[name='lembrar']").bootstrapSwitch();

            (function () {
                /**
                 * Video element
                 * @type {HTMLElement}
                 */
                var video = document.getElementById("my-video");

                /**
                 * Check if video can play, and play it
                 */
                video.addEventListener("canplay", function () {
                    video.play();
                });
            })();

            /*
             * LINKEDIN LOGIN
             * */
            $scope.doLoginLinkedin = function () {

                function getLinkedinData() {
                    IN.API.Profile("me").fields(
                        ["id", "formatted-name", "pictureUrl",
                            "location", "summary", "specialties", "email-address", "positions"]).result(function (result) {

                        //grava os dados do usuario no nosso banco
                        var userData = "email=" + result.values[0].emailAddress +
                            "&nome=" + result.values[0].formattedName +
                            "&image_link="+ result.values[0].pictureUrl +
                            "&linkedin_id=" + result.values[0].id;

                        var action = "loginLinkedin";

                        var send = $http.post(configs.userController, userData + "&action=" + action,
                            {
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            });
                        send.then(function (data) {
                            if (data.data.success == 0) {
                                alertify.error(data.data.msg);
                            } else if (!!data.data.id) {
                                location.href = "candidates/home.php";
                            }
                        });
                        return send;

                    }).error(function (err) {
                        $scope.error = err;
                    });
                }

                if (IN.User.isAuthorized()) {
                    getLinkedinData();
                } else {
                    IN.User.authorize(function (data) {
                        getLinkedinData();
                    }, function (data) {
                        console.log(data)
                    });
                }
            }

            $scope.linkedinLogout = function () {
                IN.User.logout(function () {

                }, function () {

                });
            }


            /*
             *
             * FACEBOOK LOGIN
             *
             * */
            //envia a requisição para o back end saber se é necessario cadastrar ou apenas logar o usuário
            $scope.facebookCadastro = function(userData, action){
                var send = $http.post(configs.userController, userData + "&action=" + action,
                    {
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    });
                send.then(function (data) {
                    if (data.data.success == 0) {
                        alertify.error(data.data.msg);
                    } else if (!!data.data.id) {
                        location.href = "candidates/home.php";
                    }
                });
                return send;
            }
            //abre a janela de permissões e realiza o login do facebook
            $scope.doLoginFacebook = function () {
                FB.login(function (response) {
                    if (response.status === 'connected') {

                        //Pega os dados do facebook e a foto
                        FB.api('/me?fields=id,name,email,permissions', function (response) {
                            FB.api('/me/picture?width=400&height=400', function (photo) {

                                var fbimage = photo.data.url;
                                fbimage = fbimage.replace("&", "%26");

                                //grava os dados do usuario no nosso banco
                                var userData = "email=" + response.email +
                                    "&nome=" + response.name +
                                    "&image_link="+ fbimage +
                                    "&facebook_id=" + response.id;

                                var action = "cadastrarFacebook";

                                $scope.facebookCadastro(userData, action)
                            })
                        });

                    } else {
                        toastr.error("Login facebook não autorizado!");
                    }
                    console.log(response);
                }, {scope: 'public_profile,email'});
            }

            //callback de status de login facebook
            $scope.statusChangeCallback = function (response) {
                console.log(response);
            }
            window.fbAsyncInit = function () {
                FB.init({
                    appId: '<?php if(DEBUG) echo FACEBOOK_DEBUG; else echo FACEBOOK_PROD; ?>',
                    xfbml: true,
                    version: 'v2.8'
                });
                FB.AppEvents.logPageView();

                FB.getLoginStatus(function (response) {
                    $scope.statusChangeCallback(response);
                });

            };

            //traz a API do facebook
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

            /*
             *
             * LOGIN GOOGLE+
             *
             * */
            $scope.clicked = false;
            $scope.doplus = function () {
                $scope.clicked = true;
            }
            $scope.$on('event:google-plus-signin-success', function (event, authResult) {
                if ($scope.clicked)
                    gapi.client.load('plus', 'v1', function () {
                        var request = gapi.client.plus.people.get({
                            'userId': 'me'
                        });
                        request.execute(function (resp) {

                            //grava os dados do usuario no nosso banco
                            var userData = "email=" + resp.emails[0].value +
                                "&nome=" + resp.displayName +
                                "&image_link="+ resp.image.url +
                                "&google_id=" + resp.id;

                            var action = "cadastrarGoogle";

                            var send = $http.post(configs.userController, userData + "&action=" + action,
                                {
                                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                                });
                            send.then(function (data) {
                                if (data.data.success == 0) {
                                    alertify.error(data.data.msg);
                                } else if (!!data.data.id) {
                                    location.href = "candidates/home.php";
                                }
                            });
                            return send;
                        });
                    });
            });
            $scope.$on('event:google-plus-signin-failure', function (event, authResult) {
                //alertify.error("Login GooglePLUS não autorizado!");
            });

            /*
             *
             * LOGIN TRADICIONAL
             *
             * */
            $scope.doLogin = function () {
                var formUser = $("#loginform").serialize();
                var action = "login";

                var send = $http.post(configs.userController, formUser + "&action=" + action,
                    {
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    });
                send.then(function (data) {
                    if (data.data.success == 0) {
                        alertify.error(data.data.msg);
                    } else if (!!data.data.id) {

                        location.href = "candidates/home.php";
                    }else{
                        alertify.error(data.data.erro);
                    }
                });
                return send;
            }
        })
    </script>
</head>

<body class="hold-transition login-page" ng-controller="loginController">
<div class="content_video">
    <div class="login-box">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#candidatos" data-toggle="tab">Candidatos</a></li>
                <li><a href="#empresas" data-toggle="tab">Empresas / HeadHunters</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="candidatos">
                    <div class="box box-primary">
                        <div class="login-logo">
                            <a><b>Hunters</b>SUMIFIT</a>
                        </div><!-- /.login-logo -->

                        <div class="login-box-body">
                            <p class="login-box-msg">Informe seu E-mail e Senha</p>
                            <form id="loginform" action="" method="post">

                                <div class="form-group has-feedback">
                                    <input name="email" id="email" type="email" class="form-control"
                                           placeholder="E-mail" required>
                                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                </div>

                                <div class="form-group has-feedback">
                                    <input name="senha" id="senha" type="password" class="form-control"
                                           placeholder="Senha" required>
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>

                                <div class="social-auth-links text-left">
                                    <b>Lembrar-me?</b>
                                    <a class="pull-right">
                                        <input id="switch-size" type="checkbox" name="lembrar" checked
                                               data-on-text="Sim" data-off-text="Não" data-size="mini">
                                    </a>
                                </div>

                                <div class="social-auth-links text-center">
                                    <a type="submit" class="btn btn-primary btn-block btn-flat"
                                            ng-click="doLogin()" promise-btn="">Entrar
                                    </a>
                                </div>

                            </form>

                            <div class="social-auth-links text-center">
                                <p>- OU -</p>
                                <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"
                                   ng-click="doLoginFacebook()"><i class="fa fa-facebook"></i>Entrar usando Facebook</a>
                                <div class="clearfix" style="height:5px"></div>
                                <google-plus-signin clientid="<?php if(DEBUG) echo GOOGLEPLUS_DEBUG; else echo GOOGLEPLUS_PROD; ?>"
                                                    autorender="false" customtargetid="google-plus-sigin">
                                    <a href="#" ng-click="doplus()" id="google-plus-sigin"
                                       class="btn btn-block btn-social btn-google btn-flat"><i
                                            class="fa fa-google-plus"></i>Entrar usando Google+</a>
                                </google-plus-signin>
                                <div class="clearfix" style="height:5px"></div>
                                <a href="#" class="btn btn-block btn-social btn-linkedin btn-flat"
                                   ng-click="doLoginLinkedin()"><i class="fa fa-linkedin"></i>Entrar usando Linkedin</a>
                            </div><!-- /.social-auth-links -->

                            <b>Esqueceu sua senha? </b><a href="recover_candidates.php">Clique aqui</a><br>
                            <b>Ainda não é cadastrado? </b><a href="register_candidates.html" class="text-center">Registre-se
                                aqui</a>

                        </div><!-- /.login-box-body -->
                    </div>
                </div>

                <div class="tab-pane" id="empresas">
                    <div class="box box-primary">
                        <div class="login-logo">
                            <a><b>Hunters</b>SUMIFIT</a>
                        </div><!-- /.login-logo -->

                        <div class="login-box-body">
                            <p class="login-box-msg">Informe seu E-mail e Senha</p>
                            <form action="companies/profile.html" method="post">

                                <div class="form-group has-feedback">
                                    <input type="email" class="form-control" placeholder="E-mail">
                                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                </div>

                                <div class="form-group has-feedback">
                                    <input type="password" class="form-control" placeholder="Senha">
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>

                                <div class="social-auth-links text-left">
                                    <b>Lembrar-me?</b>
                                    <a class="pull-right">
                                        <input id="switch-size" type="checkbox" name="lembrar" checked
                                               data-on-text="Sim" data-off-text="Não" data-size="mini">
                                    </a>
                                </div>

                                <div class="social-auth-links text-center">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                                </div>

                            </form>

                            <b>Esqueceu sua senha? </b><a href="recover_companies.html">Clique aqui</a><br>
                            <b>Ainda não é cadastrado? </b><a href="register_companies.html" class="text-center">Registre-se
                                aqui</a>

                        </div><!-- /.login-box-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<video id="my-video" class="video" poster="dist/videos/We-Work-We-Wait/snapshots/We-Work-We-Wait.jpg" autoplay loop>
    <!--<source src="dist/videos/media/demo.mp4" type="video/mp4">-->
    <!--<source src="dist/videos/Working-House/MP4/Working-House.mp4" type="video/mp4">-->
    <source src="dist/videos/We-Work-We-Wait/MP4/We-Work-We-Wait.mp4"  type="video/mp4">
</video>

<!-- jQuery 2.1.4 -->
<script src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- CheckBox-Switch-->
<script src="bootstrap/js/bootstrap-switch.js"></script>

<!--Start of Tawk.to Script - atendimento online SUMIFIT-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/57acd568b6326fb1504171b1/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->

</body>

</html>
