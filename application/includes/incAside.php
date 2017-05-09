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

            <li class="active"><a href="profile.php"><i class="fa fa-edit"></i> <span>Perfil</span></a></li>

            <li>
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