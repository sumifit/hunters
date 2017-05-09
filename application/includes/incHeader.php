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