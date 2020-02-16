var vChat = new Vue({
	el : '#content',
	data : {
		messages : [],
		auth : {},
		refPath : '',

		// admin
		showChatList : false,
		contacts : [],

		// member
		adminExists : true,
	},
	created : function(){
		let vm = this;
		ajax('/getLoggedUser', 'get', null)
		.done(response => {
			vm.setLoading(true);
			vm.auth = response;
			if(vm.auth.role == 'member') vm.setupMember();
			else vm.setupAdmin();
		});
	},
	methods : {
		setupMember : function(){
			let vm = this;
			vm.refPath = '/chat/' + vm.auth.user.id;
			
			firebaseDB.ref(vm.refPath).on('value', snap => {
				let arr = [];
				for (i in snap.val()) arr.push(i);

				vm.messages.splice(0, vm.messages.length);
				for(let i=0 ; i<arr.length ; i++){
					let json = snap.val()[arr[i]];
					let isRight = vm.auth.role != json['role'];
					vm.messages.push({
						name : json['name'],
						message : json['message'],
						isRight : isRight,
					});
				}

				vm.setLoading(false);
			});

			firebaseDB.ref('/admin').on('value', snap => {
				let arr = [];
				for (i in snap.val()) arr.push(i);

				let found = false;
				for(let i=0 ; i<arr.length ; i++){
					let key = snap.val()[arr[i]];
					if(key == true){
						found = true;
						break;
					}
				}
				vm.adminExists = found;
			});
		},
		setupAdmin : function(){
			let vm = this;
			vm.refPath = '/chat';
			firebaseDB.ref(vm.refPath).on('value', snap => {
				let arr = [];
				for (i in snap.val()) arr.push(i);

				vm.contacts.splice(0, vm.contacts.length);
				for(let i=0 ; i<arr.length ; i++){
					ajax('/api/getUser/byId', 'get', {'id' : arr[i]})
					.done(response => {
						vm.contacts.push({
							'id' : response.user.id,
							'name' : response.user.fullname,
							'image' : response.user.image,
						});	
					})
					.then(response => {
						vm.changeChat(vm.contacts[0].id);
					});
				}
			});
			firebaseDB.ref('/admin/' + vm.auth.user.id).set(true);
		},
		writeChat : function(){
			let vm = this;
			let input = $('#txt-chat-input');
			let message = input.val();
			input.val('');

			if(message.length == 0) return;
			firebaseDB.ref(vm.refPath).push({
				role : vm.auth.role,
				message : message,
				name : vm.auth.user.fullname,
			});
		},
		setLoading : function(param){
            this.loading = param;
            vNav.page_mask_opened = this.loading;
            vNav.loading_messier = this.loading;
        },
        changeChat : function(param){
        	let vm = this;
        	vm.setLoading(true);
			vm.refPath = '/chat/' + param;
			firebaseDB.ref(vm.refPath).on('value', snap => {
				let arr = [];
				for (i in snap.val()) arr.push(i);

				vm.messages.splice(0, vm.messages.length);
				for(let i=0 ; i<arr.length ; i++){
					let json = snap.val()[arr[i]];
					let isRight = vm.auth.role != json['role'];
					vm.messages.push({
						name : json['name'],
						message : json['message'],
						isRight : isRight,
					});
				}

				setTimeout(function(){
					vm.setLoading(false);
				}, 200);
			});
        },
	}
});
