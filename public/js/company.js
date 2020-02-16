var vCompany = new Vue({
    el : '#company-container',
    data : {
        dataPerusahaan : [],

        dataGaji : [],
        dataGajiShow : [],
        dataGajiLock : [],
        
        dataReview : [],
        dataReviewShow : [],
        dataReviewLock : [],
        
        dataLowongan : [],
        dataLowonganShow : [],
        dataLowonganLock :  [],
        
        activeMenu : 'perusahaan',
        curr_page : 1,
        sorting_type : 'name_asc',
        loading : false,
        filter : '',
        auth : null,
    },
    created : function(){
        let vm = this;
        ajax('/getSessionCompanyList', 'get', null).done(type => {
            try {
                let company_type = type[0].type;
                if(company_type != undefined) vm.activeMenu = company_type;
                ajax('/getLoggedUser', 'get', null).done(response => {
                    vm.auth = response;
                    vm.scroll();
                });
            }catch(err){
                ajax('/getLoggedUser', 'get', null).done(response => {
                    vm.auth = response;
                    vm.scroll();
                });
            }
        });
    },
    methods : {
        follow : function(company){
            let vm = this;

            ajax('/api/follow', 'get', {
                user_id : vm.auth.user.id,
                company_id : company.CompanyId,
            }, beforeSend => {
                vm.setLoading(true);
            })
            .done(response => {
                company.Followed = response;
                vm.setLoading(false);
            });
        },
        refresh : function(){
            let vm = this;
            vm.curr_page = 1;
            vm.setActive(vm.activeMenu);
        },
        gotoDetailProfil : function(company_id){
            ajax('/setSessionCompanyId', 'get', {
                company_id : company_id,
                type : 'profil',
            }).done(function(){
                window.location.replace('/companyDetail');
            });
        },
        gotoDetail : function(company_id, type, item_id){
            ajax('/setSessionCompanyId', 'get', {
                company_id : company_id,
                type : type,
                item_id : item_id,
            }).done(function(){
                window.location.replace('/companyDetail');
            });
        },
        updateFilter : function(){
            this.filter = $('#txt-filter').val();
            this.curr_page = -1;
            this.setActive(this.activeMenu);
        },
        setLoading : function(param){
            this.loading = param;
            vNav.page_mask_opened = this.loading;
            vNav.loading_messier = this.loading;
        },
        company_sorting : function(){
            let vm = this;
            this.setLoading(true);
            vm.sorting_type = $('#company-sorting-category').val();

            ajax('/api/getCompany/paging', 'get', {
                type : vm.sorting_type,
                page : 1,
                filter : vm.filter
            })
            .done(response => {
                vm.dataPerusahaan = response.companies.data;
                for(let i=0 ; i<response.salaries.length ; i++){
                    vm.dataPerusahaan[i]['SalaryCount'] = response.salaries[i];
                }
                vm.curr_page = 1;
                vm.setLoading(false);
            });
        },
        getActive : function(param){
            return param == this.activeMenu;
        },
        setActive : function(param){
            let vm = this;
            vm.activeMenu = param;
            vm.curr_page = 1;
            $('#txt-filter').val('');

            if(vm.activeMenu == 'perusahaan')
                vm.dataPerusahaan.splice(0, vm.dataPerusahaan.length);
            else if(vm.activeMenu == 'gaji')
                vm.dataGaji.splice(0, vm.dataGaji.length);
            else if(vm.activeMenu == 'review')
                vm.dataReview.splice(0, vm.dataReview.length);
            else if(vm.activeMenu == 'lowongan')
                vm.dataLowongan.splice(0, vm.dataReview.length);
            
            vm.scroll();
        },
        scroll : function(){
            let vm = this;
            vm.setLoading(true);

            if(vm.activeMenu == 'perusahaan')
            {
                let json = {
                    type : vm.sorting_type,
                    page : vm.curr_page,
                    filter : vm.filter,
                };

                ajax('/getLoggedUser', 'get', null)
                .done(auth => {
                    vm.auth = auth;
                    if(vm.auth.role != 'guest'){
                        json['user_id'] = vm.auth.user.id;
                    }
                    ajax('/api/getCompany/paging', 'get', json)
                    .done(response => {
                        let size_before = vm.dataPerusahaan.length;
                        for(let i=0 ; i<response.companies.data.length ; i++){
                            vm.dataPerusahaan.push(response.companies.data[i]);
                        }
                        let size_after = vm.dataPerusahaan.length;
                        for(let i=size_before ; i<size_after ; i++){
                            vm.dataPerusahaan[i]['SalaryCount'] = response.salaries[i];
                            if(response.follow != undefined){
                                vm.dataPerusahaan[i]['Followed'] = response.follow[i];
                            }
                        }
                    })
                    .then(response => {
                        vm.setLoading(false);
                        vm.curr_page++;
                    });
                });
            }
            else
            {
                let url = '';
                let datas = 0;
                if(vm.activeMenu == 'gaji'){
                    url = '/api/getSalary/paging';
                    datas = vm.dataGaji;
                }else if(vm.activeMenu == 'review'){
                    url = '/api/getReview/paging';
                    datas = vm.dataReview;
                }else if(vm.activeMenu == 'lowongan'){
                    url = '/api/getAvailableJob/paging';
                    datas = vm.dataLowongan;
                }

                ajax(url, 'get', { page : vm.curr_page })
                .done(response => {
                    let size_before = datas.length;
                    for(let i=0 ; i<response.data.length ; i++){
                        datas.push(response.data[i]);
                    }

                    let until = vNav.role != 'guest' ? 10 : 3;
                    let show = datas.slice(0, until);
                    let lock = datas.slice(until, datas.length);

                    if(vm.activeMenu == 'gaji'){
                        vm.dataGaji = datas;
                        vm.dataGajiShow = show;
                        vm.dataGajiLock = lock;
                    }else if(vm.activeMenu == 'review'){
                        vm.dataReview = datas;
                        vm.dataReviewShow = show;
                        vm.dataReviewLock = lock;
                    }else if(vm.activeMenu == 'lowongan'){
                        vm.dataLowongan = datas;
                        vm.dataLowonganShow = show;
                        vm.dataLowonganLock = lock;
                    }
                })
                .then(response => {
                    vm.setLoading(false);
                    vm.curr_page++;
                })
            }
        },
    },
});


$(document).ready(function(){
    $(window).on('scroll', function(){
        let scrollPosition = $(window).scrollTop();
        let scrollHeight = $(window).height();
        let bottomPosition = $(document).height();
        if(scrollPosition + scrollHeight != bottomPosition) return;
        vCompany.scroll();
    });

    $('body').on('click', '#follow-btn', function(e){
        let newText = $(this).text() == 'Ikuti' ? 'Stop Ikuti' : 'Ikuti';
        $(this).text(newText);
    });
});