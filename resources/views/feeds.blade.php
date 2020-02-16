@extends('layout.master')

@section('title', 'Qerja TPA')

@section('style')
    <link rel="stylesheet" type="text/css" href="css/feeds.css">
@endsection

@section('script')
    <script src="js/feeds.js"></script>
@endsection

@section('content')
<div id="content">
	<div v-for="i in datas">
		<!-- ==============gaji============== -->
		<div class="company-content-item-gaji" v-if="i.type == 'gaji'">
	        <div>
	            <img v-bind:src="'image/company/' + i.data.CompanyImage">
	        </div>
	        <div>
	            <div
					v-on:click="gotoDetail(i.data.CompanyId, 'gaji', i.data.SalaryId)"
	            ><p>@{{ i.data.PositionName }}</p></div>
	            <div
					v-on:click="gotoDetailProfil(i.data.CompanyId)"
	            ><p>@{{ i.data.CompanyName }}</p></div>
	            <div><p>@{{ i.data.SalaryCount }} data gaji</p></div>
	        </div>
	        <div>
	            <p>Rata-Rata Gaji</p>
	            <p>Rp. @{{ i.data.AverageSalary }}</p>
	        </div>
	        <div>
	            <input type="range" disabled
	                v-bind:min="i.data.MinSalary"
	                v-bind:max="i.data.MaxSalary"
	                v-bind:value="i.data.AverageSalary"
	            >
	        </div>
	    </div>

	    <!-- ==============review============== -->
		<div class="company-content-item-review" v-else-if="i.type == 'review'">
            <div>
                <div
					v-on:click="gotoDetail(i.data.CompanyId, 'review', i.data.ReviewId)"
                ><p>@{{ i.data.PositionName }}</p></div>
                <div
					v-on:click="gotoDetailProfil(i.data.CompanyId)"
                ><p>@{{ i.data.CompanyName }}</p></div>
                <div>
                	<i class="fa fa-star"
                        v-for="j in 5"
                        v-bind:style="{ color : (j <= i.data.ReviewRating) ? 'orange' : '#ccc' }"
                    ></i>
                </div>
            </div>
            <div>
                <div><i class="fa fa-thumbs-up"></i></div>
                <div>
                    <label>@{{ i.data.ReviewPositive.substr(0, 100) }}</label>
                    <label
	                    v-on:click="gotoDetail(i.data.CompanyId, 'review', i.data.ReviewId)"
	                    style="font-size: 10px; color: blue"
	                >...read more</label>
                    <p
						v-on:click="gotoDetail(i.data.CompanyId, 'review', i.data.ReviewId)"
						class="lihat-lebih-lanjut"
                    >Lihat Lebih Lanjut</p>
                </div>
            </div>
        </div>


	    <!-- ==============lowongan============== -->
	    <div class="company-content-item-lowongan" v-else-if="i.type == 'lowongan'">
            <div class="company-content-item-lowongan-container">
                <div class="position">
                    <p>@{{ i.data.PositionName }}</p>
                </div>
                <div class="company">
                    <div>
                        <p
							v-on:click="gotoDetailProfil(i.data.CompanyId)"
                        >@{{ i.data.CompanyName }} -</p>
                    </div>
                    <div><i class="fa fa-map-marker"></i></div>
                    <div><label>@{{ i.data.City }}</label></div>
                </div>
                <div class="salary">
                    <div><p>Gaji : </p></div>
                    <div><p>@{{ i.data.Salary }}</p></div>
                </div>
                <div class="description">
                    <p>@{{ i.data.Description }}</p>
                </div>
            </div>
        </div>
	</div>


</div>

@endsection