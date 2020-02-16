@extends('layout.master')

@section('title', 'Qerja TPA')

@section('style')
	<link rel="stylesheet" type="text/css" href="css/company.css">
@endsection

@section('script')
	<script src="js/company.js"></script>
@endsection

@section('content')

<div id="company-container">
	<div id="company-navbar">
		<div v-bind:class="{ 'active': getActive('perusahaan') }" v-on:click="setActive('perusahaan')"><p>Perusahaan</p></div>
		<div v-bind:class="{ 'active': getActive('gaji') }" v-on:click="setActive('gaji')"><p>Gaji</p></div>
		<div v-bind:class="{ 'active': getActive('review') }" v-on:click="setActive('review')"><p>Review</p></div>
		<div v-bind:class="{ 'active': getActive('lowongan') }" v-on:click="setActive('lowongan')"><p>Lowongan</p></div>
	</div>

	<div id="company-content-container">
		<div id="company-content-left">
			<div>
				<select id="company-sorting-category" v-on:change="company_sorting" v-if="getActive('perusahaan')">
					<option value="name_asc">Name Ascending</option>
					<option value="name_desc">Name Descending</option>
					<option value="rating_asc">Rating Ascending</option>
					<option value="rating_desc">Rating Desceinding</option>
				</select>
			</div>
			<div><h3>Filter</h3></div>
			<div><p>Kata Kunci</p></div>
			<div><input type="text" id="txt-filter"></div>
			<div><button v-on:click="updateFilter()">Ubah Pencarian</button></div>
		</div>
		<div id="company-content-right">
			<div id="company-content-header">
				<p v-if="getActive('perusahaan')">Perusahaan Hasil</p>
				<p v-else-if="getActive('gaji')">Hasil Pencarian Gaji</p>
				<p v-else-if="getActive('review')">Hasil Pencarian Review</p>
			</div>
				

			<!-- =====================perusahaan===================== -->
			<div v-if="getActive('perusahaan')" id="company-content-content">
				<div class="company-content-item-perusahaan" v-for="data in dataPerusahaan">
			        <div><img v-bind:src="'image/company/' + data.CompanyImage"></div>
			        <div class="company-content-item-content">
			            <div class="company-content-item-content-upper">
			                <div>
			                    <div class="company-title">
			                        <p v-on:click="gotoDetailProfil(data.CompanyId)">@{{ data.CompanyName }}</p>
			                    </div>
			                    <div class="company-title-below">
			                        <div>
			                            <i class="fa fa-star" 
			                                v-for="i in 5"
			                                v-bind:style="{ color : (i <= data.CompanyRating) ? 'orange' : '#ccc' }"
			                            ></i>
			                        </div>
			                        <div><label>@{{ data.ReviewCount }}</label> Review</div>
			                        <div><label>@{{ data.SalaryCount }}</label> Gaji</div>
			                    </div>
			                </div>
			                <div v-show="vNav.role == 'member'">
			                    <button v-on:click="follow(data)" id="follow-btn">@{{ data.Followed ? 'Stop Ikuti' : 'Ikuti' }}</button>
			                </div>
			            </div>
			            <div class="company-content-item-content-lower">
			                <label>@{{ data.CompanyDescription.substr(0, 100) }}</label>
			                <label 
			                    v-on:click="gotoDetailProfil(data.CompanyId)"
			                    style="font-size: 10px; color: blue"
			                >...read more</label>

			                <hr>
			                <p
								v-on:click="gotoDetailProfil(data.CompanyId)"
			                >Lihat rincian perusahaan </p>
			            </div>
			        </div>
			    </div>
			</div>
			

			<!-- =====================gaji===================== -->
			<div v-if="getActive('gaji')" id="company-content-content">
				<div class="company-content-item-gaji" v-for="data in dataGajiShow">
			        <div>
			            <img v-bind:src="'image/company/' + data.CompanyImage">
			        </div>
			        <div>
			            <div
							v-on:click="gotoDetail(data.CompanyId, 'gaji', data.SalaryId)"
			            ><p>@{{ data.PositionName }}</p></div>
			            <div
							v-on:click="gotoDetailProfil(data.CompanyId)"
			            ><p>@{{ data.CompanyName }}</p></div>
			            <div><p>@{{ data.SalaryCount }} data gaji</p></div>
			        </div>
			        <div>
			            <p>Rata-Rata Gaji</p>
			            <p>Rp. @{{ data.AverageSalary }}</p>
			        </div>
			        <div>
			            <input type="range" disabled
			                v-bind:min="data.MinSalary"
			                v-bind:max="data.MaxSalary"
			                v-bind:value="data.AverageSalary"
			            >
			        </div>
			    </div>

			    <!-- gaji lock -->
			    <div class="company-content-item-gaji" v-for="data in dataGajiLock">
			        <div>
			            <img v-bind:src="'image/company/' + data.CompanyImage">
			        </div>
			        <div>
			            <div><p>@{{ data.PositionName }}</p></div>
			            <div><p>@{{ data.CompanyName }}</p></div>
			        </div>
			        <div class="company-content-item-lock">
			        	<div>
			        		<div><i class="fa fa-lock"></i></div>
			        		<div>
			        			<div><p>Detail Gaji</p></div>
			        			<div><p>Terkunci</p></div>
			        		</div>
			        	</div>
			        	<div>
			        		<p>
			        			<label v-on:click="vNav.toggleLogin()">Masuk</label> 
			        			atau 
			        			<label v-on:click="vNav.toggleRegister()">Daftar</label>
			        		</p>
			        		<p>untuk lihat semua data</p>
			        	</div>
			        </div>
			    </div>
			</div>
			

			<!-- =====================review===================== -->
			<div v-if="getActive('review')" id="company-content-content">
				<div class="company-content-item-review" v-for="data in dataReviewShow">
		            <div>
		                <div
							v-on:click="gotoDetail(data.CompanyId, 'review', data.ReviewId)"
		                ><p>@{{ data.PositionName }}</p></div>
		                <div
							v-on:click="gotoDetailProfil(data.CompanyId)"
		                ><p>@{{ data.CompanyName }}</p></div>
		                <div>
		                	<i class="fa fa-star"
                                v-for="i in 5"
                                v-bind:style="{ color : (i <= data.ReviewRating) ? 'orange' : '#ccc' }"
                            ></i>
		                </div>
		            </div>
		            <div>
		                <div><i class="fa fa-thumbs-up"></i></div>
		                <div>
		                    <label>@{{ data.ReviewPositive.substr(0, 100) }}</label>
		                    <label
			                    v-on:click="gotoDetail(data.CompanyId, 'review', data.ReviewId)"
			                    style="font-size: 10px; color: blue"
			                >...read more</label>
		                    <p
								v-on:click="gotoDetail(data.CompanyId, 'review', data.ReviewId)"
								class="lihat-lebih-lanjut"
		                    >Lihat Lebih Lanjut</p>
		                </div>
		            </div>
		        </div>

				<!-- review lock -->
		        <div class="company-content-item-review" v-for="data in dataReviewLock">
		            <div>
		                <div><p>@{{ data.PositionName }}</p></div>
		                <div><p>@{{ data.CompanyName }}</p></div>
		                <div>
		                	<i class="fa fa-star"
                                v-for="i in 5"
                                v-bind:style="{ color : (i <= data.ReviewRating) ? 'orange' : '#ccc' }"
                            ></i>
		                </div>
		            </div>
		            <div class="company-content-item-lock">
			        	<div>
			        		<div><i class="fa fa-lock"></i></div>
			        		<div>
			        			<div><p>Detail Review</p></div>
			        			<div><p>Terkunci</p></div>
			        		</div>
			        	</div>
			        	<div>
			        		<p>
			        			<label v-on:click="vNav.toggleLogin()">Masuk</label> 
			        			atau 
			        			<label v-on:click="vNav.toggleRegister()">Daftar</label>
			        		</p>
			        		<p>untuk lihat semua data</p>
			        	</div>
			        </div>
		        </div>
			</div>

			<!-- =====================lowongan===================== -->
			<div v-if="getActive('lowongan')" id="company-content-content">
				<div class="company-content-item-lowongan" v-for="data in dataLowonganShow">
		            <div class="company-content-item-lowongan-container">
		                <div class="position">
		                    <p
								v-on:click="gotoDetail(data.CompanyId, 'lowongan', data.LowonganId)"
		                    >@{{ data.PositionName }}</p>
		                </div>
		                <div class="company">
		                    <div>
		                        <p>@{{ data.CompanyName }} -</p>
		                    </div>
		                    <div><i class="fa fa-map-marker"></i></div>
		                    <div><label>@{{ data.City }}</label></div>
		                </div>
		                <div class="salary">
		                    <div><p>Gaji : </p></div>
		                    <div><p>@{{ data.Salary }}</p></div>
		                </div>
		                <div class="description">
		                    <p>@{{ data.Description }}</p>
		                </div>
		            </div>
		        </div>

		        <!-- lowongan lock -->
		        <div class="company-content-item-lowongan" id="lock-lowongan" v-for="data in dataLowonganLock">
		        	<div class="company-content-item-lowongan-container">
		                <div class="position">
		                    <p>@{{ data.PositionName }}</p>
		                </div>
		                <div class="company">
		                    <div>
		                        <p>@{{ data.CompanyName }} -</p>
		                    </div>
		                    <div><i class="fa fa-map-marker"></i></div>
		                    <div><label>@{{ data.City }}</label></div>
		                </div>
		            </div>
		            <div class="lock">
		                <div>
		                    <div><i class="fa fa-lock"></i></div>
		                    <div>
		                        <div><p>Detail Lowongan</p></div>
		                        <div><p>Terkunci</p></div>
		                    </div>
		                </div>
		                <div>
		                    <p>
		                        <label v-on:click="vNav.toggleLogin()">Masuk</label> atau 
		                        <label v-on:click="vNav.toggleRegister()">Daftar</label>
		                    </p>
		                    <p>untuk lihat semua data</p>
		                </div>
		            </div>
		        </div>
			</div>


		</div>
	</div>
</div>

@include('modal.modalHome')
@endsection