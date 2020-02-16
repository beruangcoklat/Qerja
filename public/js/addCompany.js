var vAddCompany = new Vue({
	el : '#content',
	data : {
		countries : [],
		cities : [],
		categories : [],
		show_loading_city : 'hidden',
		loading : false,
		message : '',

		err_nama : '',
		err_negara : '',
		err_kota : '',
		err_industri : '',
		err_foto : '',
		err_lokasi : '',
		err_deskripsi : '',
		err_website : '',
		err_email : '',
		err_phone : '',
	},
	created : function(){
		let vm = this;
        $.get('/api/getCountry/all', response => {
            vm.countries = response.countries;
        });
        $.get('/api/getCompanyCategories/all', response => {
            vm.categories = response.categories;
        });
	},
	methods : {
		reset : function(){
			this.err_nama = '';
			this.err_negara = '';
			this.err_kota = '';
			this.err_industri = '';
			this.err_foto = '';
			this.err_lokasi = '';
			this.err_deskripsi = '';
			this.err_website = '';
			this.err_email = '';
			this.err_phone = '';
			this.loading = false;
			this.show_loading_city = 'hidden';
			this.message = '';
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
        },
	}
});

$(document).ready(function(){
	$('#add-company-form').on('submit', function(e){
		e.preventDefault();
		let form = new FormData(this);
		let nama = $("input[name='nama']").val();
		let negara = $("select[name='negara']").val();
		let kota = $("select[name='kota']").val();
		let industri = $("select[name='industri']").val();
		let foto = $("input[name='foto']")[0];
		let lokasi = $("textarea[name='lokasi']").val();
		let deskripsi = $("textarea[name='deskripsi']").val();
		let website = $("input[name='website']").val();
		let email = $("input[name='email']").val();
		let phone = $("input[name='phone']").val();
		let token = $('#token-add-company').val();

		form.append('_token', token);
		form.append('nama', nama);
		form.append('negara', negara);
		form.append('kota', kota);
		form.append('industri', industri);
		form.append('foto', foto);
		form.append('lokasi', lokasi);
		form.append('deskripsi', deskripsi);
		form.append('website', website);
		form.append('email', email);
		form.append('phone', phone);
		
		$.ajax({
			url : '/api/addCompany',
			type : 'post',
			data : form,
			cache : false,
            contentType : false,
            processData : false,
            dataType : 'JSON',
            beforeSend : function(){
            	vAddCompany.reset();
				vAddCompany.loading = true;
            },
			success : function(response){
				vAddCompany.loading = false;
				if(response.type == 'error')
				{
					let errors = response.errors;
					if(errors.nama != undefined) vAddCompany.err_nama = errors.nama[0];
					if(errors.negara != undefined) vAddCompany.err_negara = errors.negara[0];
					if(errors.kota != undefined) vAddCompany.err_kota = errors.kota[0];
					if(errors.industri != undefined) vAddCompany.err_industri = errors.industri[0];
					if(errors.foto != undefined) vAddCompany.err_foto = errors.foto[0];
					if(errors.lokasi != undefined) vAddCompany.err_lokasi = errors.lokasi[0];
					if(errors.deskripsi != undefined) vAddCompany.err_deskripsi = errors.deskripsi[0];
					if(errors.website != undefined) vAddCompany.err_website = errors.website[0];
					if(errors.email != undefined) vAddCompany.err_email = errors.email[0];
					if(errors.phone != undefined) vAddCompany.err_phone = errors.phone[0];
				}
				else
				{
					$('#add-company-form').find('input:text, input:image, select, textarea').val('');
					vAddCompany.message = response.message;
				}
			}
		});
	});
});
