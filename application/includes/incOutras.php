<div class="tab-pane" id="outras_informacoes">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form id="outrasInformacoesForm" method="post">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6">

                            </div>
                        </div><br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label>Resumo Profissional</label>
                                    <textarea class="form-control" rows="8" id="resumoOutros"
                                              name="dados[resumo_profissional]"
                                              ng-value="dadosUsuario.outros.resumo_profissional"
                                              ng-model="outros.resumo"
                                              maxlength="1000"
                                              placeholder="Informe seu resumo profissional"></textarea>
                                </div>
                                <div class="col-xs-3 col-xs-offset-9" style="text-align:right;">Faltam {{1000 - outros.resumo.length}} caracteres</div>
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
                                <select class="form-control select2" multiple="multiple"
                                        id="habilidadesOutros"
                                        name="dados[habilidades_gerais][]"
                                        data-placeholder="Informe todas as ferramentas que possui conhecimento" style="width: 100%;">
                                    <option ng-repeat="(chave, valor) in dominios.habilidades">{{valor.tecnologia}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- /.box-body -->

            <div class="box box-primary">
                <div class="box-body">
                    <div class="form-group">
                        <div class="row" id="idiomascontainer">
                            <div class="col-xs-6">
                                <label>Idiomas  <span class="red">*</span></label>
                                <select class="form-control" id="idiomas" ng-model="idiomas.idioma" required>
                                    <option value="">Selecione</option>
                                    <option ng-repeat="(chave, valor) in dominios.idiomas">{{valor.idioma}}</option>
                                </select>
                            </div>

                            <div class="col-xs-6">
                                <label>Nível  <span class="red">*</span></label>
                                <select class="form-control" id="nivel" ng-model="idiomas.nivel" required>
                                    <option value="">Selecione</option>
                                    <option ng-repeat="(chave, valor) in dominios.nivel_idioma">{{valor.nivel}}</option>
                                </select>
                            </div>
                            <div class="form-group" style="padding:20px; margin-top:50px;">
                                <a class="btn btn-info col-md-2 col-md-offset-10" ng-click="addIdioma(idiomas.idioma, idiomas.nivel)" promise-btn>
                                    Adicionar
                                    <i class="fa fa-plus" data-toggle="tooltip"
                                       data-placement="bottom" title="Adicionar"></i>
                                </a>
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
                        <tbody id="idi_body">
                            <tr ng-repeat="idioma in dadosUsuario.outros.idiomas">
                                <td>{{idioma.idioma}}</td>
                                <td>{{idioma.nivel}}</td>
                                <td>
                                    <a class="btn btn-info" href="#">
                                        <i class="fa fa-edit" data-toggle="tooltip"
                                           data-placement="bottom" title="Editar"></i>
                                    </a>
                                    <a class="btn btn-danger">
                                        <i class="fa fa-trash-o" data-toggle="tooltip"
                                           data-placement="bottom" title="Excluir" ng-click="pullMongo(idioma, 'outros.idiomas')"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="!dadosUsuario.outros.idiomas || dadosUsuario.outros.idiomas.length <= 0">
                                <td>Ainda não existem idiomas cadastrados</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div><!-- /.box-body -->

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Informe suas expectativas para o seu próximo
                        trabalho</h3>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-4">
                                <!-- select -->
                                <div class="form-group">
                                    <label>Cargo Principal</label>
                                    <select class="form-control" id="cargoOutros" name="dados[cargo_principal]" ng-value="dadosUsuario.outros.cargo_principal" ng-model="cargo_principal">
                                        <option value="">Selecione</option>
                                        <option ng-repeat="(chave, valor) in dominios.cargos">{{valor.cargo}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- select -->
                                <div class="form-group">
                                    <label>Cargo Secundário</label>
                                    <select class="form-control" id="cargoSecundarioOutros" name="dados[cargo_secundario]" ng-value="dadosUsuario.outros.cargo_secundario" ng-model="cargo_secundario">
                                        <option value="">Selecione</option>
                                        <option ng-repeat="(chave, valor) in dominios.cargos">{{valor.cargo}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- select -->
                                <div class="form-group">
                                    <label>Cargo Terceário</label>
                                    <select class="form-control" id="cargoTercearioOutros" name="dados[cargo_terceario]" ng-value="dadosUsuario.outros.cargo_terceario" ng-model="cargo_terceario">
                                        <option value="">Selecione</option>
                                        <option ng-repeat="(chave, valor) in dominios.cargos">{{valor.cargo}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">
                                <label>Forma de Contratação</label>
                                <select class="form-control" id="formaContratacaoOutros" name="dados[forma_contratacao]" ng-value="dadosUsuario.outros.forma_contratacao" ng-model="forma_contratacao">
                                    <option value="">Selecione</option>
                                    <option ng-repeat="(chave, valor) in dominios.formas_contratacao">{{valor.forma_contratacao}}</option>
                                </select>
                            </div>

                            <div class="col-xs-4">
                                <label>Pretensão Salarial (base 168/mês)</label>
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    <input type="text" class="form-control" id="pretensaoOutros" name="dados[pretensao_salarial]"
                                           ng-value="dadosUsuario.outros.pretensao_salarial"
                                           ng-model="outros.pretensao_salarial"
                                           placeholder="Informe sua pretensão salarial" format="number" zero-filter="true">
                                    <span class="input-group-addon">.00</span>
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <label>Disponibilidade para Início</label>
                                <select class="form-control" id="disponibilidadeOutros" name="dados[disponibilidade_inicio]" ng-value="dadosUsuario.outros.disponibilidade_inicio" ng-model="disponibilidade_inicio">
                                    <option value="">Selecione</option>
                                    <option ng-repeat="(chave, valor) in dominios.disponibilidade_inicio">{{valor.disponibilidade}}</option>
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

                <div class="box-body" id="trabalhos_voluntarios">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label>Organização <span class="red">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa  fa-industry"></i>
                                    </div>
                                    <input type="text" class="form-control"
                                           id="organizacao"
                                           ng-model="trab.organizacao"
                                           placeholder="Organização" required>
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <label>Causas <span class="red">*</span></label>
                                <select class="form-control select2" multiple
                                        id="causas"
                                        ng-model="trab.causas"
                                        data-placeholder="Informe as causas da organização."
                                        style="width: 100%;">
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
                                <label>Cargo <span class="red">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-briefcase"></i>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Cargo" id="cargo" ng-model="trab.cargo" required>
                                </div>
                            </div>

                            <div class="col-xs-2">
                                <label>Início <span class="red">*</span></label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker"
                                           id="inicio" ng-model="trab.inicio" data-date-format="dd/mm/yyyy" required>
                                </div><!-- /.input group -->
                            </div>

                            <div class="col-xs-2">
                                <label>Fim <span class="red">*</span></label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker"
                                           ng-model="trab.fim"
                                           id="fim" data-date-format="dd/mm/yyyy">
                                </div><!-- /.input group -->
                            </div>

                            <div class="col-xs-2">
                                <label>Cargo Atual</label>
                                <div class="input-group">
                                    <input type="checkbox"
                                           class="bootstrapSwitch"
                                           id="bool_cargo_atual"
                                           data-on-text="Sim"
                                           data-off-text="Não" data-size="mini" ng-model="trab.boolAtual">
                                </div>
                            </div>

                            <div class="form-group" style="padding:20px; margin-top:50px;">
                                <a class="btn btn-info col-md-2 col-md-offset-10" ng-click="addTrabVoluntarios(trab.organizacao, trab.causas, trab.cargo, trab.inicio, trab.fim, trab.boolAtual)" promise-btn>
                                    Adicionar
                                    <i class="fa fa-plus" data-toggle="tooltip"
                                       data-placement="bottom" title="Adicionar"></i>
                                </a>
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
                        <tbody id="t_v_body">
                            <tr ng-repeat="voluntario in dadosUsuario.outros.voluntarios">
                                <td>{{voluntario.organizacao}}</td>
                                <td>{{voluntario.cargo}}</td>
                                <td>{{voluntario.causas}}</td>
                                <td>
                                    <a class="btn btn-info" href="#">
                                        <i class="fa fa-edit" data-toggle="tooltip"
                                           data-placement="bottom" title="Editar"></i>
                                    </a>
                                    <a class="btn btn-danger">
                                        <i class="fa fa-trash-o" data-toggle="tooltip"
                                           data-placement="bottom" title="Excluir" ng-click="pullMongo(voluntario, 'outros.voluntarios')"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="!dadosUsuario.outros.voluntarios || dadosUsuario.outros.voluntarios.length <= 0">
                                <td>Ainda não existem trabalhos voluntários cadastrados</td>
                                <td></td>
                                <td></td>
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
                                <textarea class="form-control" rows="8" id="perfilOutros"
                                          name="dados[sobre]"
                                          ng-value="dadosUsuario.outros.sobre"
                                          ng-model="outros.sobre"
                                          maxlength="1000"
                                          placeholder="Descreva como você é fora do ambiente de trabalho. Descreva suas atividades de final de semana. Informe o que você faz nas horas vagas."></textarea>
                            </div>
                            <div class="col-xs-3 col-xs-offset-9" style="text-align:right;">Faltam {{1000 - outros.sobre.length}} caracteres</div>
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
                                    <input type="text" class="form-control"
                                           id="youtubeOutros"
                                           ng-value="dadosUsuario.outros.youtube"
                                           name="dados[youtube]"
                                           placeholder="Insira aqui o link do seu perfil no YouTube">
                                    <span class="input-group-addon"><i
                                            class="fa fa-question-circle" data-toggle="tooltip"
                                            data-placement="bottom"
                                            title="Crie um breve vídeo do seu perfil no YouTube, contando como você é profissionalmente e pessoalmente.&#013;Crie um vídeo descontraido e mostrando todas suas qualidades pessoais.&#013;Copie a URL e cole aqui:&#013;Ex: https://www.youtube.com/watch?v=Gdxty2l6z2o"></i></span>
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
                        <button type="submit" class="btn btn-primary" ng-click="pushOutros()" promise-btn>Atualizar</button>
                    </div>
                </div>
            </div>
            </form>
        </div><!-- /.box -->
    </div><!-- /.row -->
</div><!-- /.tab-pane -->