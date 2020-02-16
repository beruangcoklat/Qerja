var vCompanyDetail = new Vue({
	el : '#content',
	data : {
		active : 'profil',
		companyData : [],
		company_id : 0,
		curr_page : 0,
		last_page : 0,
		
		gajiDatas : [],
		gajiDatasShow : [],
		gajiDatasLock : [],

		reviewDatas : [],
		reviewDatasShow : [],
		reviewDatasLock : [],

		lowonganDatas : [],
		lowonganDatasShow : [],
		lowonganDatasLock : [],

		item_id : null,
		auth : {},
	},
	created : function(){
		let vm = this;
		ajax('/getSessionCompanyId', 'get', null)
		.done(response => {
			vm.company_id = response[0].id;
			vm.active = response[0].type;
			vm.item_id = response[0].item_id;

			ajax('api/getCompany/profile', 'get', { company_id : vm.company_id })
			.done(response => {
				vm.companyData = response;
				if(vm.active != 'profil') vm.paging(1, vm.active);
			});
		});

		ajax('/getLoggedUser', 'get', null)
		.done(response => {
			vm.auth = response;
		});
	},
	methods : {
		helpful : function(review){
			let vm = this;
			if(vm.auth.role == 'guest'){
				vNav.toggleLogin();
				return;
			}

			ajax('/api/helpful', 'get', {
				userId : vm.auth.user.id,
				reviewId : review.ReviewId,
			}, beforeSend => {
				vm.setLoading(true);
			})
			.done(response => {
				review.ReviewHelpfulAlready = !review.ReviewHelpfulAlready;
				review.ReviewHelpful = response.newCount;
			})
			.then(response => {
				vm.setLoading(false);
			});
		},
		refresh : function(){
			let vm = this;
			ajax('/getLoggedUser', 'get', null)
			.done(response => {
				vm.auth = response;
				vm.setActive(vm.active);
			})
		},
		setActive : function(param){
			let vm = this;
			vm.active = param;

			if(param == 'profil'){
				vm.setLoading(true);
				setTimeout(function(){
					vm.setLoading(false);
				}, 200);
			}
			else vm.paging(1, param);
		},
		getActive : function(param){
			return this.active == param;
		},
		setLoading : function(param){
			vNav.page_mask_opened = param;
			vNav.loading_messier = param;
		},
		paging : function(next_page, type){
			let vm = this;
			let url = '';
			let json = {
				company_id : vm.company_id,
				page : next_page,
				item_id : vm.item_id,
			};

			if(type == 'review') {
				url = '/api/getReview/reviewsFromCompany';
				json['user_id'] = vm.auth.user == null ? -1 : vm.auth.user.id;
			}
			else if(type == 'gaji') url = '/api/getSalary/salariesFromCompany';
			else if(type == 'lowongan') url = '/api/getAvailableJob/byId';

			ajax(url, 'get', json, function(){
				vm.setLoading(true);
			})
			.done(response => {
				let datas = response.datas;
				let until = vNav.role != 'guest' ? 10 : next_page == 1 ? 3 : 0;
				let show = datas.slice(0, until);
				let lock = datas.slice(until, 10);

				if(type == 'review'){
					vm.reviewDatas = response;
					vm.reviewDatasShow = show;
					vm.reviewDatasLock = lock;
				}else if(type == 'gaji'){
					vm.gajiDatas = response;
					vm.gajiDatasShow = show;
					vm.gajiDatasLock = lock;
				}else if(type == 'lowongan'){
					vm.lowonganDatas = response;
					vm.lowonganDatasShow = show;
					vm.lowonganDatasLock = lock;
				}
			})
			.then(response => {
				vm.curr_page = next_page;
				vm.last_page = response.LastPage;
				vm.setLoading(false);
			});
		},
	}
});