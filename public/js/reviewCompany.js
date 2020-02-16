var vReviewCompany = new Vue({
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
        error_lama_bekerja : '',
        error_kelebihan : '',
        error_kekurangan : '',
        error_star1 : '',
        error_star2 : '',
        error_star3 : '',
        error_star4 : '',
        error_star5 : '',
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
            this.error_lama_bekerja = '';
            this.error_kelebihan = '';
            this.error_kekurangan = '';
            this.message = '';
            this.error_star1 = '';
            this.error_star2 = '';
            this.error_star3 = '';
            this.error_star4 = '';
            this.error_star5 = '';
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
            let lamabekerja = $("select[name='lamabekerja']").val();
            let kelebihan = $("textarea[name='kelebihan']").val();
            let kekurangan = $("textarea[name='kekurangan']").val();
            let gaji_tunjangan = starValue[0];
            let jenjang_karir = starValue[1];
            let work_life_balance = starValue[2];
            let nilai_budaya = starValue[3];
            let manajemen_senior = starValue[4];

            $.ajax({
                url : '/api/reviewCompany/submitReview',
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
                    periode : periode,
                    lamabekerja : lamabekerja,
                    kelebihan : kelebihan,
                    kekurangan : kekurangan,
                    gaji_tunjangan : parseInt(starValue[0]),
                    jenjang_karir : starValue[1],
                    work_life_balance : starValue[2],
                    nilai_budaya : starValue[3],
                    manajemen_senior : starValue[4],
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
                        if(err.lamabekerja != undefined) vm.error_lama_bekerja = err.lamabekerja[0];
                        if(err.kelebihan != undefined) vm.error_kelebihan = err.kelebihan[0];
                        if(err.kekurangan != undefined) vm.error_kekurangan = err.kekurangan[0];
                        if(err.gaji_tunjangan != undefined) vm.error_star1 = err.gaji_tunjangan[0];
                        if(err.jenjang_karir != undefined) vm.error_star2 = err.jenjang_karir[0];
                        if(err.work_life_balance != undefined) vm.error_star3 = err.work_life_balance[0];
                        if(err.nilai_budaya != undefined) vm.error_star4 = err.nilai_budaya[0];
                        if(err.manajemen_senior != undefined) vm.error_star5 = err.manajemen_senior[0];
                        return;
                    }
                    vm.message = response.message;

                    let users = response.users;
                    for(let i=0 ; i<users.length ; i++){
                        let user_id = users[i].user_id;
                        firebaseDB.ref('/notification/' + user_id).push({
                            id : response.review_id,
                            type : 'review',
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

var starValue = [0,0,0,0,0];
$(document).ready(function(){
    let stars = ['.star1', '.star2', '.star3', '.star4', '.star5'];
    for(let aaa=0 ; aaa < 5 ; aaa++){
        let curr = stars[aaa];
        $(curr).on('click', function(){
            let index = $(this).attr('value');
            
            let starIndex = curr[curr.length-1] - 1;
            starValue[starIndex] = index;
            
            for(let i=0 ; i<5 ; i++) $(curr).eq(i).css('color', '#ccc');
            for(let i=0 ; i< index ; i++) $(curr).eq(i).css('color', 'orange');
        });
    }
});
