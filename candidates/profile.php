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
    <!-- CheckBox-->
    <!-- Custom styles for this template -->
    <link href="../bootstrap/css/bootstrap-switch.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/geral.css">
    <link rel="stylesheet" href="../node_modules/angular-loading-bar/build/loading-bar.min.css">

    <script src="../node_modules/angular/angular.min.js"></script>
    <script src="../node_modules/angular-promise-buttons/dist/angular-promise-buttons.min.js"></script>


    <script src="../node_modules/angular-loading-bar/build/loading-bar.min.js"></script>
    <!-- google+ login -->
    <script src="../bower_components/angular-directive.g-signin/google-plus-signin.js"></script>

    <script src="../node_modules/alertify.js/dist/js/ngAlertify.js"></script>

    <script src="../dist/js/hunters.js"></script>
    <style>
        .modal.modal-wide .modal-dialog {
            width: 80%;
        }
        .modal-wide .modal-body {
            overflow-y: auto;
        }

        /* irrelevant styling */
        #tallModal .modal-body p { margin-bottom: 900px }
    </style>
    <script>
        hunters.controller('usuarioController', ['FormUtils','$scope', '$http', 'configs','alertify','randomize', function (FormUtils, $scope, $http, configs, alertify, randomize) {
            $scope.dadosPessoais = {};
            $scope.cores = [
                "label-info",
                "label-warning",
                "label-danger",
                "label-success",
                "label-primary",
                "label-default"
            ];

            //pega os dados das tabelas de dominio
            function getDominioData(){

                var action = "getDominioData";

                var send = $http.post(configs.userController, "&action=" + action,
                    {
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    });
                send.then(function (data) {
                    if (data.data.success == 0) {
                        toastr.error(data.data.msg);
                    } else{
                        $scope.dominios = data.data.msg;
                        console.log($scope.dominios)

                        $scope.formGrauEscolaridade = "Carregando...";
                        setTimeout(function(){
                            var itensOrdenados = $('#nacionalidadeCandidato option').sort(function (a, b) {
                                return a.text < b.text ? -1 : 1;
                            });

                            $('#nacionalidadeCandidato').html(itensOrdenados);
                            $scope.dadosPessoais.nacionalidade = !!$scope.dadosUsuario.candidato.nacionalidade ? $scope.dadosUsuario.candidato.nacionalidade : "";

                            $scope.formGrauEscolaridade = $scope.dominios.escolaridade[0].grau_escolaridade;
                        }, 1000);
                    }
                });
                return send;
            }

            //Pega os dados de dominio do sistema
            getDominioData();

            $("#cepCandidato").focusout(function(){
                if(FormUtils.vnumber11($(this))){
                    FormUtils.setValid($(this));
                    $http.get("https://viacep.com.br/ws/"+$(this).val()+"/json/")
                        .then(function(data) {

                            if(!!data.data.erro){
                                $('#cidadeCandidato').removeAttr('readonly').val("");
                                $('#enderecoCandidato').removeAttr('readonly').val("");
                                $('#bairroCandidato').removeAttr('readonly').val("");
                                $('#estadoCandidato').removeAttr('readonly').val("");
                                $('#numeroCandidato').val("");
                                $('#complementoCandidato').val("");
                            }
                            $scope.dadosPessoais.cidade = data.data.localidade;
                            $scope.dadosPessoais.endereco = data.data.logradouro;
                            $scope.dadosPessoais.bairro = data.data.bairro;
                            $scope.dadosPessoais.estado = (function(){
                                for(i in $scope.dominios.estados){
                                    if(data.data.uf == $scope.dominios.estados[i].uf) return $scope.dominios.estados[i].estado;
                                }
                            }());
                            $scope.dadosPessoais.pais = "Brasil";
                        })
                }else {
                    $(this).addClass('invalidInput');
                    $(this).parent().parent().find('.error').css('display', 'block');
                }
            });

            $scope.enviarDadosPessoais = function () {
                //validações
                //vtext1

                var contErrors = 0;
                var elem;

                elem = $('#nomeCandidato');
                if(!FormUtils.vtext1(elem)){
                    FormUtils.setInvalid(elem);
                    contErrors++
                }else FormUtils.setValid(elem);

                //vtext1 nome mãe
                if(!FormUtils.vtext1($('#nomeMaeCandidato'))){
                    FormUtils.setInvalid($('#nomeMaeCandidato'));
                    contErrors++
                }else FormUtils.setValid($('#nomeMaeCandidato'));

                //vdate 5 e 6 data nascimento
                if(!FormUtils.vdate5($('#dataNascimentoCandidato')) && !FormUtils.vdate6($('#dataNascimentoCandidato'))){
                    FormUtils.setInvalid($('#dataNascimentoCandidato'));
                    contErrors++
                }else FormUtils.setValid($('#dataNascimentoCandidato'));

                //vnumber 16 telefone
                if( !FormUtils.vnumber16($('#telefoneCandidato'),10) ){

                    FormUtils.setInvalid($('#telefoneCandidato'));
                    contErrors++

                }else FormUtils.setValid($('#telefoneCandidato'));

                //vnumber 16 celular
                if( !FormUtils.vnumber16($('#celularCandidato'),11) ){

                    FormUtils.setInvalid($('#celularCandidato'));
                    contErrors++

                }else FormUtils.setValid($('#celularCandidato'));

                //vdate5
                if(!FormUtils.vdate5($("#dataExpCandidato"))){
                    FormUtils.setInvalid($("#dataExpCandidato"));
                    contErrors++
                }else FormUtils.setValid($('#dataExpCandidato'));

                //vnumber
                if(!FormUtils.validarCpf($("#CPFCandidato").val())){
                    FormUtils.setInvalid($("#CPFCandidato"));
                    contErrors++
                }else FormUtils.setValid($('#CPFCandidato'));

                //vnumber
                if(!FormUtils.vnumber11($("#cepCandidato"))){
                    FormUtils.setInvalid($("#cepCandidato"));
                    contErrors++
                }else FormUtils.setValid($('#cepCandidato'));

                if(FormUtils.validarRequireds($("#formDadosPessoais"))) contErrors++;

                if(contErrors >= 1){
                    toastr.error('Os campos com * são obrigatórios');
                    return false;
                }

                var formUser = $("#formDadosPessoais").serialize()+"&dados[pcd]="+$("#pcd").bootstrapSwitch('state');
                var action = "atualizarDadosPessoais";

                var send = $http.post(configs.userController, formUser + "&action=" + action,
                    {
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    });
                send.then(function (data) {
                    if(data.data.success >= 1) toastr.success('Dados gravados com sucesso', 'success');
                    else toastr.error('Não foi possivel salvar os dados, tente novamente');
                });
                return send;
            }

            $scope.pushFormacaoAcademica = function () {

                var contErrors = 0;

                if(!FormUtils.vdate5($('#dataConclusaoAcademica'))){
                    FormUtils.setInvalid($('#dataConclusaoAcademica'));
                    contErrors++
                }else FormUtils.setValid($('#dataConclusaoAcademica'));

                if(FormUtils.validarRequireds($("#formacaoAcademicaForm"))) contErrors++

                if(contErrors >= 1){
                    toastr.error('Os campos com * são obrigatórios');
                    return false;
                }


                var formUser = $("#formacaoAcademicaForm").serialize();
                var action = "pushFormacaoAcademica";

                var send = $http.post(configs.userController, formUser + "&action=" + action,
                    {
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    });

                send.then(function (data) {
                    $scope.getDadosUsuario();
                    if(data.data.success >= 1) toastr.success('Dados gravados com sucesso');
                    else {
                        toastr.error(data.data.msg);
                    }
                })
                return send;
            }

            $scope.pushExperienciaProfissional = function () {

                var contErrors = 0;
                if(FormUtils.validarRequireds($("#experienciaProfissionalForm"))) contErrors++;

                //vdate 5 e 6 data nascimento
                if(!FormUtils.vdate5($('#inicioExp'))){
                    FormUtils.setInvalid($('#inicioExp'));
                    contErrors++
                }else FormUtils.setValid($('#inicioExp'));

                if(FormUtils.validarRequireds($("#experienciaProfissionalForm"))) contErrors++;

                if(contErrors >= 1){
                    toastr.error('Os campos com * são obrigatórios');
                    return false;
                }

                var formUser = $("#experienciaProfissionalForm").serialize();
                var action = "pushExperienciaProfissional";

                var send = $http.post(configs.userController, formUser + "&action=" + action,
                    {
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    });

                send.then(function (data) {
                    $scope.getDadosUsuario();
                    if(data.data.success >= 1) toastr.success('Dados gravados com sucesso');
                    else toastr.error(data.data.msg);
                });
                return send;
            }
            $scope.pushCertificacoes = function () {

                var contErrors = 0;
                if(FormUtils.validarRequireds($("#certificacoesForm"))) contErrors++;

                //vdate 5 e 6 data nascimento
                if(!FormUtils.vdate5($('#dataConclusaoCert'))){
                    FormUtils.setInvalid($('#dataConclusaoCert'));
                    contErrors++
                }else FormUtils.setValid($('#dataConclusaoCert'));

                if(FormUtils.validarRequireds($("#certificacoesForm"))) contErrors++;

                if(contErrors >= 1){
                    toastr.error('Os campos com * são obrigatórios');
                    return false;
                }

                var formUser = $("#certificacoesForm").serialize();
                var action = "pushCertificacoes";

                var send = $http.post(configs.userController, formUser + "&action=" + action,
                    {
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    });

                send.then(function (data) {
                    $scope.getDadosUsuario();
                    if(data.data.success >= 1) toastr.success('Dados gravados com sucesso');
                    else toastr.error(data.data.msg);
                });
                return send;
            }

            $scope.pushExtraCurriculares = function () {

                var contErrors = 0;
                if(FormUtils.validarRequireds($("#extraCurriculares"))) contErrors++;

                //vdate 5 e 6 data conslusão
                if(!FormUtils.vdate5($('#dataConclusaoExtra'))){
                    FormUtils.setInvalid($('#dataConclusaoExtra'));
                    contErrors++
                }else FormUtils.setValid($('#dataConclusaoExtra'));

                if(FormUtils.validarRequireds($("#extraCurriculares"))) contErrors++;

                if(contErrors >= 1){
                    toastr.error('Os campos com * são obrigatórios');
                    return false;
                }

                var formUser = $("#extraCurriculares").serialize();
                var action = "pushExtraCurriculares";

                var send = $http.post(configs.userController, formUser + "&action=" + action,
                    {
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    });

                send.then(function (data) {
                    $scope.getDadosUsuario();
                    if(data.data.success >= 1) toastr.success('Dados gravados com sucesso');
                    else toastr.error(data.data.msg);
                });
                return send;
            }

            $scope.pushOutros = function () {
                $("#youtubeOutros").val($("#youtubeOutros").val().replace("watch?v=", "embed/"));

                var formUser = $("#outrasInformacoesForm").serialize();
                var action = "pushOutrasFormacoes";

                var send = $http.post(configs.userController, formUser + "&action=" + action,
                    {
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    });

                send.then(function (data) {
                    $scope.getDadosUsuario();
                    if(data.data.success >= 1) toastr.success('Dados gravados com sucesso');
                    else toastr.error(data.data.msg);
                });
                return send;
            }

            $scope.addIdioma = function (idioma, nivel) {
                if(FormUtils.validarRequireds($("#idiomascontainer"))) return false;

                var action = "pushSubArray";
                var formIdioma = "dados[idioma]=" + idioma
                    + "&dados[nivel]=" + nivel
                    + "&subArrayName=idiomas"
                    + "&action=" + action;

                var send = $http.post(configs.userController, formIdioma, {
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                });

                send.then(function (data) {
                    $scope.getDadosUsuario();
                    if(data.data.success >= 1) toastr.success('Dados gravados com sucesso');
                    else toastr.error(data.data.msg);
                });
                return send;
            }

            $scope.addTrabVoluntarios = function (organizacao, causas, cargo, inicio, fim, boolAtual) {

                var contErrors = 0;

                if(FormUtils.validarRequireds($("#trabalhos_voluntarios"))) contErrors++;

                //vdate 5 e 6 data nascimento
                if(!FormUtils.vdate15(new Date($('#inicio').val()), new Date($('#fim').val()))){
                    FormUtils.setInvalid($('#inicio'));
                    contErrors++
                }else FormUtils.setValid($('#inicio'));

                if(FormUtils.validarRequireds($("#experienciaProfissionalForm"))) contErrors++;

                if(contErrors >= 1){
                    toastr.error('Os campos com * são obrigatórios');
                    return false;
                }

                var action = "pushSubArray";
                var formIdioma = "dados[organizacao]=" + organizacao
                    + "&dados[causas]=" + causas
                    + "&dados[inicio]=" + inicio
                    + "&dados[fim]=" + fim
                    + "&dados[cargo]=" + cargo
                    + "&subArrayName=voluntarios"
                    + "&action=" + action;

                var send = $http.post(configs.userController, formIdioma, {
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                });

                send.then(function (data) {
                    $scope.getDadosUsuario();
                    if(data.data.success >= 1) toastr.success('Dados gravados com sucesso');
                    else toastr.error(data.data.msg);
                });
                return send;
            }

            //Exclui um subarray da formação academica
            $scope.pullFormacaoAcademica = function (argumento) {
                alertify.okBtn("Sim")
                    .cancelBtn("Não")
                    .confirm(configs.msgExcluir, function () {

                        var action = "pullFormacaoAcademica";
                        var cursando = (function(){
                            if(!argumento.cursando) return "";
                            else return "&argument[cursando]=" + argumento.cursando;
                        }());
                        var data_conclusao = (function(){
                            if(!!argumento.data_conclusao) return "&argument[data_conclusao]=" + argumento.data_conclusao;
                            else return "";
                        })();

                        var formFormacaoAcademica = "argument[instituicao]=" + argumento.instituicao
                            + "&argument[grau_escolaridade]=" + argumento.grau_escolaridade
                            + "&argument[curso]=" + argumento.curso
                            + data_conclusao
                            + cursando
                            + "&argument[descricao]=" + argumento.descricao
                            + "&action=" + action;

                        var send = $http.post(configs.userController, formFormacaoAcademica, {
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        });

                        send.then(function (data) {
                            $scope.getDadosUsuario();
                            if(data.data.success >= 1) toastr.success('Excluído com sucesso');
                            else toastr.error(data.data.msg);
                        });
                        return send;
                    }, function () {
                        // user clicked "cancel"
                    });
            }
            $scope.pullMongo = function (argumento, documento) {
                alertify.okBtn("Sim")
                    .cancelBtn("Não")
                    .confirm(configs.msgExcluir, function () {

                        var action = "pullMongo";
                        var formFormacaoAcademica = "argument=" + angular.toJson(argumento)
                            + "&action=" + action
                            + "&documento=" + documento;

                        var send = $http.post(configs.userController, formFormacaoAcademica, {
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        });

                        send.then(function (data) {
                            $scope.getDadosUsuario();
                        });
                        return send;
                    }, function () {
                        // user clicked "cancel"
                    });
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
                        toastr.error(data.data.msg);
                        setTimeout(function () {
                            $scope.getDadosUsuario();
                        }, 3000);
                    } else {
                        $scope.dadosUsuario = data.data.msg;

                        var data = [];

                        if(!!$scope.dadosUsuario.experiencia_profissional){
                            for(i in $scope.dadosUsuario.experiencia_profissional){
                                if(!!$scope.dadosUsuario.experiencia_profissional[i].cargo_atual){
                                    $scope.cargo_atual = $scope.dadosUsuario.experiencia_profissional[i].cargo;
                                    return false;
                                }
                            }
                        }
                        $("#pcd").bootstrapSwitch('state', ($scope.dadosUsuario.pcd == 'true'));
                        $("#boolCursandoAcademica").bootstrapSwitch();

                        /*
                         * Função para trabalhar a lógica de completo != cursando
                         * */
                        function chaveiaFormacao(){
                            if($("#grauAcademico").val().indexOf("- Completo") != -1){
                                $("#boolCursandoAcademica").bootstrapSwitch("state",false);
                                $("#boolCursandoAcademica").bootstrapSwitch("toggleDisabled",true,true);
                                $("#dataConclusaoAcademica").removeAttr("disabled");
                                $("#dataConclusaoAcademica").attr("required", "required");
                            }else{
                                $("#boolCursandoAcademica").bootstrapSwitch("disabled",false);
                                $("#dataConclusaoAcademica").attr("disabled", "disabled");
                                $("#dataConclusaoAcademica").val("");
                                $("#dataConclusaoAcademica").removeAttr("required");
                            }
                        }

                        $("#boolCursandoAcademica").on('switchChange.bootstrapSwitch', function (event, state) {
                            if (!state && $("#grauAcademico").val().indexOf("- Completo") != -1) {
                                $("#dataConclusaoAcademica").removeAttr("disabled");
                            } else {
                                $("#dataConclusaoAcademica").attr("disabled", "disabled");
                                $("#dataConclusaoAcademica").val("");
                            }
                        });
                        $("#grauAcademico").change(function(){
                            chaveiaFormacao();
                        });
                        //chama a função para pega ro que já está selecionado
                        chaveiaFormacao();
                    }
                });
            }

            $scope.getFlags = function () {
                //pega os dados gerais
                $http({
                    method: 'POST',
                    url: configs.userController,
                    data: "action=getFlags",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function (data) {

                    if (data.data.success == 0) {

                        toastr.error(data.data.msg);

                    } else {

                        $scope.flags = data.data.msg;

                        for(i in $scope.flags){
                            value = ($scope.flags[i] == "true");
                            $("#"+i).bootstrapSwitch('state', value);
                        }

                        //insere as flags ao mudar o state de qualquer uma
                        $('#receber_proposta, #proposta_curto_prazo, #home_office, #horario_alternativo, #disponivel_viagens, #fumante, #receber_notificacoes').on('switchChange.bootstrapSwitch', function (e, data) {
                            $scope.insertFlags();
                        });

                    }

                });
            }

            $scope.insertFlags = function(){
                var flags = 'dados[receber_proposta]='+$("#receber_proposta").bootstrapSwitch('state')+
                    '&dados[proposta_curto_prazo]='+$("#proposta_curto_prazo").bootstrapSwitch('state')+
                    '&dados[home_office]='+$("#home_office").bootstrapSwitch('state')+
                    '&dados[horario_alternativo]='+$("#horario_alternativo").bootstrapSwitch('state')+
                    '&dados[disponivel_viagens]='+$("#disponivel_viagens").bootstrapSwitch('state')+
                    '&dados[fumante]='+$("#fumante").bootstrapSwitch('state')+
                    '&dados[receber_notificacoes]='+$("#receber_notificacoes").bootstrapSwitch('state')

                var action = "pushFlags";
                var formFlags = flags
                    + "&action=" + action;

                var send = $http.post(configs.userController, formFlags, {
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                });

                send.then(function (data) {
                    if(data.data.success == 0) toastr.error("Problema de conexão, tente novamente");
                });
                return send;
            }

            $scope.getDadosUsuario();
            $scope.getFlags();

            /*
            * Função que seta os dados para preparar a edição da formação academica
            * */
            $scope.setFormacaoEditable = function(formacao){
                $scope.flagAlteracao = true;
                $("#cursando").bootstrapSwitch('state', !!formacao.cursando);
                console.log(formacao);
                $("#instituicaoAcademica").focus();
                $("#instituicaoAcademica").val(formacao.instituicao);
                $("#grauAcademico").val(formacao.grau_escolaridade);
                $("#cursoAcademico").val(formacao.curso);
                $("#dataConclusaoAcademica").val(formacao.data_conclusao);
                $("#descricaoAcademica").val(formacao.descricao);
                $("#boolCursandoAcademica").bootstrapSwitch('state', !!formacao.data_conclusao);
            };
            $scope.cancelFormacaoEditable = function(){
                $scope.flagAlteracao = false;
                $("#instituicaoAcademica").val('');
                $("#cursoAcademico").val('');
                $("#dataConclusaoAcademica").val('');
                $("#descricaoAcademica").val('');
                $("#boolCursandoAcademica").bootstrapSwitch('state', false);
            };

            $scope.cancelExperienciaEditable = function(){
                $scope.flagAlteracaoExperiencia = false;
                $("#instituicaoAcademica").val('');
            };

            $scope.setExperienciaEditable = function(experiencia){
                $scope.flagAlteracaoExperiencia = true;
                console.log(experiencia);
                $("#empresaExp").focus();
                $("#empresaExp").val(experiencia.empresa);
                $("#localidadeExp").val(experiencia.localidade);
                $("#segmentoExp").val(experiencia.segmento);
                $("#cargoExp").val(experiencia.cargo);
                $("#inicioExp").val(experiencia.data_inicio);
                //$("#fimExp").val(experiencia.data_inicio);
                $("#boolCargoAtualExp").val('state', !!experiencia.cargo_atual);
                $("#formaExp").val(experiencia.forma_contratacao);
                $("#pretensaoExp").val(experiencia.ultimo_salario);
                $("#websiteExp").val(experiencia.website);
            };

            $(function () {
                //Initialize Select2 Elements
                $(".select2").select2();

                //Datemask dd/mm/yyyy
                $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                //Datemask2 mm/dd/yyyy
                $("#datemask2").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                //Money Euro
                $("[data-mask]").inputmask();

                //Date range picker
                $('#reservation').daterangepicker();
                $('#reservation1').daterangepicker();
                $('#reservation2').daterangepicker();
                $('#reservation3').daterangepicker();
                $('#reservation4').daterangepicker();
                $('#reservation5').daterangepicker();
                $('#reservation6').daterangepicker();
                $('#reservation7').daterangepicker();
                $('#reservation8').daterangepicker();
                $('#reservation9').daterangepicker();
                //Date range picker with time picker
                $('#reservationtime').daterangepicker({
                    timePicker: true,
                    timePickerIncrement: 30,
                    format: 'MM/DD/YYYY h:mm A'
                });
                //Date range as a button
                $('#daterange-btn').daterangepicker(
                    {
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                        startDate: moment().subtract(29, 'days'),
                        endDate: moment()
                    },
                    function (start, end) {
                        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    }
                );

                $(".bootstrapSwitch").bootstrapSwitch();

                //Date picker
                $('.datepicker').datepicker({language: 'pt-BR'});

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass: 'iradio_minimal-blue'
                });
                //Red color scheme for iCheck
                $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                });
                //Flat red color scheme for iCheck
                $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
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

            //Controla o input de PCD no cadastro de dados pessoais
            $("#pcd").on('switchChange.bootstrapSwitch', function (event, state) {
                if (!state) {
                    $("#pcd_motivo").attr("disabled", "disabled");
                } else {
                    $("#pcd_motivo").removeAttr("disabled");
                }
            });
            //$("#fimExp").attr("disabled", "disabled");


            $("#boolCargoAtualExp").on('switchChange.bootstrapSwitch', function (event, state) {
                if (!state) {
                    $("#fimExp").removeAttr("disabled");
                } else {
                    $("#fimExp").attr("disabled", "disabled");
                }
            });

            $scope.limitaTamanho = function(modelo){
                modelo = new String(modelo);
            }

            $("#telefoneCandidato").keydown(function(){
                if($(this).val() == '') $(this).inputmask({"mask": "(099) 9999-9999"});
            });
            $("#celularCandidato").keydown(function(){
                if($(this).val() == '') $(this).inputmask({"mask": "(099) 99999-9999"});
            });

        }]);
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini" ng-controller="usuarioController">
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
    <!-- ASIDE -->
    <?= $view->render("incAside.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Perfil
            </h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home"></i> <b>Home</b></a></li>
                <li class="active">Perfil</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle" width="100px" height="100px" actual-src="{{dadosUsuario.image_link}}" ng-src="../dist/img/avatar_padrao.png"
                                 alt="User profile picture" ng-cloak>
                            <h3 class="profile-username text-center"><?= $view->__get("nome"); ?></h3>
                            <p class="text-muted text-center" ng-cloak>{{cargo_atual}}</p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Consultores que viram seu perfil</b> <a class="pull-right">322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Vagas no seu perfil</b> <a class="pull-right">543</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Vagas em aberto</b> <a class="pull-right">13.287</a>
                                </li>

                                <li class="list-group-item">
                                    <b>Deseja receber novas propostas de emprego?</b>
                                    <a class="pull-right">
                                        <input type="checkbox"
                                               class="bootstrapSwitch"
                                               data-on-text="Sim" data-off-text="Não" data-size="mini" id="receber_proposta" value="true">
                                    </a>
                                </li>

                                <li class="list-group-item">
                                    <b>Deseja receber propostas de curto prazo?</b>
                                    <a class="pull-right">
                                        <input type="checkbox" class="bootstrapSwitch"
                                               data-on-text="Sim" data-off-text="Não" data-size="mini" id="proposta_curto_prazo" value="true">
                                    </a>
                                </li>

                                <li class="list-group-item">
                                    <b>Aceita propostas para trabalhos Home Office?</b>
                                    <a class="pull-right">
                                        <input type="checkbox" class="bootstrapSwitch" data-on-text="Sim"
                                               data-off-text="Não" data-size="mini" id="home_office" value="true">
                                    </a>
                                </li>

                                <li class="list-group-item">
                                    <b>Aceita propostas de horários alternativos?</b>
                                    <a class="pull-right">
                                        <input type="checkbox" class="bootstrapSwitch"
                                               data-on-text="Sim" data-off-text="Não" data-size="mini" id="horario_alternativo" value="true">
                                    </a>
                                </li>

                                <li class="list-group-item">
                                    <b class="col-md-8" style="padding:0!important;">Disponível para viagens?</b>
                                    <a class="pull-right col-md-4" style="margin-right:10px;margin-top:-20px;">
                                        <input type="checkbox" class="bootstrapSwitch"
                                               data-on-text="Sim" data-off-text="Não" data-size="mini" id="disponivel_viagens" value="true">
                                    </a>
                                    <div class="clearfix"></div>
                                </li>

                                <li class="list-group-item">
                                    <b class="col-md-8" style="padding:0!important;">Você é fumante?</b>
                                    <a class="pull-right col-md-4" style="margin-right:10px;margin-top:-25px;">
                                        <input type="checkbox" class="bootstrapSwitch" data-on-text="Sim"
                                               data-off-text="Não" data-size="mini" id="fumante" value="true">
                                    </a>
                                    <div class="clearfix"></div>
                                </li>

                                <li class="list-group-item">
                                    <b class="col-md-8" style="padding:0!important;">Deseja receber notificações Newsletter?</b>
                                    <a class="pull-right col-md-4" style="margin-right:10px;margin-top:-35px;">
                                        <input type="checkbox" class="bootstrapSwitch"
                                               data-on-text="Sim" data-off-text="Não" data-size="mini" id="receber_notificacoes" value="true">
                                    </a>
                                    <div class="clearfix"></div>
                                </li>

                            </ul>

                            <a href="#" class="btn btn-primary btn-block"><b>Ver todas as vagas</b></a>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                    <!-- About Me Box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Sobre <?= $view->firstName($view->__get("nome")); ?></h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <strong ng-if="dadosUsuario.formacao_academica.length > 0"><i
                                    class="fa fa-book margin-r-5"></i> Formação Acadêmica</strong>
                            <p class="text-muted" ng-repeat="formacao in dadosUsuario.formacao_academica">
                                {{formacao.grau_escolaridade}} em {{formacao.curso}} pelo {{formacao.instituicao}} -
                                Conclusão
                                em {{formacao.data_conclusao}}
                            </p>

                            <hr ng-if="dadosUsuario.formacao_academica.length > 0">

                            <strong ng-if="!!dadosUsuario.endereco.estado"><i class="fa fa-map-marker margin-r-5"></i>
                                Localização Atual</strong>
                            <p class="text-muted" ng-if="!!dadosUsuario.endereco.estado">
                                {{dadosUsuario.endereco.estado}}, {{dadosUsuario.endereco.cidade}}</p>

                            <hr ng-if="!!dadosUsuario.endereco.estado">

                            <strong ng-if="!!dadosUsuario.outros.habilidades_gerais"><i class="fa fa-pencil margin-r-5"></i> Habilidades</strong>
                            <p ng-if="!!dadosUsuario.outros.habilidades_gerais">
                                <span class="label {{cores[2]}}" ng-repeat="valor in dadosUsuario.outros.habilidades_gerais" style="margin-left:5px">{{::valor}}</span>
                            </p>

                            <hr>

                            <strong ng-if="!!dadosUsuario.outros.resumo_profissional"><i
                                    class="fa fa-file-text-o margin-r-5"></i> Resumo Profissional</strong>
                            <p> {{dadosUsuario.outros.resumo_profissional}}
                            </p>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->

                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#dados_pessoais" data-toggle="tab">Dados Pessoais</a></li>
                            <li><a href="#formacao_academica" data-toggle="tab">Formação Acadêmica</a></li>
                            <li><a href="#experiencia_profissional" data-toggle="tab">Experiência Profissional</a></li>
                            <li><a href="#certificacoes" data-toggle="tab">Certificações</a></li>
                            <li><a href="#cursos_extra_curriculares" data-toggle="tab">Cursos Extra Curriculares</a>
                            </li>
                            <li><a href="#outras_informacoes" data-toggle="tab">Outras Informações</a></li>
                        </ul>
                        <div class="tab-content">
                            <!-- DadosPessoais -->
                            <?= $view->render("incDadosPessoais.php"); ?>

                            <!-- FormacaoAcademica -->
                            <?= $view->render("incFormacaoAcademica.php"); ?>

                            <!-- ExperienciaProfissional -->
                            <?= $view->render("incExperienciaProfissional.php"); ?>

                            <!-- Certificacoes -->
                            <?= $view->render("incCertificacoes.php"); ?>

                            <!-- ExtraCurriculares -->
                            <?= $view->render("incExtra.php"); ?>

                            <!-- OutrasInformacoes -->
                            <?= $view->render("incOutras.php"); ?>

                        </div><!-- /.tab-content -->
                    </div><!-- /.nav-tabs-custom -->
                </div><!-- /.col -->
            </div><!-- /.row -->

        </section><!-- /.content -->
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
<script src="../plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js"></script>
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
<script>
    $('#inicio').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });
</script>
<!--End of Tawk.to Script-->

</body>
</html>
