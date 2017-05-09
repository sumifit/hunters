<div class="tab-pane" id="formacao_academica">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Informe seu histórico acadêmico </h3>
                </div>
                <!-- formacao academica -->
                <form id="formacaoAcademicaForm" name="formacaoAcademicaForm" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-8">
                                    <label>Instituição <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-home"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="instituicaoAcademica"
                                               ng-value="dadosUsuario.formacao_academica.instituicao"
                                               ng-model="formInstituicao"
                                               name="dados[instituicao]"
                                               placeholder="Instituição"
                                               required>
                                    </div>
                                    <small class="form-error required">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-4">
                                    <label>Grau de Escolaridade <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-balance-scale"></i>
                                        </div>
                                        <select class="form-control"
                                                id="grauAcademico"
                                                ng-value="dadosUsuario.formacao_academica.grau_escolaridade"
                                                ng-model="formGrauEscolaridade"
                                                name="dados[grau_escolaridade]"
                                                required>
                                        <option ng-repeat="(chave, valor) in dominios.escolaridade">{{valor.grau_escolaridade}}</option>
                                        </select>
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-8">
                                    <label>Curso <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-graduation-cap"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="cursoAcademico"
                                               ng-value="dadosUsuario.formacao_academica.curso"
                                               ng-model="formCurso"
                                               placeholder="Curso" name="dados[curso]"
                                               required>
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-2">
                                    <label>Data de Conclusão <span class="red">*</span></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right datepicker"
                                               name="dados[data_conclusao]"
                                               ng-value="dadosUsuario.formacao_academica.data_conclusao"
                                               id="dataConclusaoAcademica" data-date-format="dd/mm/yyyy" required>
                                    </div><!-- /.input group -->
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-2">
                                    <label>Cursando </label>
                                    <div class="input-group">
                                        <input type="checkbox"
                                               id="boolCursandoAcademica"
                                               class="bootstrapSwitch"
                                               data-on-text="Sim" data-off-text="Não"
                                               data-size="mini" value="true"
                                               ng-value="dadosUsuario.formacao_academica.cursando"
                                               ng-model="formCursando"
                                               name="dados[cursando]">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label>Descrição</label>
                                    <textarea class="form-control" rows="8" id="descricaoAcademica"
                                              name="dados[descricao]"
                                              ng-value="dadosUsuario.formacao_academica.descricao"
                                              ng-model="formDesc"
                                              placeholder="Informe uma descrição relevante à sua formação" maxlength="800"></textarea>
                                </div>
                                <div class="col-xs-3 col-xs-offset-9" style="text-align:right;">Faltam {{800 - formDesc.length}} caracteres</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <a type="submit" class="btn btn-primary" ng-click="pushFormacaoAcademica()" promise-btn>Atualizar
                                    </a>
                                </div>
                            </div>
                        </div>
                </form>
            </div>

            <div class="box box-primary">
                <div class="box-body">
                    <table id="historico_academico"
                           class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Instituição</th>
                            <th>Curso</th>
                            <th>Opções</th>
                        </tr>
                        </thead>
                        <tbody id="formacao_body">
                            <tr ng-repeat="formacao in dadosUsuario.formacao_academica">
                                <td>{{formacao.instituicao}}</td>
                                <td>{{formacao.curso}}</td>
                                <td>
                                    <a class="btn btn-info" href="#">
                                        <i class="fa fa-edit" data-toggle="tooltip"
                                           data-placement="bottom" title="Editar"></i>
                                    </a>
                                    <a class="btn btn-danger">
                                        <i class="fa fa-trash-o" data-toggle="tooltip"
                                           data-placement="bottom" title="Excluir" ng-click="pullFormacaoAcademica(formacao)"></i>
                                    </a>
                                </td>
                            </tr>
                        <tr ng-if="!dadosUsuario.formacao_academica || dadosUsuario.formacao_academica.length <= 0">
                            <td>Ainda não existem formações cadastradas</td>
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