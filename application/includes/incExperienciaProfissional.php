<div class="tab-pane" id="experiencia_profissional">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Informe seu histórico Profissional </h3>
                </div>
                <form id="experienciaProfissionalForm" name="experienciaProfissionalForm" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>Empresa <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa  fa-industry"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="empresaExp"
                                               name="dados[empresa]"
                                               ng-model="experiencia.empresa"
                                               placeholder="Empresa"
                                               required>
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-3">
                                    <label>Localidade <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-home"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="localidadeExp"
                                               name="dados[localidade]"
                                               ng-model="experiencia.localidade"
                                               placeholder="Localidade"
                                               required>
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-3">
                                    <label>Segmento <span class="red">*</span></label>
                                    <select class="form-control select2" multiple="multiple"
                                            id="segmentoExp"
                                            name="dados[segmento]"
                                            ng-model="experiencia.segmento"
                                            data-placeholder="Segmento da empresa"
                                            style="width:
                                                    100%;" required>
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
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
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
                                        <input type="text" class="form-control" placeholder="Cargo"
                                               id="cargoExp"
                                               name="dados[cargo]"
                                               required
                                               ng-model="experiencia.cargo">
                                    </div>
                                </div>

                                <div class="col-xs-2">
                                    <label>Início <span class="red">*</span></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right datepicker"
                                               name="dados[data_inicio]"
                                               ng-model="experiencia.dataInicio"
                                               id="inicioExp" data-date-format="dd/mm/yyyy" required>
                                    </div><!-- /.input group -->
                                    <small class="error form-error" style="display:none;">A data não pode ser maior que a atual</small>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-2">
                                    <label>Fim</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right datepicker"
                                               name="dados[data_fim]"
                                               ng-model="experiencia.dataFim"
                                               data-date-format="dd/mm/yyyy"
                                               id="fimExp">
                                    </div><!-- /.input group -->
                                </div>

                                <div class="col-xs-2">
                                    <label>Cargo Atual</label>
                                    <div class="input-group">
                                        <input class="bootstrapSwitch" type="checkbox"
                                               name="dados[cargo_atual]"
                                               ng-model="experiencia.cargoAtual"
                                               id="boolCargoAtualExp"
                                               data-on-text="Sim" data-off-text="Não"
                                               data-size="mini" value="true">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label>Atividades <span class="red">*</span></label>
                                    <textarea class="form-control" rows="8" name="dados[atividades]"
                                              ng-model="experiencia.atividades"
                                              required
                                              id="atividadesExp"
                                              placeholder="Descreva as atividades exercidas no projeto"></textarea>
                                </div>
                                <small class="form-error required" style="display:none;">Campo obrigatório</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">

                                <div class="col-xs-6">
                                    <label>WebSite da Empresa <span class="red">*</span></label>
                                    <div class="input-group">
                                                            <span class="input-group-addon"><i
                                                                    class="fa fa-internet-explorer"></i></span>
                                        <input type="text" class="form-control"
                                               id="websiteExp"
                                               name="dados[website]"
                                               ng-model="experiencia.website"
                                               required
                                               placeholder="WebSite">
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-6">
                                    <label>Habilidades <span class="red">*</span></label>
                                    <select class="form-control select2" multiple="multiple"
                                            id="habilidadesExp"
                                            name="dados[habilidade]"
                                            ng-model="experiencia.habilidades"
                                            data-placeholder="Descreva as ferramentas com qual você atuou
                                                        neste projeto" style="width: 100%;" required>
                                        <option ng-repeat="(chave, valor) in dominios.habilidades">{{valor.tecnologia}}</option>
                                    </select>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>
                            </div>
                        </div><!-- /.form-group -->

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>Forma de Contratação <span class="red">*</span></label>
                                    <select class="form-control" id="formaExp" name="dados[forma_contratacao]" ng-model="experiencia.formaContratacao" required>
                                        <option value="">Selecione</option>
                                        <option ng-repeat="(chave, valor) in dominios.formas_contratacao">{{valor.forma_contratacao}}</option>
                                    </select>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-6">
                                    <label>Último Salário <span class="red">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon">R$</span>
                                        <input type="text" class="form-control"
                                               id="pretensaoExp"
                                               name="dados[ultimo_salario]"
                                               ng-model="experiencia.pretensaoSalarial"
                                               required
                                               placeholder="Informe sua pretensão salarial" format="number" zero-filter="true">
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>
                            </div>
                        </div><!-- /.form-group -->


                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <a type="submit" class="btn btn-primary" ng-click="pushExperienciaProfissional()" promise-btn>Atualizar</a>
                                </div>
                            </div>
                        </div>
                </form>
            </div>

            <div class="box box-primary">
                <div class="box-body">
                    <table id="historico_profissional"
                           class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Cargo</th>
                            <th>Opções</th>
                        </tr>
                        </thead>
                        <tbody id="exp_body">
                        <tr ng-repeat="experiencia in dadosUsuario.experiencia_profissional">
                            <td>{{experiencia.empresa}}</td>
                            <td>{{experiencia.cargo}}</td>
                            <td>
                                <a class="btn btn-info" href="#">
                                    <i class="fa fa-edit" data-toggle="tooltip"
                                       data-placement="bottom" title="Editar"></i>
                                </a>
                                <a class="btn btn-danger">
                                    <i class="fa fa-trash-o" data-toggle="tooltip"
                                       data-placement="bottom" title="Excluir" ng-click="pullMongo(experiencia, 'experiencia_profissional')"></i>
                                </a>
                            </td>
                        </tr>
                        <tr ng-if="!dadosUsuario.experiencia_profissional || dadosUsuario.experiencia_profissional.length <= 0">
                            <td>Ainda não existem experiências profissionais cadastradas</td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box-body -->

        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.row -->
</div><!-- /.tab-pane -->