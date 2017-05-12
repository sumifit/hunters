/**
 * Created by Bruno on 11/04/2017.
 */
var hunters = angular.module('hunters', ['angularPromiseButtons', 'angular-loading-bar', 'ngAlertify']);
hunters.constant("configs", {
    userController: "/application/controllers/UserController.php",
    agendaController: "/application/controllers/Agenda.php",
    caixaEntradaController: "/application/controllers/CaixaEntradaController.php",
    avaliacaoTecnicaController: "/application/controllers/AvaliacaoTecnicaController.php",
    vagasController: "/application/controllers/vagasController.php",
    msgExcluir: "Tem certeza que deseja excluir?"
});
hunters.factory('randomize', function() {
    return {
        random: function(input) {
            if (input!=null && input!=undefined && input > 1) {
                return Math.floor((Math.random()*input)+1);
            }
        }
    }
});
hunters.run(function ($rootScope, $http, configs, alertify) {
    //pega os dados gerais
    $http({
        method: 'POST',
        url: configs.userController,
        data: "action=getUsuarioData",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(function (data) {
        if (data.data.success == 0) {
            alertify.error(data.data.msg);
        } else {
            $rootScope.dadosUsuario = data.data.msg;

            $rootScope.gerafraseMembroDesde = function(){
                var monthNames = [
                    "Janeiro",
                    "Fevereiro",
                    "Março",
                    "Abril",
                    "Maio",
                    "Junho",
                    "Julho",
                    "Agosto",
                    "Setembro",
                    "Outubro",
                    "Novembro",
                    "Dezembro"
                ];

                var data = new Date(parseInt($rootScope.dadosUsuario.data_cadastro.$date.$numberLong));

                return "Membro desde " + monthNames[data.getMonth()] + " de " + data.getFullYear();
            }

            $rootScope.fraseMembroDesde = $rootScope.gerafraseMembroDesde();

            if(!!$rootScope.dadosUsuario.experiencia_profissional){
                for(i in $rootScope.dadosUsuario.experiencia_profissional){
                    if(!!$rootScope.dadosUsuario.experiencia_profissional[i].cargo_atual){
                        $rootScope.cargo_atual = $rootScope.dadosUsuario.experiencia_profissional[i].cargo;
                        return false;
                    }
                }
            }
        }
    });
    //pega os dados da agenda
    var getNoti = function()
    {
        if(window.location.href.indexOf('login') === -1){
            var action = "getNoti";

            var send = $http.post(configs.agendaController, "action=" + action,
                {
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                });

            send.then(function (data) {
                if (data.data.success == 0) {

                } else {
                    $rootScope.qtdCaixa = data.data.msg.caixa.length;
                    $rootScope.qtdAgenda = data.data.msg.agenda.length;
                    $rootScope.qtdAvaliacao = data.data.msg.avaliacao.length;
                }
            })
        }
    }

    setInterval(function(){
        getNoti();
    }, 2000)

    //cria a função para deslogar
    $rootScope.deslogar = function(){
        var action = "logout";

        var send = $http.post(configs.userController, "action=" + action,
            {
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });

        send.then(function (data) {
            if (data.data.success == 0) {

            } else {
                location.href = "/login.php";
            }
        })
    }
});

/*
* Diretiva para adicionar máscara da moeda brasileira (R$)
*
* O Parametro zero-filter="true" e para limpar os dados ao inserir o valor 0 ex: 0,00
* EX: <input  format="number" zero-filter="true" />
    * @author = "Marceloluk"
    * GitHub: https://github.com/MarceloLuk/angular-money-br-directive.git
*/
hunters.directive('format', ['$filter', function ($filter) {
    return {
        require: '?ngModel',
        link: function (scope, elem, attrs, ctrl) {
            if (!ctrl) return;

            ctrl.$formatters.unshift(function (a) {
                return $filter(attrs.format)(ctrl.$modelValue)
            });

            ctrl.$parsers.unshift(function (viewValue) {
                if (viewValue.length <= 3) {
                    viewValue = '00'+viewValue;
                }
                var value = viewValue;
                value = value.replace(/\D/g,"");
                value = value.replace(/(\d{2})$/,",$1");
                value = value.replace(/(\d+)(\d{3},\d{2})$/g,"$1.$2");
                var qtdLoop = (value.length-3)/3;
                var count = 0;
                while (qtdLoop > count)
                {
                    count++;
                    value = value.replace(/(\d+)(\d{3}.*)/,"$1.$2");
                }
                var plainNumber = value.replace(/^(0)(\d)/g,"$2");

                elem.val(plainNumber);
                return plainNumber;
            });

            elem.bind('blur', function () {
                var valueFilter = elem.val();
                valueFilter = valueFilter.replace(/\D/g,"");
                if (attrs.zeroFilter == 'true') {
                    if (valueFilter == 0) {
                        elem.val('');
                    }
                }
            });
        }
    };
}]);

hunters.directive('actualSrc', function () {
    return {
        link: function postLink(scope, element, attrs) {
            attrs.$observe('actualSrc', function (newVal, oldVal) {
                if (newVal != undefined) {
                    var img = new Image();
                    img.src = attrs.actualSrc;
                    angular.element(img).bind('load', function () {
                        element.attr("src", attrs.actualSrc);
                    });
                }
            });

        }
    }
});

hunters.config(function (angularPromiseButtonsProvider) {
    angularPromiseButtonsProvider.extendConfig({
        spinnerTpl: '<span class="fa fa-circle-o-notch btn-spinner"></span>',
        disableBtn: true,
        btnLoadingClass: 'is-loading',
        addClassToCurrentBtnOnly: false,
        disableCurrentBtnOnly: false,
        minDuration: false,
        CLICK_EVENT: 'click',
        CLICK_ATTR: 'ngClick',
        SUBMIT_EVENT: 'submit',
        SUBMIT_ATTR: 'ngSubmit',
        BTN_SELECTOR: 'button'
    });
});
hunters.directive('onlyDigits', function () {
    return {
        require: 'ngModel',
        restrict: 'A',
        link: function (scope, element, attr, ctrl) {
            function inputValue(val) {
                if (val) {
                    var digits = val.replace(/[^0-9]/g, '');

                    if (digits !== val) {
                        ctrl.$setViewValue(digits);
                        ctrl.$render();
                    }
                    return parseInt(digits,10);
                }
                return undefined;
            }
            ctrl.$parsers.push(inputValue);
        }
    };
});
hunters.directive('onlyFloats', function () {
    return {
        require: 'ngModel',
        restrict: 'A',
        link: function (scope, element, attr, ctrl) {
            function inputValue(val) {
                if (val) {
                    var digits = val.replace(/[^0-9.]/g, '');

                    if (digits.split('.').length > 2) {
                        digits = digits.substring(0, digits.length - 1);
                    }

                    if (digits !== val) {
                        ctrl.$setViewValue(digits);
                        ctrl.$render();
                    }
                    return parseFloat(digits);
                }
                return undefined;
            }
            ctrl.$parsers.push(inputValue);
        }
    };
});
hunters.factory('FormUtils', function () {
    return {
        validarRequireds: function (jqueryForm) {
            var flagInvalid = false;
            jqueryForm.find("textarea[required], select[required], input[required]").each(function (idx, val) {
                if (($(this).val() == "" || $(this).val().indexOf("undefined") !== -1)) {
                    $(this).addClass('invalidRequiredInput');
                    flagInvalid = true;
                    $(this).parent().parent().find('.required').css('display', 'block');
                } else if ($(this).hasClass("invalidRequiredInput")) {
                    $(this).removeClass("invalidRequiredInput")
                    $(this).parent().parent().find('.required').css('display', 'none');
                }
            });
            return flagInvalid;
        },
        //09 – VNumber Incluir validação de CPF
        validarCpf: function (cpf) {
            cpf = cpf.replace(/[^\d]+/g, '');
            if (cpf == '') return false;
            // Elimina CPFs invalidos conhecidos
            if (cpf.length != 11 ||
                cpf == "00000000000" ||
                cpf == "11111111111" ||
                cpf == "22222222222" ||
                cpf == "33333333333" ||
                cpf == "44444444444" ||
                cpf == "55555555555" ||
                cpf == "66666666666" ||
                cpf == "77777777777" ||
                cpf == "88888888888" ||
                cpf == "99999999999")
                return false;
            // Valida 1o digito
            add = 0;
            for (i = 0; i < 9; i++)
                add += parseInt(cpf.charAt(i)) * (10 - i);
            rev = 11 - (add % 11);
            if (rev == 10 || rev == 11)
                rev = 0;
            if (rev != parseInt(cpf.charAt(9)))
                return false;
            // Valida 2o digito
            add = 0;
            for (i = 0; i < 10; i++)
                add += parseInt(cpf.charAt(i)) * (11 - i);
            rev = 11 - (add % 11);
            if (rev == 10 || rev == 11)
                rev = 0;
            if (rev != parseInt(cpf.charAt(10)))
                return false;
            return true;
        },
        validarCnpj: function (cnpj) {
            cnpj = cnpj.replace(/[^\d]+/g, '');

            if (cnpj == '') return false;

            if (cnpj.length != 14)
                return false;

            // Elimina CNPJs invalidos conhecidos
            if (cnpj == "00000000000000" ||
                cnpj == "11111111111111" ||
                cnpj == "22222222222222" ||
                cnpj == "33333333333333" ||
                cnpj == "44444444444444" ||
                cnpj == "55555555555555" ||
                cnpj == "66666666666666" ||
                cnpj == "77777777777777" ||
                cnpj == "88888888888888" ||
                cnpj == "99999999999999")
                return false;

            // Valida DVs
            tamanho = cnpj.length - 2
            numeros = cnpj.substring(0, tamanho);
            digitos = cnpj.substring(tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2)
                    pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0))
                return false;

            tamanho = tamanho + 1;
            numeros = cnpj.substring(0, tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2)
                    pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1))
                return false;

            return true;
        },
        vtext1: function (selector) {
            //vtext1
            if(selector.val().length <= 15){
                return false;
            }
            return true;
        },
        //Executar o LTRIM e RTRIM antes de gravar
        vtext2: function (valor) {
            valor = ""+valor;
            return valor.trim();
        },
        //Não pode ser maior que a data atual;
        vdate5: function(selector){
            //vdate5
            var data = new Date(selector.val());
            var dataAtual = new Date();
            if(data > dataAtual){
                return false;
            }
            return true;
        },
        //A data deve ter no mínimo 14 anos de diferença da data atual.
        vdate6: function(selector){
            var data = new Date(selector.val());
            var dataAtual = new Date();

            if ( isNaN( data.getTime() ) ) {
                return false;
            }
            return !((dataAtual.getFullYear() - data.getFullYear()) < 14);

        },
        //A data não deve ser ano bissexto
        vdate7: function(){

        },
        //VNumber Campo do tipo Numérico Incluir validação de CEP
        vnumber11: function(selector){
            var objER = /^[0-9]{5}-[0-9]{3}$/;

            var strCEP = selector.val().trim();
            if(strCEP.length > 0)
            {
                return objER.test(strCEP);
            }
            else
                return false;
        },
        //data a não pode ser menor ou igual que a data b
        //a type [object Date]
        //b type [object Date]
        vdate15: function(a, b){
            return !(a <= b);
        },
        vnumber16: function(elemento, tamanho){
            var valor = elemento.inputmask('unmaskedvalue');
            if(valor.length >= 1){
                return (valor.length >= tamanho );
            }else{
                return true;
            }
        },
        setInvalid: function (element) {
            $(element).focus();
            $(element).addClass('invalidInput');
            $(element).parent().parent().find('.error').css('display', 'block');
        },
        setValid: function (element) {
            $(element).removeClass('invalidInput');
            $(element).parent().parent().find('.error').css('display', 'none');
        }
    }
});
hunters.directive('googlePlusSignin', ['$window', '$rootScope', function ($window, $rootScope) {
    var ending = /\.apps\.googleusercontent\.com$/;

    return {
        restrict: 'E',
        transclude: true,
        template: '<span></span>',
        replace: true,
        link: function (scope, element, attrs, ctrl, linker) {
            attrs.clientid += (ending.test(attrs.clientid) ? '' : '.apps.googleusercontent.com');
            attrs.$set('data-clientid', attrs.clientid);
            var defaults = {
                onsuccess: onSignIn,
                cookiepolicy: 'single_host_origin',
                onfailure: onSignInFailure,
                scope: 'profile email',
                longtitle: false,
                theme: 'dark',
                autorender: true,
                customtargetid: 'googlebutton'
            };

            defaults.clientid = attrs.clientid;

            // Overwrite default values if explicitly set
            angular.forEach(Object.getOwnPropertyNames(defaults), function (propName) {
                if (attrs.hasOwnProperty(propName)) {
                    defaults[propName] = attrs[propName];
                }
            });
            var isAutoRendering = (defaults.autorender !== undefined && (defaults.autorender === 'true' || defaults.autorender === true));
            if (!isAutoRendering && defaults.customtargetid === "googlebutton") {
                console.log("element", element);
                element[0].innerHTML =
                    '<div id="googlebutton">' +
                    ' <div class="google-icon"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 14 14" class="abcRioButtonSvg">' +
                    '   <g><path d="m7.228,7.958l-.661-.514c-.201-.166-.476-.386-.476-.79 0-.405 .275-.663 .513-.901 .769-.606 1.538-1.25 1.538-2.611 0-1.256-.632-1.862-.94-2.24h.899l.899-.902h-3.622c-.989,0-2.235,.147-3.278,1.01-.788,.68-1.172,1.618-1.172,2.464 0,1.433 1.098,2.885 3.04,2.885 .183,0 .384-.018 .586-.036-.092,.22-.183,.405-.183,.717 0,.569 .048,.809 .305,1.14-.824,.055-2.119,.12-3.254,.819-1.082,.644-1.411,1.717-1.411,2.379 0,1.361 1.281,2.629 3.938,2.629 3.149,0 4.816-1.747 4.816-3.474 .001-1.269-.731-1.894-1.537-2.575zm-4.689-5.384c0-.479 .091-.975 .402-1.361 .293-.368 .806-.607 1.283-.607 1.519,0 2.306,2.06 2.306,3.383 0,.33-.037,.918-.457,1.341-.294,.295-.786,.515-1.244,.515-1.575,0-2.29-2.041-2.29-3.271zm2.308,10.66c-1.96,0-3.224-.938-3.224-2.243s1.063-1.691 1.466-1.839c.77-.256 1.788-.348 1.788-.348s.456,.026 .665,.019c1.115,.546 1.997,1.487 1.997,2.428 0,1.138-.935,1.983-2.692,1.983z"></path></g>' +
                    ' </svg></div>' +
                    ' <div class="sign-in-text">Sign in</div>' +
                    '</div>';
            }

            // Default language
            // Supported languages: https://developers.google.com/+/web/api/supported-languages
            attrs.$observe('language', function (value) {
                $window.___gcfg = {
                    lang: value ? value : 'en'
                };
            });

            // Some default values, based on prior versions of this directive
            function onSignIn(authResult) {
                $rootScope.$broadcast('event:google-plus-signin-success', authResult);
            };
            function onSignInFailure() {
                $rootScope.$broadcast('event:google-plus-signin-failure', null);
            };

            // Asynchronously load the G+ SDK.
            var po = document.createElement('script');
            po.type = 'text/javascript';
            po.async = true;
            po.src = 'https://apis.google.com/js/client:platform.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(po, s);

            linker(function (el, tScope) {
                po.onload = function () {
                    $rootScope.gapi = gapi;

                    if (el.length) {
                        element.append(el);
                    }
                    //Initialize Auth2 with our clientId
                    gapi.load('auth2', function () {
                        var googleAuthObj =
                            gapi.auth2.init({
                                client_id: defaults.clientid,
                                cookie_policy: defaults.cookiepolicy
                            });

                        if (isAutoRendering) {
                            gapi.signin2.render(element[0], defaults);
                        } else {
                            googleAuthObj.attachClickHandler(defaults.customtargetid, {}, defaults.onsuccess, defaults.onfailure);
                        }
                    });
                };
            });

        }
    }
}])
    .run();