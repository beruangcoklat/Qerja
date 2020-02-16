var vHome = new Vue({
    el : '#content',
    created : function(){
        let vm = this;
        $.get('/api/getCompany/mostReviewed', response => {
            vm.sliderDatas = response;
        });
        $.get('/api/getSalary/mostReviewed', response => {
            vm.gajiDatas = response;
        });
    },
    data : {
        index : 0,
        sliderDatas : [],
        gajiDatas : []
    },
    methods : {
        gotoDetail : function(id){
            ajax('/setSessionCompanyId', 'get', {
                company_id : id,
                type : 'profil'
            })
            .done(response => {
                window.location.replace('/companyDetail');
            });
        },
        gotoDetailReview : function(id){
            ajax('/setSessionCompanyId', 'get', {
                company_id : id,
                type : 'review'
            })
            .done(response => {
                window.location.replace('/companyDetail');
            });
        },
        gotoGaji : function(){
            ajax('/setSessionCompanyList', 'get', {
                type : 'gaji'
            })
            .done(response => {
                window.location.replace('/company');
            });
        },
        getSlider : function(){
            if(this.sliderDatas.length == 0) return;

            let start = this.index;
            let result =  this.sliderDatas.slice(start, start + 3);
            if (result.length != 3){
                let need = 3 - result.length;
                for(let i=0 ; i<need ; i++){
                    result.push(this.sliderDatas[i]);
                }
            }
            return result;
        },
        updateSlider : function(direction){
            let time = 100;
            $('.company').fadeOut(time).fadeIn(time);

            let increment = (direction == 'right') ? 1 : -1;
            this.index += increment;
            if(this.index == this.sliderDatas.length) this.index = 0;
            else if(this.index == -1) this.index = this.sliderDatas.length - 1;
        }
    }
});
