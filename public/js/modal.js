var vModalRegister = new Vue({
    el : '#modal-register',
    data : {
        showRegister : false,
        fullname_error : '',
        email_error : '',
        password_error : '',
        confirm_error : '',
        captcha_error : '',
        message : '',
        validating : false
    },
    methods : {
        setShowRegister : function(param){
            this.showRegister = param;
            $('#modal-register').find('input:text, input:password').val('');
        },
        reset : function(){
            this.fullname_error = '';
            this.email_error = '';
            this.password_error = '';
            this.confirm_error = '';
            this.captcha_error = '';
            this.message = '';
        },
        register : function(){
            let vm = this;
            this.validating = true;
            vm.reset();
            $.ajax({
                url : '/api/register',
                type : 'post',
                data : {
                    fullname : $('input[name="regis-fullname"]').val(),
                    email : $('input[name="regis-email"]').val(),
                    password : $('input[name="regis-password"]').val(),
                    confirm : $('input[name="regis-confirm-password"]').val(),
                    captcha : grecaptcha.getResponse(recaptcha_register),
                },
                success : function(response){
                    vm.validating = false;        
                    if(response.type == 'error'){
                        let errors = response.errors;
                        if(errors.fullname != undefined){
                            vm.fullname_error = errors.fullname[0];
                        }
                        if(errors.email != undefined){
                            vm.email_error = errors.email[0];
                        }
                        if(errors.password != undefined){
                            vm.password_error = errors.password[0];
                        }
                        if(errors.confirm != undefined){
                            vm.confirm_error = errors.confirm[0];
                        }
                        if(errors.captcha != undefined){
                            vm.captcha_error = errors.captcha[0];
                        }
                    }
                    else{
                        vm.message = response.message;
                    }
                }
            });
        }
    }
});

var vModalLogin = new Vue({
    el : '#modal-login',
    data : {
        failLogin : 0,
        showLogin : false,
        showLoginCaptcha : false,
        login_email_error : '',
        login_password_error : '',
        login_captcha_error : '',
        validating : false,
        message : '',
        resend : false,
    },
    methods : {
        setShowLogin : function(param){
            this.showLogin = param;
            $('#modal-login').find('input:text, input:password').val('');
        },
        doResend : function(){
            let vm = this;
            this.reset();
            this.validating = true;
            $.ajax({
                url : '/api/resend',
                type : 'post',
                data : {
                    email : $('input[name="login-email"]').val()
                },
                success : function(){
                    vm.validating = false;
                    vm.message = 'sudah dikirim';
                }
            });
        },
        reset : function(){
            this.login_email_error = '';
            this.login_password_error = '';
            this.login_captcha_error = '';
            this.message = '';
            this.resend = false;
        },
        login : function(){
            let vm = this;
            this.validating = true;
            this.reset();

            let request = {
                mauCaptcha : 'gak',
                email : $('input[name="login-email"]').val(),
                password : $('input[name="login-password"]').val(),
                remember : $('#remember').prop('checked'),
                _token: $('#token-login').val(),
            };
            if(vm.showLoginCaptcha){
                request['captcha'] = grecaptcha.getResponse(recaptcha_login);
                request['mauCaptcha'] = 'mau';
            }

            ajax('/login', 'get', request)
            .done(response => {
                vm.validating = false;
                let errors = response.errors;
                if(errors != undefined){
                    vm.failLogin++;
                    if(vm.failLogin == 5)
                        vm.showLoginCaptcha = true;
                    if(errors.email != undefined)
                        vm.login_email_error = errors.email[0];
                    if(errors.password != undefined)
                        vm.login_password_error = errors.password[0];
                    if(errors.captcha != undefined)
                        vm.login_captcha_error = errors.captcha[0];
                }
                else{
                    let type = response.type;
                    let message = response.message;

                    if(type == 'success'){
                        vm.message = message;
                        $.get('/getLoggedUser', response => {
                            vNav.role = response.role;
                            vNav.refresh();
                            if(vNav.role == 'admin'){
                                window.location.href = '/chat';
                            }else if(window.location.href.endsWith('companyDetail')){
                                vCompanyDetail.refresh();
                            }else if(window.location.href.endsWith('company')){
                                vCompany.refresh();
                            }
                        });
                        hideModal();
                        return;
                    }

                    if(type == 'not confirmed') vm.resend = true;
                    vm.message = message;
                }
            });
        }
    }
});


$(window).on('click', e => {
    if(e.target.id != 'open-drop-down' && vNav.drop_down)
        vNav.drop_down = false;
    if(e.target.id != 'open-drop-down-language' && vNav.drop_down_language)
        vNav.drop_down_language = false;
    if(e.target.id != 'notif-click' && vNav.drop_down_notif)
        vNav.drop_down_notif = false;
});

