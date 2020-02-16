@extends('layout.master')

@section('title', 'Qerja TPA')

@section('style')
    <link rel="stylesheet" type="text/css" href="css/home.css">
@endsection

@section('script')
    <script src="js/home.js"></script>
@endsection

@section('content')
<div id="header">
    <div>
        <h1>SIAP MERAIH KARIER IMPIAN ANDA?</h1>
    </div>
    <div>
        <h4>Manfaatkan info dari orang dalam untuk mendorong kemajuan karier.</h4>
    </div>
    <div id="header-find">
        <i class="fa fa-search"></i>
        <input type="text" placeholder="ketik nama perusahaan atau posisi yang ingin kamu ketahui">
        <button>GO</button>
    </div>
</div>


<div id="content">
    @include('navReview')
    @include('slider')
    @include('info-gaji')
</div>

<!-- @include('footer') -->
@include('modal.modalHome')
@endsection