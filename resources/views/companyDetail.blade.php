@extends('layout.master')

@section('title', 'Qerja TPA')

@section('style')
    <link rel="stylesheet" type="text/css" href="css/companyDetail.css">
@endsection

@section('script')
    <script src="js/companyDetail.js"></script>
    <script src="js/component/component-company-detail.js"></script>
@endsection

@section('content')
<div id="content">
    <div id="content-header">
        <div>
            <div v-if="companyData.CompanyImage != undefined">
                <img v-bind:src="'image/company/' + companyData.CompanyImage">
            </div>
            <div>
                <div><p>@{{ companyData.CompanyName }}</p></div>
                <div><p style="
                    color: blue;
                    text-decoration: underline;
                ">@{{ companyData.CompanyWebsite }}</p></div>
                <div>
                    <i class="fa fa-star"
                        v-for="i in 5"
                        v-bind:class="{ activeStar : i <= companyData.CompanyRating }"
                    ></i>
                </div>
            </div>
        </div>
        <div>
            <button>Tulis Gaji</button>
        </div>
        <div>
            <button>Tulis Review</button>
        </div>
        <div>
            <button style="background-color: #ff9800;">Ikuti</button>
        </div>
    </div>
    <div id="content-nav">
        <div v-bind:class="{ active : getActive('profil') }" v-on:click="setActive('profil')">
            <p>Profil</p>
        </div>
        <div v-bind:class="{ active : getActive('gaji') }" v-on:click="setActive('gaji')">
            <p>Gaji</p>
        </div>
        <div v-bind:class="{ active : getActive('review') }" v-on:click="setActive('review')">
            <p>Review</p>
        </div>
        <div v-bind:class="{ active : getActive('lowongan') }" v-on:click="setActive('lowongan')">
            <p>Lowongan Kerja</p>
        </div>
    </div>

    <company-detail-profile
         v-if="getActive('profil')"
         v-bind:data="companyData"
    ></company-detail-profile>

    <div id="real-content-gaji" v-else-if="getActive('gaji')">
        <div class="real-content-item">
            <p>Gaji @{{ companyData.CompanyName }}</p>
        </div>
        <div class="real-content-item">
            <p>@{{ gajiDatas.SalaryCount }} gaji untuk @{{ gajiDatas.PositionCount }} posisi</p>
        </div>
        <div class="real-content-item">
            <hr>
        </div>
        <div class="real-content-item">
            <company-detail-gaji
                v-for="i in gajiDatasShow"
                v-bind:data="i"
            ></company-detail-gaji>

            <company-detail-gaji-lock
                v-for="i in gajiDatasLock"
                v-bind:data="i"
            ></company-detail-gaji-lock>

            <div id="paginate-container">
                <company-paginate
                    v-for="i in last_page"
                    v-bind:data="i"
                    v-on:click.native="paging(i, 'gaji')"
                ></company-paginate>
            </div>
        </div>
    </div>

    <div id="real-content-review" v-else-if="getActive('review')">
        <div class="real-content-item">
            <p>Review @{{ companyData.CompanyName }}</p>
        </div>
        <div class="real-content-item">
            <p>@{{ reviewDatas.ReviewCount }} review</p>
        </div>
        <div class="real-content-item">
            <hr>
        </div>
        <div class="real-content-item">
            <company-detail-review
                v-for="i in reviewDatasShow"
                v-bind:data="i"
            ></company-detail-review>

            <company-detail-review-lock
                v-for="i in reviewDatasLock"
                v-bind:data="i"
            ></company-detail-review-lock>

            <div id="paginate-container">
                <company-paginate
                    v-for="i in last_page"
                    v-bind:data="i"
                    v-on:click.native="paging(i, 'review')"
                ></company-paginate>
            </div>
        </div>
    </div>
    
    <div id="real-content-lowongan" v-else-if="getActive('lowongan')">
        <div class="real-content-item">
            <p>Lowongan @{{ companyData.CompanyName }}</p>
        </div>
        <div class="real-content-item">
            <p>@{{ lowonganDatas.AvailableJobsCount }} lowongan</p>
        </div>
        <div class="real-content-item">
            <hr>
        </div>
        <div class="real-content-item">
            <company-detail-lowongan
                v-for="i in lowonganDatasShow"
                v-bind:data="i"
            ></company-detail-lowongan>

            <company-detail-lowongan-lock
                v-for="i in lowonganDatasLock"
                v-bind:data="i"
            ></company-detail-lowongan-lock>

            <div id="paginate-container">
                <company-paginate
                    v-for="i in last_page"
                    v-bind:data="i"
                    v-on:click.native="paging(i, 'lowongan')"
                ></company-paginate>
            </div>
        </div>
    </div>

</div>

@include('modal.modalHome')
@endsection