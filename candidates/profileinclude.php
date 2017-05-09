<?php
ob_start();
session_start();
$logado = false;


if(!empty($_SESSION['valid'])){
if($_SESSION['valid'] == 1){
$logado = true;

}else{
	echo 'nao ta logado';
	header('Refresh: 2; URL = /hunters/login.php');
}
}else{
	header('Refresh: 2; URL = /hunters/login.php');
}

?>
<script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript">

	$(document).ready(function() {
		
		$( "#perfilform" ).submit(function( event ) {
			
			event.preventDefault();
			
		
			var values = $(this).serializeArray();
			values.push({name: 'action', value: 'updatperfil'});
				 $.ajax({
				        url: "/hunters/controllers/usercontroller.php",
				        type: "post",
				        data: values ,
				        success: function (response) {
				           // you will get response from your php page (what you echo or print)     
				           console.log(response);
				           if(response == 1){
				        	   alert("Modificado  com sucesso!!");
				        	  
				           }else{
				        	   alert("Não pode modificar o usuário.");
				           }

				        },
				        error: function(jqXHR, textStatus, errorThrown) {
				           console.log(textStatus, errorThrown);
				        }


				    });
			  
			
			
			
			});
		  
	});

</script>

          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src="../dist/img/rodrigo.jpg" alt="User profile picture">
                  <h3 class="profile-username text-center"><?php echo $_SESSION ['nome'] ?></h3>
                  <p class="text-muted text-center">Analista de Business Intelligence</p>

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
					   <input id="switch-size" type="checkbox" name="receber_propostas" checked data-on-text="Sim" data-off-text="Não" data-size="mini">
					  </a>
                    </li>

                    <li class="list-group-item">
                      <b>Deseja receber propostas de curto prazo?</b>
					   <a class="pull-right">
					   <input id="switch-size" type="checkbox" name="projeto_curto_prazo" data-on-text="Sim" data-off-text="Não" data-size="mini">
					  </a>
                    </li>

                    <li class="list-group-item">
                      <b>Aceita propostas para trabalhos Home Office?</b>
					   <a class="pull-right">
					   <input id="switch-size" type="checkbox" name="home_office" data-on-text="Sim" data-off-text="Não" data-size="mini">
					  </a>
                    </li>

                    <li class="list-group-item">
                      <b>Aceita propostas de horários alternativos?</b>
					   <a class="pull-right">
					   <input id="switch-size" type="checkbox" name="horarios_alternativos" data-on-text="Sim" data-off-text="Não" data-size="mini">
					  </a>
                    </li>
					
                    <li class="list-group-item">
                      <b>Disponível para viagens?</b>
					   <a class="pull-right">
					   <input id="switch-size" type="checkbox" name="disponivel_viagens" data-on-text="Sim" data-off-text="Não" data-size="mini">
					  </a>
                    </li>
					
                    <li class="list-group-item">
                      <b>Você é fumante?</b>
					   <a class="pull-right">
					   <input id="switch-size" type="checkbox" name="fumante" data-on-text="Sim" data-off-text="Não" data-size="mini">
					  </a>
                    </li>					
					
                    <li class="list-group-item">
                      <b>Deseja receber notificações Newsletter?</b>
					   <a class="pull-right">
					   <input id="switch-size" type="checkbox" name="receber_promocoes" checked data-on-text="Sim" data-off-text="Não" data-size="mini">
					  </a>
                    </li>					
					
                  </ul>

                  <a href="#" class="btn btn-primary btn-block"><b>Ver todas as vagas</b></a>
				 
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Sobre Rodrigo</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <strong><i class="fa fa-book margin-r-5"></i>  Formação Acadêmica</strong>
                  <p class="text-muted">
                    Bacharel em Ciências da Computação pelo Centro Universitário Nove de Julho - Conclusão em 12/2003
                  </p>

                  <hr>

                  <strong><i class="fa fa-map-marker margin-r-5"></i> Localização Atual</strong>
                  <p class="text-muted">São Paulo, Alphaville</p>

                  <hr>

                  <strong><i class="fa fa-pencil margin-r-5"></i> Habilidades</strong>
                  <p>
                    <span class="label label-danger">SSAS</span>
                    <span class="label label-success">SSRS</span>
                    <span class="label label-info">SSIS</span>
                    <span class="label label-warning">SQL Server</span>
                    <span class="label label-primary">Oracle</span>
					<span class="label label-primary">Power Center</span>
                  </p>

                  <hr>

                  <strong><i class="fa fa-file-text-o margin-r-5"></i> Resumo Profissional</strong>
                  <p> Análise e Desenvolvimento de Projetos para empresas de grande porte e multinacionais, 
				     desenvolvendo soluções com alta tecnologia e diferenciadas. 
					 Analista Desenvolvedor, com conhecimentos em diversas tecnologias, tais como, Visual Basic 6
					 ,Crystal Reports 8.5, SQL SERVER (2000/2005/2008R2), Oracle, Visual Studio .NET 2008/2010
					 ,VB.NET, C#, Web Services, SSAS 2008, SSIS 2008, SSRS 2008, Qlikview 10, 
					 Plataforma Informatica (Power Center 9 , B2B Data Transformation).
				 </p>
				 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
			<form id="perfilform" action="" method="post">
            <div class="col-md-9">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#dados_pessoais" data-toggle="tab">Dados Pessoais</a></li>
				  <li><a href="#formacao_academica" data-toggle="tab">Formação_Acadêmica</a></li>
				  <li><a href="#experiencia_profissional" data-toggle="tab">Experiência Profissional</a></li>
				  <li><a href="#certificacoes" data-toggle="tab">Certificações</a></li>
				  <li><a href="#cursos_extra_curriculares" data-toggle="tab">Cursos Extra Curriculares</a></li>
				  <li><a href="#outras_informacoes" data-toggle="tab">Outras Informações</a></li>
                </ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="dados_pessoais">

					  <div class="row">
						<div class="col-md-12">
							  <div class="box box-primary">
								<div class="box-header with-border">
								  <h3 class="box-title">Informe seus dados pessoais</h3>
								</div>
								
								<div class="box-body">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-6">
												<label>Nome</label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-user"></i>
													</div>
													<input name="nome" value="<?php echo $_SESSION ['nome'] ?>" type="text" class="form-control" placeholder="Nome">
												</div>
											</div>

											<div class="col-xs-4">
												<label>RG</label>
												<div class="input-group">
													<div class="input-group-addon">
													<i class="fa fa-credit-card"></i>
													</div>
													<input name="rg" type="text" class="form-control" data-inputmask="'mask': ['99-999-999','99-999-999']" data-mask placeholder="RG">
												</div><!-- /.input group -->
											</div>										

											<div class="col-xs-2">
												<label>Dígito</label>
												<div class="input-group">
													<div class="input-group-addon">
													<i class="fa fa-credit-card"></i>
													</div>
													<input name="digito" type="text" class="form-control" placeholder="Dígito">
												</div><!-- /.input group -->
											</div>

										</div>
									</div>
									
									<div class="form-group">
										<div class="row">

											<div class="col-xs-3">
												<label>Data de Expedição</label>
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input name="dataexp" type="text" class="form-control pull-right" id="datepicker12">
												</div><!-- /.input group -->
											</div>											

											<div class="col-xs-3">
												<label>CPF</label>
												<div class="input-group">
													<div class="input-group-addon">
													<i class="fa fa-credit-card"></i>
													</div>
													<input name="cpf" type="text" class="form-control" data-inputmask="'mask': ['999-999-999 [-99]','999-999-999 [-99']" data-mask placeholder="CPF">
												</div><!-- /.input group -->
											</div>
											
											<div class="col-xs-3">
											  <label>Nacionalidade</label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-flag"></i>
													</div>
													<input name="nacionalidade" type="text" class="form-control" placeholder="Nacionalidade">
												</div>
											</div>

											<div class="col-xs-3">
											    <div class="form-group">
													<label>Sexo</label>
												    <div class="radio">
														<i class="fa fa-venus-mars"></i>
														<label>
															<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
															Masculino
														</label>
														<label>
															<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
															Feminino
														</label>											  
												    </div>
											    </div>	
											</div>  
										</div>
									</div>	
									
									<div class="form-group">
										<div class="row">
											<div class="col-xs-6">
												<label>Nome da Pai</label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-user"></i>
													</div>
													<input name="nomepai" type="text" class="form-control" placeholder="Nome do Pai">
												</div>
											</div>
											
											<div class="col-xs-6">
												<label>Nome da Mãe</label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-user"></i>
													</div>
													<input name="nomemae" type="text" class="form-control" placeholder="Nome da Mãe">
												</div>
											</div>
										</div>
									</div>	
									
								    <div class="form-group">
										<div class="row">
											<div class="col-xs-4">
												<label>Data de Nasicmento</label>
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input name="datanasc" type="text" class="form-control pull-right" id="datepicker">
												</div><!-- /.input group -->
											</div>

											<div class="col-xs-4">
												<!-- select -->
												<div class="form-group">
												    <label>Estado Civil</label>
													<select name="estadocivil" class="form-control">
														<option>Selecione</option>
														<option>Solteiro(a)</option>
														<option>Casado(a)</option>
														<option>Divorciado(a)</option>
													</select>
												</div>
											</div>
											
											<div class="col-xs-4">
												<!-- phone mask -->
												<div class="form-group">
													<label>Telefone</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-phone"></i>
														</div>
														<input name="tel" type="text" class="form-control" data-inputmask='"mask": "(999) 9999-9999"' data-mask>
													</div><!-- /.input group -->
												</div><!-- /.form group -->											
											</div>
											
										</div>
									</div><!-- /.form group -->
									
									<div class="form-group">
										<div class="row">
											<div class="col-xs-4">
												<!-- phone mask -->
												<label>Celular</label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-phone"></i>
													</div>
													<input name="cel" type="text" class="form-control" data-inputmask='"mask": "(999) 99999-9999"' data-mask>
												</div><!-- /.input group -->
											</div>								
										
											<div class="col-xs-8">
												<label>E-mail</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
													<input name="email" value=" <?php echo $_SESSION ['email']?> " type="email" class="form-control" placeholder="Email">
												</div>
											</div>
										
										</div>
									</div><!-- /.form group -->

									<div class="form-group">
										<div class="row">
											<div class="col-xs-8">
												<label>WebSite</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-internet-explorer"></i></span>
													<input name="site"  type="email" class="form-control" placeholder="WebSite">
												</div>
											</div>
											
											<div class="col-xs-4">
												<label>CEP</label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-university"></i>
													</div>
													<input name="cep" type="text" class="form-control" data-inputmask='"mask": "99999-999"' data-mask>
												</div><!-- /.input group -->
											</div>
											
										</div>
									</div><!-- /.form group -->

									<div class="form-group">
										<div class="row">
											<div class="col-xs-6">
											  <label>Endereço</label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-home"></i>
													</div>
													<input name="end" type="text" class="form-control" placeholder="Endereço">
												</div>
											</div>

											<div class="col-xs-2">
											  <label>Número</label>
											  <input name="num" type="text" class="form-control" placeholder="Número">
											</div>											

											<div class="col-xs-4">
											  <label>Complemento</label>
											  <input name="compl" type="text" class="form-control" placeholder="Complemento">
											</div>
											
										</div>
									</div><!-- /.form group -->

									<div class="form-group">
										<div class="row">
										
											<div class="col-xs-3">
											  <label>Bairro</label>
											  <input name="bairro" type="text" class="form-control" placeholder="Bairro">
											</div>

										
											<div class="col-xs-3">
											  <label>Cidade</label>
											  <input name="cidade" type="text" class="form-control" placeholder="Cidade">
											</div>											

											<div class="col-xs-2">
												<label>Estado</label>
												<select name="estado" class="form-control">
													<option>Selecione</option>
													<option>São Paulo</option>
													<option>Rio de Janeiro</option>
													<option>Recife</option>
													<option>Amazonas</option>
													<option>Espirito Santo</option>
												</select>
											</div>
											
											<div class="col-xs-4">
												<label>Pais</label>
												<select name="pais" class="form-control">
													<option>Selecione</option>
													<option>Brasil</option>
													<option>Argentina</option>
													<option>Colombia</option>
													<option>Portugal</option>
													<option>USA</option>
												</select>
											</div>
											
										</div>
									</div><!-- /.form group -->
									
									<div class="form-group">
										<div class="row">
										
											<div class="col-xs-12">
												<label>É PCD?</label>
												<div class="input-group">
													<span class="input-group-addon">
														<input id="switch-size" type="checkbox" name="deficiente_fisico" data-on-text="Sim" data-off-text="Não" data-size="mini">
													</span>
												<input type="text" class="form-control" placeholder="Informe a deficiência física aqui">
											  </div>
											</div>
											
										</div>
									</div><!-- /.form group -->									
									
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12">			
												<button type="submit" class="btn btn-primary">Atualizar</button>
											</div>
										</div>
									</div>											
											
								</div>
								
							</div><!-- /.box-body -->
						</div><!-- /.box -->							  
					  </div><!-- /.row -->					
					</div><!-- /.tab-pane -->
				  </form>
					<div class="tab-pane" id="formacao_academica">
						<div class="row">
							<div class="col-md-12">
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Informe seu histórico acadêmico </h3>
									</div>
									
									<div class="box-body">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-8">
													<label>Instituição</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-home"></i>
														</div>
														<input type="text" class="form-control" placeholder="Instituição">
													</div>
												</div>
												
												<div class="col-xs-4">
													<label>Grau de Escolaridade</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-balance-scale"></i>
														</div>
														<select class="form-control">
															<option>Selecione</option>
															<option>Ensino Fundamental - Incompleto</option>
															<option>Ensino Fundamental - Completo</option>
															<option>Ensino Médio - Incompleto</option>
															<option>Ension Médio - Completo</option>
															<option>Bacharel - Incompleto</option>
															<option>Bacharel - Completo</option>
															<option>Pós-Graduação - Incompleto</option>
															<option>Pós-Graduação - Completo</option>
															<option>Mestrado - Incompleto</option>
															<option>Mestrado - Completo</option>
															<option>Doutorado - Incompleto</option>
															<option>Doutorado - Completo</option>
														</select>
													</div>
												</div>												
												
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-xs-8">
													<label>Curso</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-graduation-cap"></i>
														</div>
														<input type="text" class="form-control" placeholder="Curso">
													</div>
												</div>
												
												<div class="col-xs-2">
													<label>Data de Conslusão</label>
													<div class="input-group date">
														<div class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</div>
														<input type="text" class="form-control pull-right" id="datepicker1">
													</div><!-- /.input group -->
												</div>
												
												<div class="col-xs-2">
													<label>Cursando</label>
													<div class="input-group">
														<input id="switch-onText" type="checkbox" name="cursando" data-on-text="Sim" data-off-text="Não" data-size="mini">
													</div>
												</div>												
												
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-xs-12">
													<label>Descrição</label>
													<textarea class="form-control" rows="8" id="inputExperience" placeholder="Informe uma descrição relevante à sua formação"></textarea>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12">			
													<button type="submit" class="btn btn-primary">Atualizar</button>
												</div>
											</div>
										</div>										
										
									</div>
									
									<div class="box box-primary">
										<div class="box-body">						
											<table id="historico_academico" class="table table-bordered table-striped">
												<thead>
												  <tr>
													<th>Instituição</th>
													<th>Curso</th>
													<th>Opções</th>
												  </tr>
												</thead>
												<tbody>
												  <tr>
													<td>Centro Universitário Nove de Julho</td>
													<td>Ciências da Computação</td>
													<td>
														<a class="btn btn-info" href="#">
															<i class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" title="Editar"></i>
														</a>
														<a class="btn btn-danger" href="#">
															<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="bottom" title="Excluir"></i> 
														</a>
													</td>
												  </tr>
												</tbody>
											</table>							
										</div>
									</div><!-- /.box-body -->									
									
									
									
								</div><!-- /.box-body -->
							</div><!-- /.box -->							  
						</div><!-- /.row -->	
					</div><!-- /.tab-pane -->				  
				  
					<div class="tab-pane" id="experiencia_profissional">
						<div class="row">
							<div class="col-md-12">
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Informe seu histórico Profissional </h3>
									</div>
									
									<div class="box-body">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-6">
													<label>Empresa</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa  fa-industry"></i>
														</div>
														<input type="text" class="form-control" placeholder="Empresa">
													</div>
												</div>

												<div class="col-xs-3">
													<label>Localidade</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-home"></i>
														</div>
														<input type="text" class="form-control" placeholder="Localidade">
													</div>
												</div>
												
												<div class="col-xs-3">
													<label>Segmento</label>
													<select class="form-control select2" " multiple="multiple" data-placeholder="Descreva o segmento da empresa" style="width: 100%;">
														<option>Alimentício</option>
														<option>Bancário</option>
														<option>Financeiro</option>
														<option>Imobiliário</option>
														<option>Hospitalar</option>
														<option>Turístico</option>
														<option>Varejo</option>
														<option>Logístico</option>												
														<option>Seguros</option>
													</select>
												</div>												

											</div>
										</div>
										
										<div class="form-group">
											<div class="row">
											
												<div class="col-xs-6">
													<label>Cargo</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-briefcase"></i>
														</div>
														<input type="text" class="form-control" placeholder="Cargo">
													</div>
												</div>

												<div class="col-xs-2">
													<label>Início</label>
													<div class="input-group date">
														<div class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</div>
														<input type="text" class="form-control pull-right" id="datepicker2">
													</div><!-- /.input group -->
												</div>
												
												<div class="col-xs-2">
													<label>Fim</label>
													<div class="input-group date">
														<div class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</div>
														<input type="text" class="form-control pull-right" id="datepicker3">
													</div><!-- /.input group -->
												</div>
												
												<div class="col-xs-2">
													<label>Cargo Atual</label>
													<div class="input-group">
														<input id="switch-onText" type="checkbox" name="cargo_atual" data-on-text="Sim" data-off-text="Não" data-size="mini">
													</div>
												</div>
												
											</div>
										</div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12">
													<label>Atividades</label>
													<textarea class="form-control" rows="8" id="inputExperience" placeholder="Descreva as atividades exercidas no projeto"></textarea>
												</div>
											</div>
										</div>										
										
										<div class="form-group">
											<div class="row">

												<div class="col-xs-6">
													<label>WebSite da Empresa</label>
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-internet-explorer"></i></span>
														<input type="email" class="form-control" placeholder="WebSite">
													</div>
												</div>											
											
												<div class="col-xs-6">
													<label>Habilidades</label>
													<select class="form-control select2" " multiple="multiple" data-placeholder="Descreva as ferramentas com qual você atuou neste projeto" style="width: 100%;">
														<option>SQL Server</option>
														<option>Oracle</option>
														<option>Power Center</option>
														<option>Data Quality</option>
														<option>PHP</option>
														<option>.NET</option>
														<option>.NET Framework</option>
														<option>Visual Basic 6</option>												
														<option>C#</option>
														<option>F#</option>
														<option>Laravel</option>
														<option>JavaScript</option>
														<option>JSON</option>
													</select>
												</div>
											</div>
										</div><!-- /.form-group -->

										<div class="form-group">
											<div class="row">
												<div class="col-xs-6">
													<label>Forma de Contratação</label>
													<select class="form-control">
														<option>Selecione</option>
														<option>Indiferente</option>
														<option>CLT Full</option>
														<option>CLT Flex</option>
														<option>CLT Cotas</option>
														<option>PJ</option>
														<option>Free-Lancer</option>
													</select>
												</div>

												<div class="col-xs-6">
													<label>Pretensão Salarial (base 168/mês)</label>
													<div class="input-group">
														<span class="input-group-addon">R$</span>
															<input type="text" class="form-control" placeholder="Informe sua pretensão salarial">
														<span class="input-group-addon">.00</span>
														<span class="input-group-addon"><i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Informe aqui o seu último salário na empresa. &#013;Esta informação não será divulgada, servirá apenas para fazer um cálculo entre os valores de salários das empresas.&#013;"></i></span>	
													</div>
												</div>
											</div>
										</div><!-- /.form-group -->
										
										
										
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12">			
													<button type="submit" class="btn btn-primary">Atualizar</button>
												</div>
											</div>
										</div>
										
									</div>

									<div class="box box-primary">
										<div class="box-body">						
											<table id="historico_profissional" class="table table-bordered table-striped">
												<thead>
												  <tr>
													<th>Empresa</th>
													<th>Cargo</th>
													<th>Opções</th>
												  </tr>
												</thead>
												<tbody>
												  <tr>
													<td>NetPartners International</td>
													<td>Analista de Business Intelligence</td>
													<td>
														<a class="btn btn-info" href="#">
															<i class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" title="Editar"></i>
														</a>
														<a class="btn btn-danger" href="#">
															<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="bottom" title="Excluir"></i> 
														</a>
													</td>
												  </tr>
												</tbody>
											</table>							
										</div>
									</div><!-- /.box-body -->
									
								</div><!-- /.box-body -->
							</div><!-- /.box -->							  
						</div><!-- /.row -->	
					</div><!-- /.tab-pane -->					  

					<div class="tab-pane" id="certificacoes">
						<div class="row">
							<div class="col-md-12">
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Informe suas Certificações</h3>
									</div>
									
									<div class="box-body">
									
										<div class="form-group">
											<div class="row">
												<div class="col-xs-6">
													<label>Instituição</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-home"></i>
														</div>
														<input type="text" class="form-control" placeholder="Instituição">
													</div>
												</div>

												<div class="col-xs-6">
													<label>Certificado</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-graduation-cap"></i>
														</div>
														<input type="text" class="form-control" placeholder="Certificado">
													</div>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<div class="row">										
												<div class="col-xs-3">
													<label>Número da Licença</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-book"></i>
														</div>
														<input type="text" class="form-control" placeholder="Número da Licença">
													</div>
												</div>											

												<div class="col-xs-3">
													<label>Data de Conslusão</label>
													<div class="input-group date">
														<div class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</div>
														<input type="text" class="form-control pull-right" id="datepicker4">
													</div><!-- /.input group -->
												</div>
											
												<div class="col-xs-6">
													<label>URL do Certificado</label>
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-internet-explorer"></i></span>
														<input type="email" class="form-control" placeholder="URL do Certificado">
													</div>
												</div>											
											</div>
										</div>	

										<div class="form-group">
											<div class="row">
												<div class="col-xs-12">
													<label>Descrição</label>
													<textarea class="form-control" rows="8" id="inputExperience" placeholder="Informe uma descrição relevante referente ao curso"></textarea>
												</div>
											</div>
										</div>	
										
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12">			
													<button type="submit" class="btn btn-primary">Atualizar</button>
												</div>
											</div>
										</div>										
										
									</div>

									<div class="box box-primary">
										<div class="box-body">						
											<table id="certificacoes" class="table table-bordered table-striped">
												<thead>
												  <tr>
													<th>Instituição</th>
													<th>Certificado</th>
													<th>Opções</th>
												  </tr>
												</thead>
												<tbody>
												  <tr>
													<td>Informatica </td>
													<td>Informatica Certified Developer</td>
													<td>
														<a class="btn btn-info" href="#">
															<i class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" title="Editar"></i>
														</a>
														<a class="btn btn-danger" href="#">
															<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="bottom" title="Excluir"></i> 
														</a>
													</td>
												  </tr>
												</tbody>
											</table>							
										</div>
									</div><!-- /.box-body -->
									
								</div><!-- /.box-body -->
							</div><!-- /.box -->							  
						</div><!-- /.row -->	
					</div><!-- /.tab-pane -->	

					<div class="tab-pane" id="cursos_extra_curriculares">
						<div class="row">
							<div class="col-md-12">
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Informe seus Cursos Extra Curriculares</h3>
									</div>
									
									<div class="box-body">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-4">
													<label>Instituição</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-home"></i>
														</div>
														<input type="text" class="form-control" placeholder="Instituição">
													</div>
												</div>

												<div class="col-xs-4">
													<label>Curso</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-graduation-cap"></i>
														</div>
														<input type="text" class="form-control" placeholder="Curso">
													</div>
												</div>

												<div class="col-xs-2">
													<label>Total de Horas</label>
													<div class="input-group">
														<div class="input-group-addon">
														<i class="fa fa-clock-o"></i>
														</div>
														<input type="text" class="form-control" data-inputmask="'mask': ['999]','999']" data-mask placeholder="Total de horas">
													</div><!-- /.input group -->
												</div>
												
												<div class="col-xs-2">
													<label>Data de Conslusão</label>
													<div class="input-group date">
														<div class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</div>
														<input type="text" class="form-control pull-right" id="datepicker5">
													</div><!-- /.input group -->
												</div>

											</div>
											
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-xs-12">
													<label>Descrição</label>
													<textarea class="form-control" rows="8" id="inputExperience" placeholder="Informe uma descrição relevante referente ao curso"></textarea>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12">			
													<button type="submit" class="btn btn-primary">Atualizar</button>
												</div>
											</div>
										</div>												
										
									</div>

									<div class="box box-primary">
										<div class="box-body">						
											<table id="curso_extra_curricular" class="table table-bordered table-striped">
												<thead>
												  <tr>
													<th>Instituição</th>
													<th>Curso</th>
													<th>Opções</th>
												  </tr>
												</thead>
												<tbody>
												  <tr>
													<td>Ka Solution Tecnologia em Software Ltda</td>
													<td>Microsoft SQL Server 2008 Integration Services</td>
													<td>
														<a class="btn btn-info" href="#">
															<i class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" title="Editar"></i>
														</a>
														<a class="btn btn-danger" href="#">
															<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="bottom" title="Excluir"></i> 
														</a>
													</td>
												  </tr>
												</tbody>
											</table>							
										</div>
									</div><!-- /.box-body -->									
									
								</div><!-- /.box-body -->
							</div><!-- /.box -->							  
						</div><!-- /.row -->	
					</div><!-- /.tab-pane -->						

					<div class="tab-pane" id="outras_informacoes">
						<div class="row">
							<div class="col-md-12">
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Outras Informações </h3>
									</div>
									
									<div class="box-body">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12">
													<label>Resumo Profissional</label>
													<textarea class="form-control" rows="8" id="inputExperience" placeholder="Informe seu resumo profissional"></textarea>
												</div>
											</div>
										</div>
									</div>
								</div><!-- /.box-body -->
								
								<div class="box box-primary">
									<div class="box-body">
										<div class="form-group">
											<div class="row">
												
												<div class="col-xs-12">
													<label>Habilidades Gerais</label>
													<select class="form-control select2" " multiple="multiple" data-placeholder="Informe todas as ferramentas que possui conhecimento" style="width: 100%;">
														<option>SQL Server</option>
														<option>Oracle</option>
														<option>Power Center</option>
														<option>Data Quality</option>
														<option>PHP</option>
														<option>.NET</option>
														<option>.NET Framework</option>
														<option>Visual Basic 6</option>
														<option>C#</option>
														<option>F#</option>
														<option>Laravel</option>
														<option>JavaScript</option>
														<option>JSON</option>
													</select>
												</div>												
												
											</div>
										</div>
									
									</div>
								</div><!-- /.box-body -->

								<div class="box box-primary">
									<div class="box-body">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-6">
													<label>Idiomas</label>
													<select class="form-control">
														<option>Selecione</option>
														<option>Português - Brasil</option>
														<option>Inglês</option>
														<option>Alemão</option>
														<option>Frances</option>
														<option>Italiano</option>
														<option>Mandarim</option>
													</select>
												</div>

												<div class="col-xs-6">
													<label>Nível</label>
													<select class="form-control">
														<option>Selecione</option>
														<option>Nativo</option>
														<option>Básico</option>
														<option>Intermediário</option>
														<option>Avançado</option>
														<option>Fluente</option>
														<option>Técnico</option>
													</select>
												</div>
												
											</div>
										</div>
									
									</div>
									
									<div class="box-body">						
										<table id="idiomas" class="table table-bordered table-striped">
											<thead>
											  <tr>
												<th>Idioma</th>
												<th>Nível</th>
												<th>Opções</th>
											  </tr>
											</thead>
											<tbody>
											  <tr>
												<td>Português</td>
												<td>Nativo</td>
												<td>
													<a class="btn btn-info" href="#">
														<i class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" title="Editar"></i>
													</a>
													<a class="btn btn-danger" href="#">
														<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="bottom" title="Excluir"></i> 
													</a>
												</td>
											  </tr>
											  <tr>
												<td>Inglês</td>
												<td>Técnico</td>
												<td>
													<a class="btn btn-info" href="#">
														<i class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" title="Editar"></i>
													</a>
													<a class="btn btn-danger" href="#">
														<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="bottom" title="Excluir"></i> 
													</a>
												</td>
											  </tr>												  
											</tbody>
										</table>							
									</div>																		
									
								</div><!-- /.box-body -->

								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Informe suas expectativas para o seu próximo trabalho</h3>
									</div>							
								
									<div class="box-body">
										<div class="form-group">
											<div class="row">
												<div class="col-lg-4">
													<!-- select -->
													<div class="form-group">
														<label>Cargo Principal</label>
														<select class="form-control">
															<option>Selecione</option>
															<option>Analista de Testes Sênior</option>	
															<option>Analista de Web Development Júnior</option>
															<option>Analista de Web Development Pleno</option>
															<option>Analista de Web Development Sênior</option>
															<option>Analista Programador Júnior</option>
															<option>Analista Programador Pleno</option>
															<option>Analista Programador Sênior</option>
															<option>Arquiteto da Informação Júnior</option>
															<option>Arquiteto da Informação Pleno</option>
															<option>Arquiteto da Informação Sênior</option>
															<option>Assistente de Administração de Banco de Dados</option>
															<option>Assistente de Administração de Redes</option>
															<option>Assistente de Arquitetura da Informação</option>
															<option>Assistente de Conteúdo Web</option>
															<option>Assistente de E-Commerce / E-Business</option>
															<option>Assistente de Negócios Web</option>
															<option>Assistente de Processamento de Dados</option>
															<option>Assistente de Programação</option>
															<option>Assistente de Qualidade de Software</option>
															<option>Assistente de Segurança da Informação</option>
															<option>Assistente de Sistemas (Projetos / Desenvolvimento / Consultoria)</option>
															<option>Assistente de Suporte Técnico em Informática - Help Desk</option>
															<option>Assistente de Tecnologia da Informação</option>
														</select>
													</div>
												</div>
												
												<div class="col-lg-4">
													<!-- select -->
													<div class="form-group">
														<label>Cargo Secundário</label>
														<select class="form-control">
															<option>Selecione</option>
															<option>Analista de Testes Sênior</option>	
															<option>Analista de Web Development Júnior</option>
															<option>Analista de Web Development Pleno</option>
															<option>Analista de Web Development Sênior</option>
															<option>Analista Programador Júnior</option>
															<option>Analista Programador Pleno</option>
															<option>Analista Programador Sênior</option>
															<option>Arquiteto da Informação Júnior</option>
															<option>Arquiteto da Informação Pleno</option>
															<option>Arquiteto da Informação Sênior</option>
															<option>Assistente de Administração de Banco de Dados</option>
															<option>Assistente de Administração de Redes</option>
															<option>Assistente de Arquitetura da Informação</option>
															<option>Assistente de Conteúdo Web</option>
															<option>Assistente de E-Commerce / E-Business</option>
															<option>Assistente de Negócios Web</option>
															<option>Assistente de Processamento de Dados</option>
															<option>Assistente de Programação</option>
															<option>Assistente de Qualidade de Software</option>
															<option>Assistente de Segurança da Informação</option>
															<option>Assistente de Sistemas (Projetos / Desenvolvimento / Consultoria)</option>
															<option>Assistente de Suporte Técnico em Informática - Help Desk</option>
															<option>Assistente de Tecnologia da Informação</option>
														</select>
													</div>
												</div>
												
												<div class="col-lg-4">
													<!-- select -->
													<div class="form-group">
														<label>Cargo Terceário</label>
														<select class="form-control">
															<option>Selecione</option>
															<option>Analista de Testes Sênior</option>	
															<option>Analista de Web Development Júnior</option>
															<option>Analista de Web Development Pleno</option>
															<option>Analista de Web Development Sênior</option>
															<option>Analista Programador Júnior</option>
															<option>Analista Programador Pleno</option>
															<option>Analista Programador Sênior</option>
															<option>Arquiteto da Informação Júnior</option>
															<option>Arquiteto da Informação Pleno</option>
															<option>Arquiteto da Informação Sênior</option>
															<option>Assistente de Administração de Banco de Dados</option>
															<option>Assistente de Administração de Redes</option>
															<option>Assistente de Arquitetura da Informação</option>
															<option>Assistente de Conteúdo Web</option>
															<option>Assistente de E-Commerce / E-Business</option>
															<option>Assistente de Negócios Web</option>
															<option>Assistente de Processamento de Dados</option>
															<option>Assistente de Programação</option>
															<option>Assistente de Qualidade de Software</option>
															<option>Assistente de Segurança da Informação</option>
															<option>Assistente de Sistemas (Projetos / Desenvolvimento / Consultoria)</option>
															<option>Assistente de Suporte Técnico em Informática - Help Desk</option>
															<option>Assistente de Tecnologia da Informação</option>
														</select>
													</div>
												</div>
											</div>
										
											<div class="row">
												<div class="col-xs-4">
													<label>Forma de Contratação</label>
													<select class="form-control">
														<option>Selecione</option>
														<option>Indiferente</option>
														<option>CLT Full</option>
														<option>CLT Flex</option>
														<option>CLT Cotas</option>
														<option>PJ</option>
														<option>Free-Lancer</option>
													</select>
												</div>

												<div class="col-xs-4">
													<label>Pretensão Salarial (base 168/mês)</label>
													<div class="input-group">
														<span class="input-group-addon">R$</span>
															<input type="text" class="form-control" placeholder="Informe sua pretensão salarial">
														<span class="input-group-addon">.00</span>
													</div>
												</div>
												
												<div class="col-xs-4">
													<label>Disponibilidade para Início</label>
													<select class="form-control">
														<option>Selecione</option>
														<option>Imediata</option>
														<option>Até 7 dias</option>
														<option>Até 15 dias</option>
														<option>Até 20 dias</option>
														<option>Até 30 dias</option>
														<option>A Combinar</option>
													</select>
												</div>
												
											</div>
										</div>
									
									</div>
								</div><!-- /.box-body -->

								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Trabalhos Voluntários</h3>
									</div>									
								
									<div class="box-body">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-6">
													<label>Organização</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa  fa-industry"></i>
														</div>
														<input type="text" class="form-control" placeholder="Organização">
													</div>
												</div>												
												
												<div class="col-xs-6">
													<label>Causas</label>
													<select class="form-control select2" " multiple="multiple" data-placeholder="Informe as causas da organização." style="width: 100%;">
														<option>Ações Sociais</option>
														<option>Assistência Humanitária</option>
														<option>Artes</option>
														<option>Ciência e Tecnologia</option>
														<option>Crianças</option>
														<option>Cultura</option>														
														<option>Desastres</option>														
														<option>Direitos Civis</option>														
														<option>Direitos Humanos</option>
														<option>Educação</option>
														<option>Empoderamento Econômico</option>
														<option>Meio Ambiente</option>
														<option>Pobreza</option>
														<option>Política</option>
														<option>Proteção Animal</option>
														<option>Saúde</option>
														<option>Serviços Sociais</option>
													</select>
												</div>												
											</div>
										</div>

										<div class="form-group">
											<div class="row">												
												<div class="col-xs-6">
													<label>Cargo</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-briefcase"></i>
														</div>
														<input type="text" class="form-control" placeholder="Cargo">
													</div>
												</div>

												<div class="col-xs-2">
													<label>Início</label>
													<div class="input-group date">
														<div class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</div>
														<input type="text" class="form-control pull-right" id="datepicker10">
													</div><!-- /.input group -->
												</div>
												
												<div class="col-xs-2">
													<label>Fim</label>
													<div class="input-group date">
														<div class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</div>
														<input type="text" class="form-control pull-right" id="datepicker11">
													</div><!-- /.input group -->
												</div>
												
												<div class="col-xs-2">
													<label>Cargo Atual</label>
													<div class="input-group">
														<input id="switch-onText" type="checkbox" name="cargo_voluntario" data-on-text="Sim" data-off-text="Não" data-size="mini">
													</div>
												</div>												
												
											</div>
										</div>
									
									</div>
									
									<div class="box-body">						
										<table id="trabalho_voluntario" class="table table-bordered table-striped">
											<thead>
											  <tr>
												<th>Organização</th>
												<th>Cargo</th>
												<th>Causa</th>
												<th>Opções</th>
											  </tr>
											</thead>
											<tbody>
											  <tr>
												<td>Pet Vida</td>
												<td>Assitente de domicílio</td>
												<td>Proteção Animal</td>
												<td>
													<a class="btn btn-info" href="#">
														<i class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" title="Editar"></i>
													</a>
													<a class="btn btn-danger" href="#">
														<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="bottom" title="Excluir"></i> 
													</a>
												</td>
											  </tr>
											  <tr>
												<td>Um Futuro Melhor</td>
												<td>Psicólogo(a)</td>
												<td>Crianças</td>
												<td>
													<a class="btn btn-info" href="#">
														<i class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" title="Editar"></i>
													</a>
													<a class="btn btn-danger" href="#">
														<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="bottom" title="Excluir"></i> 
													</a>
												</td>
											  </tr>												  
											</tbody>
										</table>							
									</div>										
									
								</div><!-- /.box-body -->								
								
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Sobre Você</h3>
									</div>
									
									<div class="box-body">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12">
													<label>Perfil</label>
													<textarea class="form-control" rows="8" id="inputExperience" placeholder="Descreva como você é fora do ambiente de trabalho. Descreva suas atividades de final de semana. Informe o que você faz nas horas vagas."></textarea>
												</div>
											</div>
										
										</div>										
										
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12">
													<label>Perfil Online</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa  fa-youtube"></i>
														</div>
														<input type="text" class="form-control" placeholder="Insira aqui o link do seu perfil no YouTube">
														<span class="input-group-addon"><i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Crie um breve vídeo do seu perfil no YouTube, contando como você é profissionalmente e pessoalmente.&#013;Crie um vídeo descontraido e mostrando todas suas qualidades pessoais.&#013;Copie a URL e cole aqui:&#013;Ex: https://www.youtube.com/watch?v=Gdxty2l6z2o" ></i></span>													
														<!--
														Regra para Gravação
														- Efetuar o Replace da palavra "watch?v=" por "embed/", conforme exemplo abaixo:
														
														De 
															https://www.youtube.com/watch?v=Gdxty2l6z2o
														Para 
															https://www.youtube.com/embed/Gdxty2l6z2o
														-->														
													</div>
												</div>												
											</div>
										</div>
										
									</div>
								</div><!-- /.box-body -->
								
								<div class="form-group">
									<div class="row">
										<div class="col-xs-12">			
											<button type="submit" class="btn btn-primary">Atualizar</button>
										</div>
									</div>
								</div>
								
							</div><!-- /.box -->							  
						</div><!-- /.row -->	
					</div><!-- /.tab-pane -->	
					
                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
          </div><!-- /.row -->