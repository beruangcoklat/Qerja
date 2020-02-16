@extends('layout.master')

@section('title', 'Qerja TPA')

@section('style')
    <link rel="stylesheet" type="text/css" href="css/salary.css">
@endsection

@section('script')
	<script src="js/salary.js"></script>
@endsection

@section('content')
<div id="content">
	<div id="form">
        <input type="hidden" id="token-salary-review" value="{{ csrf_token() }}">

        <div class="form-group" id="first-form-group">
            <p>Tulis Informasi Gaji</p>
        </div>

		<div class="form-group">
            <div class="form-item">
                <div><p>Negara</p></div>
                <div>
                    <select name="negara" v-on:change="updateCities()">
                        <option value="">Choose</option>
                        <option 
                            v-for="i in countries"
                            v-bind:value="i.name">
                            @{{ i.name }}
                        </option>
                    </select>

                    <span class="tooltip" v-if="error_negara.length != 0">
                        @{{ error_negara }}
                    </span>
                </div>
            </div>

            <div class="form-item">
                <div><p>Perusahaan</p></div>
                <div>
                    <input type="text" v-if="perusahaan_not_from_db" name="perusahaan">
                    <select v-else name="perusahaan">
                        <option value="">Choose</option>
                        <option 
                            v-for="i in companies"
                            v-bind:value="i.id">
                            @{{ i.name }}
                        </option>
                    </select>
                    <i class="fa fa-exchange" v-on:click="togglePerusahaanDb()"></i>
                    <span class="tooltip" v-if="error_perusahaan.length != 0">
                        @{{ error_perusahaan }}
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="form-item" v-if="perusahaan_not_from_db">
                <div><p>Website Perusahaan</p></div>
                <div>
                    <input type="text" name="web">
                    <span class="tooltip" v-if="error_web.length != 0">
                        @{{ error_web }}
                    </span>
                </div>
            </div>
            <div class="form-item" v-if="perusahaan_not_from_db">
                <div><p>Industri Perusahaan</p></div>
                <div>
                    <select name="industri">
                        <option value="">Choose</option>
                        <option 
                            v-for="i in categories"
                            v-bind:value="i.id"
                        >@{{ i.name }}</option>
                    </select>
                    <span class="tooltip" v-if="error_industri.length != 0">
                        @{{ error_industri }}
                    </span>
                </div>
            </div>
            <div class="form-item">
                <div><p>Kota</p></div>
                <div>
                    <img src="image/loading_qerja.gif" v-bind:style="{ visibility: show_loading_city }">
                    <select name="kota">
                        <option value="">Choose</option>
                        <option 
                            v-for="i in cities"
                            v-bind:value="i.id">
                            @{{ i.name }}
                        </option>
                    </select>
                    <span class="tooltip" v-if="error_kota.length != 0">
                        @{{ error_kota }}
                    </span>
                </div>
            </div>
            <div class="form-item">
                <div><p>Posisi/Jabatan</p></div>
                <div>
                    <input type="text" name="jabatan">
                    <span class="tooltip" v-if="error_jabatan.length != 0">
                        @{{ error_jabatan }}
                    </span>
                </div>
            </div>
            <div class="form-item">
                <div><p>Status Karyawan</p></div>
                <div>
                    <div id="form-item-gender">
                        <div>
                            <input type="radio" name="status" value="masih">
                            <p>Masih Bekerja</p>
                        </div>
                        <div>
                            <input type="radio" name="status" value="tidak">
                            <p>Sudah Tidak Bekerja</p>
                        </div>
                    </div>
                    <span class="tooltip" v-if="error_status.length != 0">
                        @{{ error_status }}
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="form-item">
                <div><p>Gaji</p></div>
                <div>
                    <div>
                        <select name="matauang">
                            <option value="rupiah">Rupiah (Rp)</option>
                            <option value="dolar_us">US Dollar (USD)</option>
                            <option value="dolar_singapur">Singapore Dollar (SGD)</option>
                            <option value="ringgit">Malaysia Ringgit (RM)</option>
                        </select>
                        <input type="text" name="gaji">
                    </div>
                    
                    <span class="tooltip" v-if="error_gaji.length != 0">
                        @{{ error_gaji }}
                    </span>
                </div>
            </div>
            <div class="form-item">
                <div><p>Periode Pembayaran Gaji</p></div>
                <div id="form-item-periode">
                    <div>
                        <input type="radio" name="periode" value="bulan">
                        <p>Bulan</p>
                    </div>
                    <div>
                        <input type="radio" name="periode" value="tahun">
                        <p>Tahun</p>
                    </div>
                    <span class="tooltip" v-if="error_periode.length != 0">
                        @{{ error_periode }}
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="form-item">
                <div><input type="checkbox"></div>
                <div><p>Ya, Tulis Review</p></div>
            </div>
        </div>
        
        <div class="form-group" id="last-form-group">
            <div class="form-item">
                <div>
                    <button v-on:click="submitReview">Submit</button>
                    <p style="padding: 10px" v-if="message.length != 0">
                        @{{ message }}
                    </p>
                </div>
            </div>
        </div>

	</div>
</div>

@endsection