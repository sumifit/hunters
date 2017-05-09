<div class="tab-pane" id="certificacoes">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Informe suas Certificações</h3>
                </div>

                <div class="box-body">
                    <form id="certificacoesForm" name="certificacoesForm" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>Instituição <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-home"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="instituicaoCert"
                                               name="dados[instituicao]"
                                               ng-model="certificacoes.instituicao"
                                               placeholder="Instituição" required>
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-6">
                                    <label>Certificado <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-graduation-cap"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="certificadoCert"
                                               name="dados[certificado]"
                                               ng-model="certificacoes.certificado"
                                               placeholder="Certificado" required>
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-3">
                                    <label>Número da Licença <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-book"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="nlicencaCert"
                                               name="dados[n_licenca]"
                                               ng-model="certificacoes.licenca"
                                               placeholder="Número da Licença" required>
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-3">
                                    <label>Data de Conclusão <span class="red">*</span></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right datepicker"
                                               name="dados[data_conclusao]"
                                               ng-model="certificacoes.dataConclusao"
                                               id="dataConclusaoCert" data-date-format="dd/mm/yyyy" required>
                                    </div><!-- /.input group -->
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-6">
                                    <label>URL do Certificado <span class="red">*</span></label>
                                    <div class="input-group">
                                                            <span class="input-group-addon"><i
                                                                    class="fa fa-internet-explorer"></i></span>
                                        <input type="email" class="form-control"
                                               id="urlCert"
                                               name="dados[url_certificado]"
                                               ng-model="certificacoes.UrlCertificado"
                                               placeholder="URL do Certificado" required>
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label>Descrição</label>
                                    <textarea class="form-control" rows="8" name="dados[descricao]"
                                              ng-model="certificacoes.descricao"
                                              id="descCert"
                                              placeholder="Informe uma descrição relevante referente ao curso"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <a type="submit" class="btn btn-primary" ng-click="pushCertificacoes()" promise-btn>Atualizar</a>
                                </div>
                            </div>
                        </div>

                </div>
                </form>

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
                            <tbody id="certificacoes_body">
                                <tr ng-repeat="certificacao in dadosUsuario.certificacoes">
                                    <td>{{certificacao.instituicao}}</td>
                                    <td>{{certificacao.certificado}}</td>
                                    <td>
                                        <a class="btn btn-info" href="#">
                                            <i class="fa fa-edit" data-toggle="tooltip"
                                               data-placement="bottom" title="Editar"></i>
                                        </a>
                                        <a class="btn btn-danger">
                                            <i class="fa fa-trash-o" data-toggle="tooltip"
                                               data-placement="bottom" title="Excluir" ng-click="pullMongo(certificacao, 'certificacoes')"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr ng-if="!dadosUsuario.certificacoes || dadosUsuario.certificacoes.length <= 0">
                                    <td>Ainda não existem certificações cadastradas</td>
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