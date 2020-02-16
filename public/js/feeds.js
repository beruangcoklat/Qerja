var vFeeds = new Vue({
    el : '#content',
    data : {
        datas : [],
        auth : null,
        curr_page : 1,
    },
    created : function(){
        let vm = this;
        ajax('/getLoggedUser', 'get', null).done(auth => {
            vm.auth = auth;
            vm.scroll();
        });
    },
    methods : {
        scroll : function(){
            let vm = this;
            ajax('/api/getCompany/feeds', 'get', {
                page : vm.curr_page,
                user_id : vm.auth.user.id,
            }, function(){
                vm.setLoading(true);
            })
            .done(response => {
                for(let i=0 ; i<response.length ; i++){
                    vm.datas.push(response[i]);
                }
            })
            .then(response => {
                vm.curr_page++;
                vm.setLoading(false);
            });
        },
        gotoDetailProfil : function(company_id){
            ajax('/setSessionCompanyId', 'get', {
                company_id : company_id,
                type : 'profil',
            }).done(function(){
                window.location.replace('/companyDetail');
            })
        },
        gotoDetail : function(company_id, type, item_id){
            ajax('/setSessionCompanyId', 'get', {
                company_id : company_id,
                type : type,
                item_id : item_id,
            }).done(function(){
                window.location.replace('/companyDetail');
            })
        },
        setLoading : function(param){
            this.loading = param;
            vNav.page_mask_opened = this.loading;
            vNav.loading_messier = this.loading;
        },
    }
});


$(document).ready(function(){
    $(window).on('scroll', function(){
        let scrollPosition = $(window).scrollTop();
        let scrollHeight = $(window).height();
        let bottomPosition = $(document).height();
        if(scrollPosition + scrollHeight != bottomPosition) return;
        vFeeds.scroll();
    });
});