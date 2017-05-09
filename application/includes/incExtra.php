<div class="tab-pane" id="cursos_extra_curriculares">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Informe seus Cursos Extra Curriculares</h3>
                </div>
                <form id="extraCurriculares" name="extraCurriculares" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label>Instituição <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-home"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="instituicaoExtra"
                                               name="dados[instituicao]"
                                               ng-model="extraInstituicao"
                                               required
                                               placeholder="Instituição">
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-4">
                                    <label>Curso <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-graduation-cap"></i>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Curso"
                                               id="cursoExtra"
                                               ng-model="extraCurso"
                                               required
                                               name="dados[curso]">
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-2">
                                    <label>Total de Horas <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               name="dados[total_horas]"
                                               required
                                               ng-model="extraTotalHoras"
                                               id="totalHorasExtra"
                                               only-digits
                                               maxlength="4"
                                               placeholder="Total de horas">
                                    </div><!-- /.input group -->
                                    <small class="error form-error" style="display:none;">RG inválido</small>
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
                                               ng-model="extraDataConclusao"
                                                   id="dataConclusaoExtra" required>
                                    </div><!-- /.input group -->
                                    <small class="form-error error" style="display:none;">Deve ser menor que a data atual</small>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                            </div>

                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label>Descrição</label>
                                    <textarea class="form-control" rows="8" name="dados[descricao]"
                                              ng-model="extraDescricao"
                                              id="descricaoExtra"
                                              placeholder="Informe uma descrição relevante referente ao curso"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <a type="submit" class="btn btn-primary" ng-click="pushExtraCurriculares()" promise-btn>Atualizar</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="curso_extra_curricular"
                               class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Instituição</th>
                                <th>Curso</th>
                                <th>Opções</th>
                            </tr>
                            </thead>
                            <tbody id="extra_body">
                                <tr ng-repeat="extra in dadosUsuario.curso_extra">
                                    <td>{{extra.instituicao}}</td>
                                    <td>{{extra.curso}}</td>
                                    <td>
                                        <a class="btn btn-info" href="#">
                                            <i class="fa fa-edit" data-toggle="tooltip"
                                               data-placement="bottom" title="Editar"></i>
                                        </a>
                                        <a class="btn btn-danger">
                                            <i class="fa fa-trash-o" data-toggle="tooltip"
                                               data-placement="bottom" title="Excluir" ng-click="pullMongo(extra, 'curso_extra')"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr ng-if="!dadosUsuario.curso_extra || dadosUsuario.curso_extra.length <= 0">
                                    <td>Ainda não existem cursos extras cadastrados</td>
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