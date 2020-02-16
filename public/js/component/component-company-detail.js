Vue.component('company-detail-profile', {
    props : ['data'],
    template : `
        <div id="real-content-profil">
            <div class="real-content-item">
                <p>Profil {{ data.CompanyName }}</p>
            </div>
            <div class="real-content-item">
                <table>
                    <tr>
                        <td><p>Nama Perusahaan:</p></td>
                        <td><p>{{ data.CompanyName }}</p></td>
                    </tr>
                    <tr>
                        <td><p>Negara:</p></td>
                        <td><p>{{ data.CompanyCountry }}</p></td>
                    </tr>
                    <tr>
                        <td><p>Sub Industri:</p></td>
                        <td><p>{{ data.CompanyCategory }}</p></td>
                    </tr>
                </table>
            </div>
            <div class="real-content-item">
                <div><p>Deskripsi</p></div>
                <div>
                    <p>
                        {{ data.CompanyDescription }}
                    </p>
                </div>
            </div>

            <div class="real-content-item last-real-content-item">
                <div>
                    <div>
                        <i class="fa fa-map-marker"></i>
                        <p>Lokasi</p>
                    </div>
                    <div>
                        <p>{{ data.CompanyLocation }}</p>
                    </div>
                </div>
                <div>
                    <div>
                        <i class="fa fa-envelope"></i>
                        <p>Email</p>
                    </div>
                    <div>
                        <p>{{ data.CompanyEmail }}</p>
                    </div>
                </div>
                <div>
                    <div>
                        <i class="fa fa-phone"></i>
                        <p>No Telepon</p>
                    </div>
                    <div>
                        <p>{{ data.CompanyPhone }}</p>
                    </div>
                </div>
                <div>
                    <div>
                        <i class="fa fa-globe"></i>
                        <p>Website</p>
                    </div>
                    <div>
                        <p>{{ data.CompanyWebsite }}</p>
                    </div>
                </div>
            </div>
        </div>
    `,
});


Vue.component('company-detail-gaji', {
    props : ['data'],
    template : `
        <div class="real-content-item-item">
            <div class="real-content-item-item-left">
                <div><p>{{ data.PositionName }}</p></div>
                <div><p>{{ data.CompanyName }}</p></div>
                <div><p>{{ data.PositionCount }} data gaji</p></div>
            </div>
            <div class="real-content-item-item-mid">
                <p>Rp. {{ data.AverageSalary }}</p>
            </div>
            <div class="real-content-item-item-right">
                <div><input type="range" disabled></div>
                <div><p>Rp {{ data.MinSalary }} - Rp {{ data.MaxSalary }}</p></div>
            </div>
        </div>
    `,
});


Vue.component('company-detail-gaji-lock', {
    props : ['data'],
    template : `
        <div class="real-content-item-item" id="lock-gaji">
            <div class="real-content-item-item-left">
                <div><p>{{ data.PositionName }}</p></div>
                <div><p>{{ data.CompanyName }}</p></div>
                <div><p>{{ data.PositionCount }} data gaji</p></div>
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
    `,
});


Vue.component('company-detail-review', {
    props : ['data'],
    template : `
        <div class="real-content-item-item">
            <div>
                <div><i class="fa fa-user"></i></div>
                <div><p>{{ data.PositionName }}</p></div>
            </div>
            <div>
                <div>
                    <i class="fa fa-star" 
                        v-for="i in 5"
                        v-bind:style="{ color : (i <= data.ReviewRating) ? 'orange' : '#ccc' }"
                    ></i>
                </div>
                <div>
                    <p>
                        {{ data.ReviewCity }} - 
                        {{ new Date(data.ReviewTime.date).toDateString() }}
                    </p>
                </div>
            </div>
            <div>
                <div>
                    <div><i class="fa fa-thumbs-up"></i></div>
                    <div>
                        <p>{{ data.ReviewPositive }}</p>
                    </div>
                </div>
                <div>
                    <div><i class="fa fa-thumbs-down"></i></div>
                    <div>
                        <p>{{ data.ReviewNegative }}</p>
                    </div>
                </div>
            </div>
            <div class="other-rating">
                <div class="other-rating-item">
                    <div><p>Gaji & Tunjangan</p></div>
                    <div>
                        <i class="fa fa-star" 
                            v-for="i in 5"
                            v-bind:style="{ color : (i <= data.ReviewGajiTunjangan) ? 'orange' : '#ccc' }"
                        ></i>
                    </div>
                </div>
                <div class="other-rating-item">
                    <div><p>Jenjang Karir</p></div>
                    <div>
                        <i class="fa fa-star" 
                            v-for="i in 5"
                            v-bind:style="{ color : (i <= data.ReviewJenjangKarir) ? 'orange' : '#ccc' }"
                        ></i>
                    </div>
                </div>
                <div class="other-rating-item">
                    <div><p>Manajemen Senior</p></div>
                    <div>
                        <i class="fa fa-star" 
                            v-for="i in 5"
                            v-bind:style="{ color : (i <= data.ReviewManajemenSenior) ? 'orange' : '#ccc' }"
                        ></i>
                    </div>
                </div>
                <div class="other-rating-item">
                    <div><p>Work/Life Balance</p></div>
                    <div>
                        <i class="fa fa-star" 
                            v-for="i in 5"
                            v-bind:style="{ color : (i <= data.ReviewWorkLifeBalance) ? 'orange' : '#ccc' }"
                        ></i>
                    </div>
                </div>
                <div class="other-rating-item">
                    <div><p>Nilai & Budaya</p></div>
                    <div>
                        <i class="fa fa-star" 
                            v-for="i in 5"
                            v-bind:style="{ color : (i <= data.ReviewNilaiBudaya) ? 'orange' : '#ccc' }"
                        ></i>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <button
                        v-on:click="vCompanyDetail.helpful(data)"
                        v-bind:style="{ 'background-color' : data.ReviewHelpfulAlready ? 'orange' : '#ccc' }"
                    >Helpful</button>
                </div>
                <div><p>{{ data.ReviewHelpful }} orang berpikir review ini berguna</p></div>
            </div>
        </div>  
    `,
});


Vue.component('company-detail-review-lock', {
    props : ['data'],
    template : `
        <div class="real-content-item-item">
            <div>
                <div><i class="fa fa-user"></i></div>
                <div><p>{{ data.PositionName }}</p></div>
            </div>
            <div>
                <div>
                    <i class="fa fa-star" 
                        v-for="i in 5"
                        v-bind:style="{ color : (i <= data.ReviewRating) ? 'orange' : '#ccc' }"
                    ></i>
                </div>
                <div>
                    <p>
                        {{ data.ReviewCity }} - 
                        {{ new Date(data.ReviewTime.date).toDateString() }}
                    </p>
                </div>
            </div>
            <div>
                <p>terkunci</p>
            </div>
            <div>
                <div>
                    <button
                        v-on:click="vCompanyDetail.helpful(data)"
                    >Helpful</button>
                </div>
                <div><p>{{ data.ReviewHelpful }} orang berpikir review ini berguna</p></div>
            </div>
        </div>  
    `,
});


Vue.component('company-detail-lowongan', {
    props : ['data'],
    template : `
        <div class="real-content-item-item">
            <div class="real-content-item-item-ori">
                <div class="position">
                    <p>{{ data.PositionName }}</p>
                </div>
                <div class="company">
                    <div>
                        <p>{{ data.CompanyName }} -</p>
                    </div>
                    <div><i class="fa fa-map-marker"></i></div>
                    <div><label>{{ data.Location }}</label></div>
                </div>
                <div class="salary">
                    <div><p>Gaji : </p></div>
                    <div><p>{{ data.Salary }}</p></div>
                </div>
                <div class="description">
                    <p>{{ data.Description }}</p>
                </div>
            </div>
        </div>
    `,
});


Vue.component('company-detail-lowongan-lock', {
    props : ['data'],
    template : `
        <div class="real-content-item-item" id="lock-lowongan">
            <div class="real-content-item-item-ori">
                <div class="position">
                    <p>{{ data.PositionName }}</p>
                </div>
                <div class="company">
                    <div>
                        <p>{{ data.CompanyName }} -</p>
                    </div>
                    <div><i class="fa fa-map-marker"></i></div>
                    <div><label>{{ data.Location }}</label></div>
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
    `,
});

