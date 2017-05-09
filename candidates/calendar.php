<?php

ob_start();
session_start();
require_once("../application/controllers/TemplateController.php");
$arrayView = $_SESSION;
$view = new TemplateController($arrayView);

?>
<!DOCTYPE html>
<html ng-app="hunters">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hunters - SumIFIT</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

    <!-- date picker -->
    <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">

    <!-- daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="../plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="../plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <!-- CheckBox-->
    <!-- Custom styles for this template -->
    <link href="../bootstrap/css/bootstrap-switch.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.print.css" media="print">

    <link rel="stylesheet" href="../dist/css/geral.css">
    <link rel="stylesheet" href="../node_modules/angular-loading-bar/build/loading-bar.min.css">

    <script src="../node_modules/angular/angular.min.js"></script>
    <script src="../node_modules/angular-promise-buttons/dist/angular-promise-buttons.min.js"></script>
    <script src="../node_modules/alertify.js/dist/js/ngAlertify.js"></script>
    <script src="../node_modules/angular-loading-bar/build/loading-bar.min.js"></script>
    <!-- google+ login -->
    <script src="../bower_components/angular-directive.g-signin/google-plus-signin.js"></script>

    <script src="../dist/js/hunters.js"></script>
    <script>
      hunters.controller('agendaController', ['FormUtils','$scope', '$http', 'configs', 'alertify', function (FormUtils, $scope, $http, configs, alertify) {

        $scope.random = function(){
          var cores = [
            "bg-yellow",
            "bg-aqua",
            "bg-light-blue",
            "bg-red",
            "bg-green"
          ];
          return cores[parseInt(Math.random()*5)];
        }

        $scope.toDate = function(dateString){
          var from = dateString.split("/");
          var date = new Date(from[2], from[1] - 1, from[0]);
          return date;
        }

        $scope.renderCalendar = function(){
          $(function () {

            /* initialize the external events
             -----------------------------------------------------------------*/
            function ini_events(ele) {
              ele.each(function () {

                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                  title: $.trim($(this).text()) // use the element's text as the event title
                };

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject);

                // make the event draggable using jQuery UI
                $(this).draggable({
                  zIndex: 1070,
                  revert: true, // will cause the event to go back to its
                  revertDuration: 0  //  original position after the drag
                });

              });
            }
            ini_events($('#external-events div.external-event'));

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date();
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();

            $('#calendar').fullCalendar({
              header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
              },
              buttonText: {
                today: 'Hoje',
                month: 'Mês',
                week: 'Semana',
                day: 'Dia'
              },
              //Random default events
              events: $scope.events,
              editable: true,
              droppable: true, // this allows things to be dropped onto the calendar !!!
              drop: function (date, allDay) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');

                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);

                // assign it the date that was reported
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;
                copiedEventObject.backgroundColor = $(this).css("background-color");
                copiedEventObject.borderColor = $(this).css("border-color");

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                  // if so, remove the element from the "Draggable Events" list
                  $(this).remove();
                }

              }
            });

            /* ADDING EVENTS */
            var currColor = "#3c8dbc"; //Red by default
            //Color chooser button
            var colorChooser = $("#color-chooser-btn");
            $("#color-chooser > li > a").click(function (e) {
              e.preventDefault();
              //Save color
              currColor = $(this).css("color");
              //Add color effect to button
              $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
            });
            $("#add-new-event").click(function (e) {
              e.preventDefault();
              //Get value and make sure it is not null
              var val = $("#new-event").val();
              if (val.length == 0) {
                return;
              }

              //Create events
              var event = $("<div />");
              event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
              event.html(val);
              $('#external-events').prepend(event);

              //Add draggable funtionality
              ini_events(event);

              //Remove event from text input
              $("#new-event").val("");
            });
          });
        }

        $scope.getAgendaGeral = function () {
          var action = "getEventos";

          var send = $http.post(configs.agendaController, "action=" + action,
              {
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
              });

          send.then(function (data) {
            if (data.data.success == 0) {
              $scope.renderCalendar();

              setTimeout(function () {
                $scope.getAgendaGeral();
              }, 3000);
            } else {
              $scope.agenda = data.data.msg;

              $scope.events = [];

              for(i in $scope.agenda){
                $scope.agenda[i].cor = $scope.random();
              }

              var date = new Date();
              var d;
              var df;

              for(i in $scope.agenda){
                d = $scope.toDate($scope.agenda[i].data_evento);
                df = $scope.toDate($scope.agenda[i].data_final_evento);

                $scope.events.push({
                  title:$scope.agenda[i].evento,
                  start:d,
                  end:df,
                  className:$scope.agenda[i].cor
                })
              }

              $scope.renderCalendar();


            }
          })
        }

        $scope.getDadosUsuario = function () {
          //pega os dados gerais
          $http({
            method: 'POST',
            url: configs.userController,
            data: "action=getUsuarioData",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          }).then(function (data) {
            if (data.data.success == 0) {
              alertify.error(data.data.msg);
              setTimeout(function () {
                $scope.getDadosUsuario();
              }, 3000);
            } else {
              $scope.dadosUsuario = data.data.msg;
            }
          });
        }

        $scope.getDadosUsuario();
        $scope.getAgendaGeral();

      }])
    </script>
  </head>
  <body class="hold-transition skin-blue sidebar-mini" ng-controller="agendaController">
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="home.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>H</b>SMF</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Hunters</b>SUMIFIT</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation - <?= $view->firstName($view->__get("nome")); ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"></a>
              </li>

              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img actual-src="{{dadosUsuario.image_link}}" ng-src="../dist/img/avatar_padrao.png"
                       class="user-image" alt="User Image" ng-cloak>
                  <span class="hidden-xs"><?= $view->firstName($view->__get("nome")); ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img actual-src="{{dadosUsuario.image_link}}" ng-src="../dist/img/avatar_padrao.png"
                         class="img-circle" alt="User Image" ng-cloak>
                    <p>
                      <?= $view->firstName($view->__get("nome")); ?> <span
                          ng-if="!!cargo_atual">-</span> {{cargo_atual}}
                      <small ng-if="fraseMembroDesde">{{fraseMembroDesde}}</small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="profile.php" class="btn btn-default btn-flat">Perfil</a>
                    </div>
                    <div class="pull-right">
                      <a href="../login.php" class="btn btn-default btn-flat">Sair</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">MENU</li>

                    <li>
                        <a href="home.php">
                            <i class="fa fa-home"></i> <span>Home</span>
                        </a>
                    </li>

                    <li><a href="profile.php"><i class="fa fa-edit"></i> <span>Perfil</span></a></li>

                    <li class="active">
                        <a href="calendar.php">
                            <i class="fa fa-calendar"></i> <span>Agenda</span>
                            <small class="label pull-right bg-red" ng-cloak>{{qtdAgenda}}</small>
                        </a>
                    </li>

                    <li>
                        <a href="../candidates/mailbox/mailbox.html">
                            <i class="fa fa-envelope"></i> <span>Caixa de Entrada</span>
                            <small class="label pull-right bg-aqua" ng-cloak>{{qtdCaixa}}</small>
                        </a>
                    </li>

                    <li>
                        <a href="evaluation.html">
                            <i class="fa fa-book"></i> <span>Avaliação Técnica</span>
                            <small class="label pull-right bg-yellow" ng-cloak>{{qtdAvaliacao}}</small>
                        </a>
                    </li>

                    <li><a href="search_job.html"><i class="fa fa-search"></i> <span>Pesquisa de Vagas</span></a></li>

                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Agenda
          </h1>
          <ol class="breadcrumb">
            <li><a href="home.php"><i class="fa fa-home"></i><b> Home</b></a></li>
            <li class="active">Agenda</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h4 class="box-title">Eventos Agendados</h4>
                </div>
                <div class="box-body">
                  <!-- the events -->
                  <div id="external-events">
                    <div class="external-event {{evento.cor}}" ng-repeat="evento in agenda" ng-cloak>{{evento.evento}} - Com Aline Paiva</div>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
              
            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-body no-padding">
                  <!-- THE CALENDAR -->
                  <div id="calendar"></div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2016-2016 <a href="http://www.sumifit.com/"> SumIFIT </a></strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-user bg-yellow"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                    <p>New phone +1(800)555-1234</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                    <p>nora@example.com</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-file-code-o bg-green"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                    <p>Execution time 5 seconds</p>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Update Resume
                    <span class="label label-success pull-right">95%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Laravel Integration
                    <span class="label label-warning pull-right">50%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Back End Framework
                    <span class="label label-primary pull-right">68%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Other sets of options are available
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div><!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked>
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right">
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Slimscroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="../plugins/fullcalendar/fullcalendar.min.js"></script>
    <!-- Page specific script -->
    <script>

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
