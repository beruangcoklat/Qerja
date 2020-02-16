@extends('layout.master')

@section('title', 'Qerja TPA')

@section('style')
    <link rel="stylesheet" type="text/css" href="css/addCompany.css"> 
@endsection

@section('script')
    <script src="js/addCompany.js"></script>
@endsection

@section('content')
<div id="content">
    <form id="add-company-form" method="post" enctype="multipart/form-data">
        <input type="hidden" id="token-add-company" name="_token" value="{{ csrf_token() }}">
        <table>
            <tr>
                <td><p>Nama Perusahaan</p></td>
                <td><input type="text" name="nama"></td>
                <td v-if="err_nama.length != 0">
                    <span class="tooltip">@{{ err_nama }}</span>
                </td>
            </tr>
            <tr>
                <td><p>Negara</p></td>
                <td>
                    <select name="negara" v-on:change="updateCities()">
                        <option value="">Choose</option>
                        <option
                            v-for="i in countries"
                            v-bind:value="i.name">
                            @{{ i.name }}
                        </option>
                    </select>
                </td>
                <td v-if="err_negara.length != 0">
                    <span class="tooltip">@{{ err_negara }}</span>
                </td>
            </tr>
            <tr>
                <td><p>Kota</p></td>
                <td>
                    <select name="kota">
                        <option value="">Choose</option>
                        <option 
                            v-for="i in cities"
                            v-bind:value="i.id">
                            @{{ i.name }}
                        </option>
                    </select>
                    <img src="image/loading_qerja.gif" v-bind:style="{ visibility: show_loading_city }">
                </td>
                <td v-if="err_kota.length != 0">
                    <span class="tooltip">@{{ err_kota }}</span>
                </td>
            </tr>
            <tr>
                <td><p>Industri</p></td>
                <td>
                     <select name="industri">
                        <option value="">Choose</option>
                        <option 
                            v-for="i in categories"
                            v-bind:value="i.id"
                        >@{{ i.name }}</option>
                    </select>
                </td>
                <td v-if="err_industri.length != 0">
                    <span class="tooltip">@{{ err_industri }}</span>
                </td>
            </tr>
            <tr>
                <td><p>Foto</p></td>
                <td><input type="file" name="foto"></td>
                <td v-if="err_foto.length != 0">
                    <span class="tooltip">@{{ err_foto }}</span>
                </td>
            </tr>
            <tr>
                <td><p>Lokasi</p></td>
                <td><textarea name="lokasi"></textarea></td>
                <td v-if="err_lokasi.length != 0">
                    <span class="tooltip">@{{ err_lokasi }}</span>
                </td>
            </tr>
            <tr>
                <td><p>Deskripsi</p></td>
                <td><textarea name="deskripsi"></textarea></td>
                <td v-if="err_deskripsi.length != 0">
                    <span class="tooltip">@{{ err_deskripsi }}</span>
                </td>
            </tr>
            <tr>
                <td><p>Website</p></td>
                <td><input type="text" name="website"></td>
                <td v-if="err_website.length != 0">
                    <span class="tooltip">@{{ err_website }}</span>
                </td>
            </tr>
            <tr>
                <td><p>Email</p></td>
                <td><input type="text" name="email"></td>
                <td v-if="err_email.length != 0">
                    <span class="tooltip">@{{ err_email }}</span>
                </td>
            </tr>
            <tr>
                <td><p>Phone</p></td>
                <td><input type="text" name="phone"></td>
                <td v-if="err_phone.length != 0">
                    <span class="tooltip">@{{ err_phone }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <button>Submit</button>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                     <div v-show="loading" id="form-loading">
                        <div><img src="image/loading_qerja.gif"></div>
                        <div><p>tunggu sebentar</p></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                     <div v-if="message.length != 0">
                        <p>@{{ message }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>

@endsection