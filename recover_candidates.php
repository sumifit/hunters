<!DOCTYPE html>
<html ng-app="hunters">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Hunters | Recuperar Senha</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="google-signin-clientid" content="365560908295-koghokncubaessn558tef8g0m0pb0ngm">

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
		api_key:   78a31asbikx1we
		authorize: true
	</script>

	<script src="node_modules/angular/angular.min.js"></script>
	<script src="node_modules/angular-promise-buttons/dist/angular-promise-buttons.min.js"></script>
	<script src="node_modules/alertify.js/dist/js/ngAlertify.js"></script>
	<script src="node_modules/angular-loading-bar/build/loading-bar.min.js"></script>
	<!-- google+ login -->
	<script src="bower_components/angular-directive.g-signin/google-plus-signin.js"></script>

	<script src="dist/js/hunters.js"></script>
	<script>
		hunters.controller('recoverController', function ($scope, $http, configs, alertify) {
			$scope.dados = {};

			$scope.recover = function(){
				var email = $('#email').val();

				var userData = "email=" + email;
				var action = "recoverPass";

				var send = $http.post(configs.userController, userData + "&action=" + action,
					{
						headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					});
				send.then(function (data) {
					if (data.data.success == 0) {
						$scope.error = true;
						$scope.msg = data.data.msg;
					}else{
						$scope.success = true;
						$scope.msg = data.data.msg;
					}
				});
				return send;
			}
		})
	</script>
</head>

<body class="hold-transition register-page" ng-controller="recoverController">
	<div class="content_video">
		<div class="register-box">
			<div class="register-box-body">
				<div class="register-logo">
					<a><b>Hunters</b>SUMIFIT</a>
				</div>	
			
				<p class="login-box-msg">Informe o e-mail para recuperar sua senha</p>
				<form method="post">
					<span class="error" ng-show="error">{{msg}}</span>
					<span class="" ng-show="success">{{msg}}</span>
					<div class="form-group has-feedback">
						<input type="email" class="form-control" placeholder="Seu E-mail" id="email">
					</div>
										
					<div class="social-auth-links text-center">
						<a class="btn btn-primary btn-block btn-flat" ng-click="recover()">Recuperar Senha</a>
					</div>				
				</form>
				Ao clicar em "Recuperar Senha", será enviado um link de recuperação de senha para o e-mail informado acima. Siga o passo a passo e redefina sua senha.
			</div>
		</div>
	</div>

	<video id="my-video" class="video" autoplay loop>
	  <source src="dist/videos/We-Work-We-Wait/MP4/We-Work-We-Wait.mp4" type="video/mp4">
	</video> 	
	
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<!-- CheckBox-Switch-->
	<script src="bootstrap/js/bootstrap-switch.js"></script>
	
    <script>
	$("[name='termos_uso']").bootstrapSwitch();
	
	(function() {
	  /**
	   * Video element
	   * @type {HTMLElement}
	   */
	  var video = document.getElementById("my-video");

	  /**
	   * Check if video can play, and play it
	   */
	  video.addEventListener( "canplay", function() {
		video.play();
	  });
	})();  
    </script>

	<!--Start of Tawk.to Script - atendimento online SUMIFIT-->
	<script type="text/javascript">
	var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	(function(){
	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	s1.async=true;
	s1.src='https://embed.tawk.to/57acd568b6326fb1504171b1/default';
	s1.charset='UTF-8';
	s1.setAttribute('crossorigin','*');
	s0.parentNode.insertBefore(s1,s0);
	})();
	</script>
	<!--End of Tawk.to Script-->	
	
  </body>
</html>
