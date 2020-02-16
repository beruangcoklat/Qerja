var vNav = new Vue({
    el : '#nav',
    data : {
        cari_opened : false,
        drop_down: false,
        drop_down_language : false,
        drop_down_notif : false,
        role : 'guest',
        language : 'indonesia',
        page_mask_opened : false,
        loading_messier : false,
        show_hamburger : false,
        rekomendasi : [],
        notifikasi : [],
        notif_count : 0,
    },
    created : function(){
        let vm = this;
        vm.refresh();

        // dummy firebase
        // firebaseDB.ref('/notification/2').push({
        //     id : 2,
        //     type : 'review'
        // });
    },
    methods : {
        pindah : function(data){
            $.get('/getLoggedUser', response => {
                firebaseDB.ref('/notification/' + response.user.id).child(data.firebase_id).remove();

                let company_id = 1;
                ajax('/setSessionCompanyId', 'get', {
                    company_id : data.company.id,
                    type : data.type,
                    item_id : data.id,
                }).done(function(){
                    window.location.replace('/companyDetail');
                });
            });
        },
        refresh : function(){
            let vm = this;
            $.get('/getLoggedUser', response => {
                vm.role = response.role;
                if(vm.role == 'guest') return;
                vm.notification(response);
            });
        },
        notification : function(auth){
            let vm = this;
            let path = '/notification/' + auth.user.id;
            firebaseDB.ref(path).on('value', snap => {
                let arr = [];
                for(i in snap.val()) arr.push(i);

                let datas = [];
                for(let i=0 ; i<arr.length ; i++){
                    let json = snap.val()[arr[i]];
                    json['firebase_id'] = arr[i];

                    let url = '';
                    if(json.type == 'review'){
                        url = '/api/getCompany/reviewid';
                    }else if(json.type == 'gaji'){
                        url = '/api/getCompany/salaryid';
                    }
                    ajax(url, 'get', { id : json.id }).done(response => {
                        json['company'] = response;
                        datas.push(json);
                    });
                }
                vm.notifikasi = datas;
                vm.notif_count = arr.length;
            });
        },
        resetResponsive : function(){
            $('.search-bar').val('');
            this.rekomendasi = null;
        },
        go : function(company_id){
            ajax('/setSessionCompanyId', 'get', {
                company_id : company_id,
                type : 'profil',
            }).done(function(){
                window.location.replace('/companyDetail');
            })
        },
        search : function(index){
            let vm = this;
            let text = $('.search-bar').eq(index).val();
            ajax('/api/getCompany/search', 'get', { text : text }).done(response => {
                vm.rekomendasi = response;
            });
        },
        toggleDropDownNotif : function(){
            this.drop_down_notif = !this.drop_down_notif;
        },
        toggleHamburger : function(){
            this.show_hamburger = !this.show_hamburger;
        },
        changeLanguage : function(language){
            this.language = language;
        },
        toggleCari : function(){
            this.cari_opened = !this.cari_opened;
            this.rekomendasi = null;
            $('.search-bar').val('');
        },
        toggleDropDown : function(){
            this.drop_down = !this.drop_down;
        },
        toggleDropDownLanguage : function(){
            this.drop_down_language = !this.drop_down_language;
        },
        toggleRegister : function(){
            vModalRegister.setShowRegister(!vModalRegister.showRegister);
            if(vModalRegister.showRegister){
                 vNav.page_mask_opened = true;
            }
        },
        toggleLogin : function(){
            vModalLogin.setShowLogin(!vModalLogin.showLogin);
            if(vModalLogin.showLogin){
                vNav.page_mask_opened = true;
            }
        },
        logout : function(){
            let vm = this;
            $.get('/getLoggedUser', response => {
                if(response.role != 'admin') return;
                firebaseDB.ref('/admin/' + response.user.id).set(false);
            });

            ajax('/logout', 'get', null).done(response => {
                $.get('/getLoggedUser', response => {
                    vm.role = response.role;
                    let url = window.location.href.split(':')[2];
                    vm.show_hamburger = false;
                    if(url != '8000/') window.location.href = '/';
                });
            });
        }
    }
});


