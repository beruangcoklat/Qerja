<div id="slider">
    <div>
        <i class="fa fa-angle-double-left" v-on:click="updateSlider('left')"></i>
    </div>
    <div>
        <div class="company" v-for="data in getSlider(0)">
            <div class="company-top">
                <div class="company-top-left">
                    <img v-bind:src="'image/company/' + data.Reviewer_image">
                </div>
                <div class="company-top-right">
                    <div>
                        <p
                            v-on:click="gotoDetail(data.CompanyId)"
                        >@{{ data.CompanyName }}</p>
                    </div>
                    <div>
                        <div>
                            <i class="fa fa-star"
                                v-for="i in 5"
                                v-bind:class="{ activeStar : i <= data.CompanyRating }"
                            ></i>
                        </div>
                        <p>@{{ data.ReviewCount }} review</p>
                    </div>
                </div>
            </div>

            <div class="company-name">
                <div><i class="fa fa-thumbs-up"></i></div>
                <div><p>@{{ data.Reviewer }}</p></div>
            </div>

            <div class="company-content">
                <div class="review">
                    <p>@{{ data.ReviewPositive }}</p>
                </div>

                <div class="lihat"
                    v-on:click="gotoDetailReview(data.CompanyId)"
                >
                    <p>lihat semua review</p>
                </div>

                <div class="positif">
                    <p>@{{ data.HelpfulCount }} orang</p>
                    <p>berpikir review ini berguna</p>
                </div>
                
                <div class="deskripsi-judul">
                    <p>DESKRIPSI</p>
                </div>
                <p class="deskripsi-isi">
                    @{{ data.CompanyDescription.substr(0,50) }}
                    <label
                        v-on:click="gotoDetailReview(data.CompanyId)"
                    >... read more</label>
                </p>
            </div>

            <div style="padding: 5px; color: #aaa"
                v-on:click="gotoDetail(data.CompanyId)"
            >
                <p>Lebih lanjut tentang perusahaan ini</p>
            </div>
        </div>
    </div>

    <div>
        <i class="fa fa-angle-double-right" v-on:click="updateSlider('right')"></i>
    </div>
</div>