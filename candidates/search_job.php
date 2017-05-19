<?php
ob_start();
session_start();

include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."application".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."bootstrap.php";

$arrayView = $_SESSION;
$view = new TemplateController($arrayView);
?>
<!DOCTYPE html>
<html ng-app="hunters">
<head>
    <meta charset="UTF-8">
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

    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">

    <!-- CheckBox-->
    <!-- Custom styles for this template -->
    <link href="../bootstrap/css/bootstrap-switch.css" rel="stylesheet">
    <script src="../node_modules/angular/angular.min.js"></script>
    <script src="../node_modules/angular-promise-buttons/dist/angular-promise-buttons.min.js"></script>


    <script src="../node_modules/angular-loading-bar/build/loading-bar.min.js"></script>
    <!-- google+ login -->
    <script src="../bower_components/angular-directive.g-signin/google-plus-signin.js"></script>

    <script src="../node_modules/alertify.js/dist/js/ngAlertify.js"></script>

    <script src="../dist/js/hunters.js"></script>
    <script>
        hunters.controller('searchJob', ['FormUtils','$scope', '$http', 'configs','alertify','randomize', function (FormUtils, $scope, $http, configs, alertify, randomize) {
            var getVagas = function(){
                var action = "listarVagas";

                var send = $http.post(configs.vagasController, "&action=" + action,
                    {
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    });
                send.then(function (data) {
                    if (data.data.success == 0) {
                        toastr.error(data.data.msg);
                    } else{
                        $scope.vagas = data.data.msg;
                        console.log($scope.vagas)
                    }
                });
                return send;
            }

            getVagas();
            function getEmpresas(){
                var action = "listarEmpresas";

                var send = $http.post(configs.vagasController, "action=" + action,
                    {
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    });

                send.then(function (data) {
                    if(data.data.success >= 1){
                        $scope.empresas = data.data.msg;
                    }
                    else toastr.error(data.data.msg);
                });
                return send;
            }
            getEmpresas();
            function getCargos(){
                var action = "listarCargos";

                var send = $http.post(configs.vagasController, "action=" + action,
                    {
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    });

                send.then(function (data) {
                    if(data.data.success >= 1){
                        $scope.cargos = data.data.msg;
                    }
                    else toastr.error(data.data.msg);
                });
                return send;
            }
            getCargos();
        }]);
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini" ng-controller="searchJob">
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
                                    <a ng-click="deslogar()" class="btn btn-default btn-flat">Sair</a>
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

                <li>
                    <a href="calendar.php">
                        <i class="fa fa-calendar"></i> <span>Agenda</span>
                        <small class="label pull-right bg-red">3</small>
                    </a>
                </li>

                <li>
                    <a href="../candidates/mailbox/mailbox.html">
                        <i class="fa fa-envelope"></i> <span>Caixa de Entrada</span>
                        <small class="label pull-right bg-aqua">4</small>
                    </a>
                </li>

                <li>
                    <a href="evaluation.php">
                        <i class="fa fa-book"></i> <span>Avaliação Técnica</span>
                        <small class="label pull-right bg-yellow">1</small>
                    </a>
                </li>

                <li class="active"><a href="search_job.php"><i class="fa fa-search"></i> <span>Pesquisa de Vagas</span></a>
                </li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Pesquisa de Vagas
                <small>Vagas Publicadas</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Pesquisa de Vagas</li>
                <li class="active">Vagas Publicadas</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <h3 class="profile-username text-left">Filtros</h3>
                            <ul class="list-group list-group-unbordered">

                                <li class="list-group-item">
                                    <select class="form-control empresas" multiple="multiple"
                                            data-placeholder="Empresas" style="width: 100%;" ng-cloak>
                                        <option ng-repeat="empresa in empresas">{{empresa.nome_fantasia}}</option>
                                    </select>
                                </li>

                                <li class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control pull-right"
                                               placeholder="Data da Vaga - De" id="data_envio">
                                        <span class="input-group-addon"><i class="fa fa-question-circle"
                                                                           data-toggle="tooltip" data-placement="bottom"
                                                                           title="Selecione o período de cadastramento da vaga."></i></span>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control pull-right"
                                               placeholder="Data da Vaga - Até" id="data_conclusao">
                                        <span class="input-group-addon"><i class="fa fa-question-circle"
                                                                           data-toggle="tooltip" data-placement="bottom"
                                                                           title="Selecione o período de cadastramento da vaga."></i></span>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control pull-right"
                                               placeholder="Data do Projeto - De" id="data_inicio">
                                        <span class="input-group-addon"><i class="fa fa-question-circle"
                                                                           data-toggle="tooltip" data-placement="bottom"
                                                                           title="Selecione a data de início do projeto."></i></span>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control pull-right"
                                               placeholder="Data do Projeto - Até" id="data_fim">
                                        <span class="input-group-addon"><i class="fa fa-question-circle"
                                                                           data-toggle="tooltip" data-placement="bottom"
                                                                           title="Selecione a date de fim do projeto."></i></span>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <select class="form-control cargos" multiple="multiple" data-placeholder="Cargos"
                                    style="width: 100%;">
                                        <option ng-repeat="(chave, valor) in cargos">{{valor.cargo}}</option>
                                    </select>
                                </li>

                                <li class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" class="form-control" placeholder="Local de Trabalho">
                                        <span class="input-group-addon"><i class="fa fa-question-circle"
                                                                           data-toggle="tooltip" data-placement="bottom"
                                                                           title="O local de trabalho."></i></span>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" class="form-control" placeholder="Palavra Chave">
                                        <span class="input-group-addon"><i class="fa fa-question-circle"
                                                                           data-toggle="tooltip" data-placement="bottom"
                                                                           title="Digite uma palavra chave para efetuar a pesquisa."></i></span>
                                    </div>
                                </li>


                                <li class="list-group-item">
                                    <b class="col-md-7" style="padding:0;">Projeto por tempo determinado</b>
                                    <a class="pull-right col-md-5">
                                        <input id="switch-size" type="checkbox" name="tempo_determinado"
                                               data-on-text="Sim" data-off-text="Não" data-size="mini">
                                    </a>
                                    <div class="clearfix"></div>
                                </li>

                                <li class="list-group-item">
                                    <b class="col-md-7" style="padding:0;">Projeto é Prorrogável</b>
                                    <a class="pull-right col-md-5">
                                        <input id="switch-size" type="checkbox" name="projeto_prorrogavel"
                                               data-on-text="Sim" data-off-text="Não" data-size="mini">
                                    </a>
                                    <div class="clearfix"></div>
                                </li>

                                <li class="list-group-item">
                                    <b class="col-md-7" style="padding:0;">Vaga para PCD</b>
                                    <a class="pull-right col-md-5">
                                        <input id="switch-size" type="checkbox" name="deficiente_fisico"
                                               data-on-text="Sim" data-off-text="Não" data-size="mini">
                                    </a>
                                    <div class="clearfix"></div>
                                </li>

                                <li class="list-group-item">
                                    <b class="col-md-7" style="padding:0;">O Horário é Alternativo</b>
                                    <a class="pull-right col-md-5">
                                        <input id="switch-size" type="checkbox" name="horário_alternativo"
                                               data-on-text="Sim" data-off-text="Não" data-size="mini">
                                    </a>
                                    <div class="clearfix"></div>
                                </li>

                                <li class="list-group-item">
                                    <b class="col-md-7" style="padding:0;">Oportunidade Home Office</b>
                                    <a class="pull-right col-md-5">
                                        <input id="switch-size" type="checkbox" name="home_office" data-on-text="Sim"
                                               data-off-text="Não" data-size="mini">
                                    </a>
                                    <div class="clearfix"></div>
                                </li>

                            </ul>
                            <a class="btn btn-primary btn-block"><b>Filtrar</b></a>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.box-body -->

                <div class="col-md-9">
                    <!-- TABLE: Movimentações -->
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="box-header with-border">
                                <h3 class="box-title">Resultado da Pesquisa</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">

                                <!-- Vagas -->
                                <div class="col-md-8" ng-repeat="vaga in vagas" ng-cloak>
                                    <div class="box box-widget widget-user-2">
                                        <div class="widget-user-header bg-aqua">
                                            <div class="widget-user-image">
                                                <img class="img-circle" style="width:64px; height:64px;" ng-src="{{vaga.empresa.image_link}}"
                                                     alt="User Avatar">
                                            </div><!-- /.widget-user-image -->
                                            <h3 class="widget-user-username">{{vaga.empresa.nome}}</h3>
                                            <h5 class="widget-user-desc">Consultora HeadHunter</h5>
                                        </div>

                                        <!-- Dados da Empresa/HeadHunter -->
                                        <div class="box-footer no-padding">
                                            <ul class="nav nav-stacked">
                                                <li></br></li>
                                                <li><h4><strong>Empresa:</strong> {{vaga.empresa.empresa[0].nome_fantasia}}</h4></li>
                                                <li><h4><strong>Vaga:</strong> {{vaga.cargo}}</h4></li>
                                                <li><h4><strong>Local de Trabalho:</strong> {{vaga.local_trabalho.cidade}} - {{vaga.local_trabalho.estado}}</h4></li>
                                                <li></br></li>
                                            </ul>
                                        </div>

                                        <!-- Dados da Vaga -->
                                        <div class="box box-solid">
                                            <div class="box-header with-border">
                                                <i class="fa fa-bullhorn"></i>
                                                <h3 class="box-title">Detalhamento da Vaga</h3>
                                            </div><!-- /.box-header -->
                                            <div class="box-body">
                                                <ul class="list-unstyled">

                                                    <li ng-if="vaga.requisitos_obrigatorios.flag"><strong>Requisitos Obrigatórios</strong></li>
                                                    <ul>
                                                        <li>{{vaga.requisitos_obrigatorios.requisitos}}
                                                        </li>
                                                        </br>
                                                    </ul>

                                                    <li ng-if="vaga.requisitos_desejaveis.flag"><strong>Requisitos Desejáveis</strong></li>
                                                    <ul>
                                                        <li>{{vaga.requisitos_desejaveis.requisitos}}
                                                        </li>
                                                        </br>
                                                    </ul>

                                                    <li ng-if="vaga.requisitos_desejaveis.flag"><strong>Requisitos Diferenciais</strong></li>
                                                    <ul>
                                                        <li>{{vaga.requisitos_diferenciais.requisitos}}
                                                        </li>
                                                        </br>
                                                    </ul>

                                                    <li ng-if="vaga.atividades_exercidas.flag"><strong>Atividades Exercidas</strong></li>
                                                    <ul>
                                                        <li>{{vaga.atividades_exercidas.atividades}}
                                                        </li>
                                                        </br>
                                                    </ul>

                                                    <div class="panel box box-primary">
                                                        <div class="box-header with-border">
                                                            <h4 class="box-title">
                                                                <a data-toggle="collapse" data-parent="#accordion"
                                                                   href="#detalhes1">
                                                                    Mais informações da vaga
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="detalhes1" class="panel-collapse collapse">
                                                            <div class="box-body">
                                                                <li ng-if="!!vaga.data_projeto_de"><strong>Início do Projeto</strong></li>
                                                                <ul ng-if="!!vaga.data_projeto_de">
                                                                    <li>{{vaga.data_projeto_de}}</li>
                                                                    </br>
                                                                </ul>

                                                                <li ng-if="!!vaga.data_projeto_para"><strong>Fim do Projeto</strong></li>
                                                                <ul ng-if="!!vaga.data_projeto_para">
                                                                    <li>{{vaga.data_projeto_para}}</li>
                                                                    </br>
                                                                </ul>

                                                                <li><strong>Projeto por tempo determinado?</strong></li>
                                                                <ul>
                                                                    <li ng-if="!!vaga.prj_tempoindeterminado.flag">Sim</li>
                                                                    <li ng-if="!vaga.prj_tempoindeterminado.flag">Não</li>
                                                                    <li ng-if="!!vaga.prj_tempoindeterminado.descricao">{{vaga.prj_tempoindeterminado.descricao}}</li>
                                                                    </br>
                                                                </ul>

                                                                <li><strong>Projeto é Prorrogável?</strong></li>
                                                                <ul>
                                                                    <li ng-if="!!vaga.prj_prorrogavel.flag">Sim</li>
                                                                    <li ng-if="!vaga.prj_prorrogavel.flag">Não</li>
                                                                    <li ng-if="!!vaga.prj_prorrogavel.descricao">{{vaga.prj_prorrogavel.descricao}}</li>
                                                                    <li ng-if="!vaga.prj_prorrogavel.flag"></li>
                                                                    </br>
                                                                </ul>

                                                                <li><strong>Vaga para PCD?</strong></li>
                                                                <ul>
                                                                    <li ng-if="!!vaga.vagas_pcd.flag">Sim</li>
                                                                    <li ng-if="!vaga.vagas_pcd.flag">Não</li>
                                                                    <li ng-if="!!vaga.vagas_pcd.descricao">{{vaga.vagas_pcd.descricao}}</li>
                                                                    </br>
                                                                </ul>

                                                                <li><strong>O Horário é Alternativo?</strong></li>
                                                                <ul>
                                                                    <li ng-if="!!vaga.horario_alternativo.flag">Sim</li>
                                                                    <li ng-if="!vaga.horario_alternativo.flag">Não</li>
                                                                    <li ng-if="!!vaga.horario_alternativo.descricao">{{vaga.horario_alternativo.descricao}}</li>
                                                                    </br>
                                                                </ul>

                                                                <li><strong>Oportunidade Home Office?</strong></li>
                                                                <ul>
                                                                    <li ng-if="!!vaga.home_office.flag">Sim</li>
                                                                    <li ng-if="!vaga.home_office.flag">Não</li>
                                                                    <li ng-if="!!vaga.home_office.descricao">{{vaga.home_office.descricao}}</li>
                                                                    </br>
                                                                </ul>

                                                                <li ng-if="!!vaga.beneficios"><strong>Benefícios</strong></li>
                                                                <ul>
                                                                    <li ng-if="!!vaga.beneficios">{{vaga.beneficios}}
                                                                    </li>
                                                                    </br>
                                                                </ul>

                                                                <li><strong>Forma de Contratação</strong></li>
                                                                <ul>
                                                                    <li>CLT Full; PJ</li>
                                                                    </br>
                                                                </ul>

                                                                <li><strong>Faixa Salarial</strong></li>
                                                                <ul>
                                                                    <li>De R$ {{vaga.faixasalarial[0]}} Até {{vaga.faixasalarial[1]}}</li>
                                                                    </br>
                                                                </ul>

                                                                <li><strong>Grau de Escolaridade </strong></li>
                                                                <ul>
                                                                    <li>Bacharel - Completo</li>
                                                                    </br>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </ul>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <button type="submit" class="btn btn-primary">
                                                                Candidatar-se
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div><!-- /.box-body -->
                                        </div><!-- /.box -->

                                    </div><!-- /.widget-user -->
                                </div><!-- /.col -->

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.box -->
                </div>

            </div><!-- /.box -->
        </section>

    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2016-<?php echo date('Y'); ?> <a href="http://www.sumifit.com/"> SumIFIT </a></strong> All rights reserved.
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
<!-- Select2 -->
<script src="../plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="../plugins/input-mask/jquery.inputmask.js"></script>
<script src="../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>

<script src="../bootstrap/js/bootstrap-switch.js"></script>

<link rel="stylesheet" href="../node_modules/toastr/build/toastr.min.css">
<script src="../node_modules/toastr/build/toastr.min.js"></script>

<!-- Page script -->
<script>
    $(function () {

        //Initialize Select2 Elements
        $(".cargos").select2();
        $(".empresas").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        $("[name='tempo_determinado']").bootstrapSwitch();
        $("[name='projeto_prorrogavel']").bootstrapSwitch();
        $("[name='deficiente_fisico']").bootstrapSwitch();
        $("[name='horário_alternativo']").bootstrapSwitch();
        $("[name='home_office']").bootstrapSwitch();

        $(function () {
            $('#pesquisa').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false
            });
        });

        //Date picker
        $('#data_envio').datepicker({
            autoclose: true
        });

        $('#data_conclusao').datepicker({
            autoclose: true
        });

        $('#data_expiracao').datepicker({
            autoclose: true
        });

        $('#data_inicio').datepicker({
            autoclose: true
        });

        $('#data_fim').datepicker({
            autoclose: true
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
            showInputs: false
        });

    });

</script>

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
