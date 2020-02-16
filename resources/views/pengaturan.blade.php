@extends('layout.master')

@section('title', 'Qerja TPA')

@section('style')
    <link rel="stylesheet" type="text/css" href="css/pengaturan.css">
@endsection

@section('script')
    <script src="js/pengaturan.js"></script>
@endsection

@section('content')
<div id="content">
    <div id="content-left">
        <div><h3>Pengaturan</h3></div>
        <div><hr></div>
        <div class="content-left-menu" 
                v-bind:class="{ active : getActive('profile') }"
                v-on:click="setActive('profile')">
            <p>Foto Profil</p>
        </div>
        <div class="content-left-menu" 
                v-bind:class="{ active : getActive('password') }"
                v-on:click="setActive('password')">
            <p>Ganti Password</p>
        </div>
    </div>

    <div id="content-right" v-if="getActive('password')">
        <div><h3>Ganti Password</h3></div>
        <div><hr></div>
        <div id="form-password">
            <input type="hidden" id="token-update-password" name="_token" value="{{ csrf_token() }}">

            <div class="form-password-item">
                <div><p>Password lama</p></div>
                <div><input type="password" name="old-password"></div>
                <div v-if="error_old.length != 0">
                    <span class="tooltip">@{{ error_old }}</span>
                </div>
            </div>
            <div class="form-password-item">
                <div><p>Password baru</p></div>
                <div><input type="password" name="new-password"></div>
                <div v-if="error_new.length != 0">
                    <span class="tooltip">@{{ error_new }}</span>
                </div>
            </div>
            <div class="form-password-item">
                <div><p>Konfirmasi password baru</p></div>
                <div><input type="password" name="confirm-password"></div>
                <div v-if="error_confirm.length != 0">
                    <span class="tooltip">@{{ error_confirm }}</span>
                </div>
            </div>
            <div class="form-password-item">
                <div>
                    <button id="form-button" v-on:click="updatePassword()">
                        Ganti Password
                    </button>
                </div>
                
                <div v-if="loading" id="form-loading">
                    <div><img src="image/loading_qerja.gif"></div>
                    <div><p>tunggu sebentar</p></div>
                </div>
                
                <div v-if="message.length != 0">
                    @{{ message }}
                </div>
            </div>
        </div>
        <div><hr></div>
    </div>

    <div id="content-right" v-else>
        <div><h3>Ganti Foto Profil</h3></div>
        <div><hr></div>
        <form id="form-profile" enctype="multipart/form-data">
            <input type="hidden" id="token-update-profile-picture" name="_token" value="{{ csrf_token() }}">
            {{ csrf_field() }}

            <div>
                <img v-bind:src="'image/user/' + user_image">
            </div>
            <div>
                <input type="file" name="image" id="upload-image">
                <span class="tooltip" v-if="error_upload.length != 0">
                    @{{ error_upload }}
                </span>
            </div>
            <div>
                <button id="form-button">
                    Ganti Foto Profil
                </button>
            </div>
        </form>

        <div v-if="loading" id="form-loading">
            <div><img src="image/loading_qerja.gif"></div>
            <div><p>tunggu sebentar</p></div>
        </div>

        <div v-if="message.length != 0">
            <p>@{{ message }}</p>
        </div>
        
        <div><hr></div>
    </div>
</div>

@endsection