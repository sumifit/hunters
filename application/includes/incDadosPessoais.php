<div class="active tab-pane" id="dados_pessoais">
    <div class="row">
        <div class="col-md-12">
            <form id="formDadosPessoais" name="formDadosPessoais" method="post">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informe seus dados pessoais</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>Nome <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>

                                        <input type="text" class="form-control"
                                               placeholder="Nome"
                                               id="nomeCandidato"
                                               ng-value="dadosUsuario.nome"
                                               ng-model="dadosPessoais.nome"
                                               name="dados[nome]" required>
                                    </div>
                                    <small class="error form-error">Mínimo de 15 caracteres</small>
                                </div>

                                <div class="col-xs-4">
                                    <label>RG <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="rgCandidato"
                                               ng-value="dadosUsuario.candidato.rg"
                                               ng-model="dadosPessoais.rg"
                                               name="dados[candidato][rg]" placeholder="RG" maxlength="20" required>
                                    </div><!-- /.input group -->
                                    <small class="error form-error" style="display:none;">RG inválido</small>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-2">
                                    <label>Dígito <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <input type="number" class="form-control"
                                               id="digitoCandidato"
                                               ng-value="dadosUsuario.candidato.digito"
                                               ng-model="dadosPessoais.digito"
                                               name="dados[candidato][digito]"
                                               placeholder="Dígito" maxlength="5" required>
                                    </div><!-- /.input group -->
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">

                                <div class="col-xs-3">
                                    <label>Data de Expedição <span class="red">*</span></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right datepicker"
                                               id="dataExpCandidato"
                                               ng-value="dadosUsuario.candidato.data_expedicao"
                                               ng-model="dadosPessoais.data_expedicao"
                                               name="dados[candidato][data_expedicao]" data-date-format="dd/mm/yyyy" required>
                                    </div><!-- /.input group -->
                                    <small class="error form-error" style="display:none;">A data de expedição não deve ser maior que a atual</small>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-3">
                                    <label>CPF <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="CPFCandidato"
                                               ng-value="dadosUsuario.cpf"
                                               name="dados[cpf]"
                                               ng-model="dadosPessoais.cpf"
                                               data-inputmask="'mask': ['999.999.999[-99]','999.999.999[-99']"
                                               data-mask placeholder="CPF" required>
                                    </div><!-- /.input group -->
                                    <small class="error form-error" style="display:none;">CPF inválido</small>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-3">
                                    <label>Nacionalidade</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-flag"></i>
                                        </div>
                                        <!--<input type="text" class="form-control"
                                               id="nacionalidadeCandidato"
                                               ng-value="dadosUsuario.candidato.nacionalidade"
                                               ng-model="dadosPessoais.nacionalidade"
                                               name="dados[candidato][nacionalidade]"
                                               placeholder="Nacionalidade">-->
                                        <select class="form-control" id="nacionalidadeCandidato" name="dados[candidato][nacionalidade]" ng-value="dadosUsuario.candidato.nacionalidade" ng-model="dadosPessoais.nacionalidade">
                                            <option value="">Selecione</option>
                                            <option ng-repeat="(chave, valor) in dominios.nacionalidade">{{valor.nacionalidade_m}}</option>
                                            <option ng-repeat="(c, v) in dominios.nacionalidade">{{v.nacionalidade_f}}</option>
                                        </select>
                                    </div>
                                    <small class="error form-error" style="display:none;">CPF inválido</small>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label>Sexo</label>
                                        <div class="radio">
                                            <i class="fa fa-venus-mars"></i>
                                            <label>
                                                <input type="radio" name="optionsRadios"
                                                       id="sexom" value="m"
                                                       checked>
                                                Masculino
                                            </label>
                                            <label>
                                                <input type="radio" name="optionsRadios"
                                                       id="sexof" value="f">
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
                                        <input type="text" class="form-control"
                                               id="nomePaiCandidato"
                                               ng-value="dadosUsuario.candidato.nome_pai"
                                               ng-model="dadosPessoais.nome_pai"
                                               name="dados[candidato][nome_pai]"
                                               placeholder="Nome do Pai">
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <label>Nome da Mãe <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="nomeMaeCandidato"
                                               ng-value="dadosUsuario.candidato.nome_mae"
                                               ng-model="dadosPessoais.nome_mae"
                                               name="dados[candidato][nome_mae]"
                                               placeholder="Nome da Mãe" required>
                                    </div>
                                    <small class="error form-error" style="display:none;">Mínimo 15 caracteres</small>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label>Data de Nascimento <span class="red">*</span></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right datepicker"
                                               id="dataNascimentoCandidato"
                                               ng-value="dadosUsuario.candidato.data_nascimento"
                                               ng-model="dadosPessoais.data_nascimento"
                                               name="dados[candidato][data_nascimento]" data-date-format="dd/mm/yyyy" required>
                                    </div><!-- /.input group -->
                                    <small class="error form-error" style="display:none;">Idade mínima 14 anos</small>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-4">
                                    <!-- select -->
                                    <div class="form-group">
                                        <label>Estado Civil <span class="red">*</span></label>
                                        <select class="form-control"
                                                id="estadoCivilCandidato"
                                                ng-value="dadosUsuario.candidato.estado_civil"
                                                ng-model="dadosPessoais.estado_civil"
                                                name="dados[candidato][estado_civil]" required>
                                            <option value="">Selecione</option>
                                            <option ng-repeat="(chave, valor) in dominios.estado_civil">{{valor.estado_civil}}</option>
                                        </select>
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-4">
                                    <!-- phone mask -->
                                    <div class="form-group">
                                        <label>Telefone </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input type="text" class="form-control"
                                                   id="telefoneCandidato"
                                                   ng-value="dadosUsuario.candidato.telefone"
                                                   name="dados[candidato][telefone]"
                                                   ng-model="dadosPessoais.telefone"
                                                   data-inputmask='"mask": "(099) 9999-9999"'
                                                   data-mask>
                                        </div><!-- /.input group -->
                                    </div><!-- /.form group -->
                                    <small class="error form-error" style="display:none;">Telefone Inválido</small>
                                </div>

                            </div>
                        </div><!-- /.form group -->

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-4">
                                    <!-- phone mask -->
                                    <label>Celular <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="celularCandidato"
                                               ng-value="dadosUsuario.candidato.celular"
                                               ng-model="dadosPessoais.celular"
                                               name="dados[candidato][celular]"
                                               data-inputmask='"mask": "(099) 99999-9999"'
                                               data-mask required>
                                    </div><!-- /.input group -->
                                    <small class="error form-error" style="display:none;">Celular inválido</small>
                                </div>

                                <div class="col-xs-8">
                                    <label>E-mail <span class="red">*</span></label>
                                    <div class="input-group">
                                                                    <span class="input-group-addon"><i
                                                                            class="fa fa-envelope"></i></span>
                                        <input type="email" class="form-control"
                                               id="emailCandidato"
                                               ng-value="dadosUsuario.email"
                                               ng-model="dadosPessoais.email"
                                               name="dados[email]"
                                               placeholder="Email" required>
                                    </div>
                                    <small class="error form-error" style="display:none;">Email inválido</small>
                                </div>

                            </div>
                        </div><!-- /.form group -->

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-8">
                                    <label>WebSite</label>
                                    <div class="input-group">
                                                                    <span class="input-group-addon"><i
                                                                            class="fa fa-internet-explorer"></i></span>
                                        <input type="text" class="form-control"
                                               id="webSiteCandidato"
                                               ng-value="dadosUsuario.candidato.website"
                                               ng-model="dadosPessoais.website"
                                               name="dados[candidato][website]"
                                               placeholder="WebSite">
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <label>CEP <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-university"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="cepCandidato"
                                               ng-value="dadosUsuario.endereco.cep"
                                               ng-model="dadosPessoais.cep"
                                               name="dados[endereco][cep]"
                                               data-inputmask='"mask": "99999-999"'
                                               data-mask required>
                                    </div><!-- /.input group -->
                                    <small class="error form-error" style="display:none;">CEP inválido</small>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                            </div>
                        </div><!-- /.form group -->

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>Endereço <span class="red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-home"></i>
                                        </div>
                                        <input type="text" class="form-control"
                                               id="enderecoCandidato"
                                               ng-value="dadosUsuario.endereco.endereco"
                                               ng-model="dadosPessoais.endereco"
                                               name="dados[endereco][endereco]"
                                               placeholder="Endereço" readonly="readonly" required>
                                    </div>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-2">
                                    <label>Número <span class="red">*</span></label>
                                    <input type="number" class="form-control"
                                           id="numeroCandidato"
                                           ng-value="dadosUsuario.endereco.numero"
                                           ng-model="dadosPessoais.numero"
                                           name="dados[endereco][numero]"
                                           placeholder="Número" required>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-4">
                                    <label>Complemento </label>
                                    <input type="text" class="form-control"
                                           id="complementoCandidato"
                                           ng-value="dadosUsuario.endereco.complemento"
                                           ng-model="dadosPessoais.complemento"
                                           name="dados[endereco][complemento]"
                                           placeholder="Complemento">
                                </div>

                            </div>
                        </div><!-- /.form group -->

                        <div class="form-group">
                            <div class="row">

                                <div class="col-xs-3">
                                    <label>Bairro <span class="red">*</span></label>
                                    <input type="text" class="form-control"
                                           id="bairroCandidato"
                                           ng-value="dadosUsuario.endereco.bairro"
                                           ng-model="dadosPessoais.bairro"
                                           name="dados[endereco][bairro]"
                                           placeholder="Bairro" readonly="readonly" required>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>


                                <div class="col-xs-3">
                                    <label>Cidade <span class="red">*</span></label>
                                    <input type="text" class="form-control"
                                           id="cidadeCandidato"
                                           ng-value="dadosUsuario.endereco.cidade"
                                           ng-model="dadosPessoais.cidade"
                                           name="dados[endereco][cidade]"
                                           placeholder="Cidade" readonly="readonly" required>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-2">
                                    <label>Estado <span class="red">*</span></label>
                                    <select class="form-control"
                                            id="estadoCandidato"
                                            ng-value="dadosUsuario.endereco.estado"
                                            ng-model="dadosPessoais.estado"
                                            name="dados[endereco][estado]" readonly="readonly" required>
                                        <option value="">Selecione</option>
                                        <option ng-repeat="(chave, valor) in dominios.estados">{{valor.estado}}</option>
                                    </select>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                                <div class="col-xs-4">
                                    <label>Pais <span class="red">*</span></label>
                                    <select class="form-control"
                                            id="paisCandidato"
                                            ng-value="dadosUsuario.endereco.pais"
                                            ng-model="dadosPessoais.pais"
                                            name="dados[endereco][pais]" readonly="readonly" required>
                                        <option value="">Selecione</option>
                                        <option value="Brasil">Brasil</option>
                                    </select>
                                    <small class="form-error required" style="display:none;">Campo obrigatório</small>
                                </div>

                            </div>
                        </div><!-- /.form group -->

                        <div class="form-group">
                            <div class="row">

                                <div class="col-xs-12">
                                    <label>É PCD?</label>
                                    <div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" class="bootstrapSwitch"
                                                               data-on-text="Sim" data-off-text="Não" data-size="mini"
                                                               id="pcd">
													</span>
                                        <input type="text" class="form-control"
                                               placeholder="Informe a deficiência física aqui"
                                               name="dados[candidato][pcd]" id="pcd_motivo"
                                               ng-value="dadosUsuario.candidato.pcd"
                                               ng-model="dadosPessoais.pcd"
                                               disabled="disabled">
                                    </div>
                                </div>

                            </div>
                        </div><!-- /.form group -->

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <a class="btn btn-primary" ng-click="enviarDadosPessoais()" promise-btn>
                                        Atualizar
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
            </form>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.row -->
</div><!-- /.tab-pane -->