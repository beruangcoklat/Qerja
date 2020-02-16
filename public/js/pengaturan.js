var vPengaturan = new Vue({
    el : '#content',
    data : {
        activeMenu : 'profile',
        loading : false,
        message : '',
        user_image : '',
        error_old : '',
        error_new : '',
        error_confirm : '',
        error_upload : ''
    },
    created : function(){
        let vm = this;
        $.get('/getLoggedUser', response => {
            vm.user_image = response.user.image;
        });
    },
    methods : {
        getActive : function(param){
            return this.activeMenu == param;
        },
        setActive : function(param){
            this.activeMenu = param;
            this.reset();
        },
        reset : function(){
            this.loading = false;
            this.message = '';
            this.error_old = '';
            this.error_new = '';
            this.error_confirm = '';
            this.error_upload = '';
        },
        updatePassword : function(){
            let vm = this;
            this.reset();

            let old_password = $("input[name='old-password']").val();
            let new_password = $("input[name='new-password']").val();
            let confirm_password = $("input[name='confirm-password']").val();
            let token = $('#token-update-password').val();

            $.ajax({
                url : '/updatePassword',
                type : 'post',
                data : {
                    old : old_password,
                    new : new_password,
                    confirm : confirm_password,
                    _token : token
                },
                beforeSend : function(){
                    this.loading = true;
                },
                success : function(response){
                    vm.loading = false;
                    let type = response.type;
                    if(type == 'error')
                    {
                        let errors = response.errors;
                        if(errors.old != undefined) vm.error_old = errors.old[0];
                        if(errors.new != undefined) vm.error_new = errors.new[0];
                        if(errors.confirm != undefined) vm.error_confirm = errors.confirm[0];
                    }
                    else if(type == 'wrong password'){
                        vm.error_old = response.message;
                    }
                    else{
                        vm.message = response.message;
                    }
                }
            });
        }
    },
});


$(document).ready(function () {
    $("#form-profile").on('submit', function(e){
        e.preventDefault();
        let form = new FormData(this);
        let file = $('#upload-image')[0];
        let token = $('#token-update-profile-picture').val();
        
        form.append('image', file);
        form.append('_token', token);

        $.ajax({
            url : '/updateProfilePicture',
            data : form,
            type : 'post',
            cache : false,
            contentType : false,
            processData : false,
            dataType : 'JSON',
            beforeSend : function(){
                vPengaturan.reset();
                vPengaturan.loading = true;
            },
            success : function(response){
                vPengaturan.loading = false;
                if(response.type == 'error'){
                    vPengaturan.error_upload = response.errors.image[0];
                }else{
                    vPengaturan.message = response.message;
                    vPengaturan.user_image = response.newImage;
                }
            }
        });
        
        return false;
    });
});