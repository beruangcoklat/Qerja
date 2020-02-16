var vSalary = new Vue({
    el : '#content',
    data : {
        error_negara : '',
        error_perusahaan : '',
        error_web : '',
        error_industri : '',
        error_kota : '',
        error_jabatan : '',
        error_status : '',
        error_gaji : '',
        error_periode : '',
        perusahaan_not_from_db : false,
        companies : [],
        countries : [],
        cities : [],
        categories : [],
        show_loading_city : 'hidden',
        message : ''
    },
    created : function(){
        let vm = this;
        $.get('/api/getCompany/all', response => {
            vm.companies = response.companies;
        });
        $.get('/api/getCountry/all', response => {
            vm.countries = response.countries;
        });
        $.get('/api/getCompanyCategories/all', response => {
            vm.categories = response.categories;
        });
    },
    methods : {
        reset : function(){
            this.error_negara = '';
            this.error_perusahaan = '';
            this.error_web = '';
            this.error_industri = '';
            this.error_kota = '';
            this.error_jabatan = '';
            this.error_status = '';
            this.error_gaji = '';
            this.error_periode = '';
            this.message = '';
        },
        togglePerusahaanDb : function(){
            this.perusahaan_not_from_db = !this.perusahaan_not_from_db;
            this.reset();
        },
        submitReview : function(){
            this.reset();
            let vm = this;
            let negara = $("select[name='negara']").val();
            let perusahaan = '';
            if(this.perusahaan_not_from_db) perusahaan = $("input[name='perusahaan']").val();
            else perusahaan = $("select[name='perusahaan']").val();
            let web = $("input[name='web']").val();
            let industri = $("select[name='industri']").val();
            let kota = $("select[name='kota']").val();
            let jabatan = $("input[name='jabatan']").val();
            let status = $("input[name='status']:checked").val();
            let matauang = $("select[name='matauang']").val();
            let gaji = $("input[name='gaji']").val();
            let periode = $("input[name='periode']:checked").val();
            let token = $('#token-salary-review').val();
            
            $.ajax({
                url : '/api/salary/submitReview',
                type : 'post',
                data : {
                    companyExists : !vm.perusahaan_not_from_db,
                    _token : token,
                    negara : negara,
                    perusahaan : perusahaan,
                    web : web,
                    industri : industri,
                    kota : kota,
                    jabatan : jabatan,
                    status : status,
                    matauang : matauang,
                    gaji : gaji,
                    periode : periode
                },
                success : function(response){
                    let type = response.type;
                    if(type == 'error')
                    {
                        err = response.errors;
                        if(err.negara != undefined) vm.error_negara = err.negara[0];
                        if(err.perusahaan != undefined) vm.error_perusahaan = err.perusahaan[0];
                        if(err.web != undefined) vm.error_web = err.web[0];
                        if(err.industri != undefined) vm.error_industri = err.industri[0];
                        if(err.kota != undefined) vm.error_kota = err.kota[0];
                        if(err.jabatan != undefined) vm.error_jabatan = err.jabatan[0];
                        if(err.status != undefined) vm.error_status = err.status[0];
                        if(err.gaji != undefined) vm.error_gaji = err.gaji[0];
                        if(err.periode != undefined) vm.error_periode = err.periode[0];
                        return;
                    }
                    
                    vm.message = response.message;
                    let users = response.users;
                    for(let i=0 ; i<users.length ; i++){
                        let user_id = users[i].user_id;
                        firebaseDB.ref('/notification/' + user_id).push({
                            id : response.salary_id,
                            type : 'gaji',
                        });
                    }
                },
            });
        },
        updateCities : function(){
            let vm = this;
            let negara = $("select[name='negara']").val();
            if(negara == '') return;
            
            $.ajax({
                url : '/api/getCity/all',
                data : {
                    country : negara
                },
                type : 'get',
                beforeSend : function(){
                    vm.show_loading_city = 'visible';
                },
                success : function(response){
                    vm.cities = response.cities;
                    vm.show_loading_city = 'hidden';
                }
            });
        }
    }
});