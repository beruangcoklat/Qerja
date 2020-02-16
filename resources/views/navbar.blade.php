<div id="nav">
    <div id="page-mask" v-show="page_mask_opened" onclick="hideModal()"></div>
    <div id="loading-messier" v-show="loading_messier">
        <img src="image/loading_messier.gif">
    </div>

    <div class="nav-left">
        <div class="nav-left-item" style="display: block;">
            <a href="/">
                <img src="image/logo.png">
            </a>
        </div>
        <div class="nav-left-item" v-show="!cari_opened && role == 'member' || role == 'guest'">
            <a href="/company">
                <p v-if="language == 'indonesia'">Daftar Perusahaan</p>
                <p v-else>Company List</p>
            </a>
        </div>
        <div class="nav-left-item" v-show="!cari_opened && role != 'guest'">
            <a href="/chat">
                <p v-if="language == 'indonesia'">Ngobrol</p>
                <p v-else>Chat</p>
            </a>
        </div>
        <div class="nav-left-item" v-show="!cari_opened && role == 'member'">
            <a href="/feeds">
                <p>Feeds</p>
            </a>
        </div>
        <div class="nav-left-item" v-show="!cari_opened && role == 'admin'">
            <a href="/addCompany">
                <p v-if="language == 'indonesia'">Tambah Perusahaan</p>
                <p v-else>Add Company</p>
            </a>
        </div> 

        <div id="nav-cari" v-show="cari_opened">
            <i class="fa fa-search"></i>
            <input type="text" 
                class="search-bar" 
                v-bind:placeholder="language == 'indonesia' ? 'Cari' : 'Search'"
                v-on:keyup="search(0)"
            >
            <div id="rekomendasi">
                <div class="rekomendasi-item" 
                    v-for="data in rekomendasi"
                    v-on:click="go(data.id)"
                >
                    <img v-bind:src="'image/company/' + data.image">
                    <p style="color: black;">@{{ data.name }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="nav-right" v-if="role == 'guest'">
        <div class="nav-right-item" v-on:click="toggleCari()">
            <i class="fa fa-search" v-if="!cari_opened"></i>
            <i class="fa fa-close" v-else></i>
        </div>
        <div class="nav-right-item">
            <p v-on:click="toggleDropDownLanguage()" id="open-drop-down-language" v-if="language == 'indonesia'">Indonesia</p>
            <p v-on:click="toggleDropDownLanguage()" id="open-drop-down-language" v-else>English</p>
            <div id="drop-down" v-if="drop_down_language">
                <div v-on:click="changeLanguage('indonesia')"><p>Indonesia</p></div>
                <div v-on:click="changeLanguage('english')"><p>English</p></div>
            </div>
        </div>
        <div class="nav-right-item" v-on:click="toggleLogin()">
            <p v-if="language == 'indonesia'">Masuk</p>
            <p v-else>Login</p>
        </div>
        <div class="nav-right-item">
            <button id="btn-daftar" v-on:click="toggleRegister()" v-if="language == 'indonesia'">Daftar</button>
            <button id="btn-daftar" v-on:click="toggleRegister()" v-else>Register</button>
        </div>

        <div class="nav-right-item" id="hamburger-menu" v-on:click="toggleHamburger">
            <i class="fa fa-bars"></i>
        </div>
    </div>

    <div class="nav-right" v-else-if="role == 'member' || role == 'admin'">
        <div class="nav-right-item" v-on:click="toggleCari()">
            <i class="fa fa-search" v-if="!cari_opened"></i>
            <i class="fa fa-close" v-else></i>
        </div>
        <div class="nav-right-item">
            <div v-on:click="toggleDropDownNotif()" style="display: flex;">
                <i class="fa fa-bell" id="notif-click"></i>
                <h6 style="color: #fff">@{{ notif_count }}</h6>
            </div>
            <div id="notification-drop-down" v-show="drop_down_notif">
                <div class="notification-drop-down-item"
                    v-for="data in notifikasi"
                >
                    <h6
                        v-on:click="pindah(data)"
                    >
                        @{{ 'Ada ' + data.type + ' dari ' + data.company.name }}
                    </h6>
                </div>
            </div>
        </div>
        <div class="nav-right-item">
            <p v-on:click="toggleDropDownLanguage()" id="open-drop-down-language" v-if="language == 'indonesia'">Indonesia</p>
            <p v-on:click="toggleDropDownLanguage()" id="open-drop-down-language" v-else>English</p>
            <div id="drop-down" v-if="drop_down_language">
                <div v-on:click="changeLanguage('indonesia')"><p>Indonesia</p></div>
                <div v-on:click="changeLanguage('english')"><p>English</p></div>
            </div>
        </div>
        <div class="nav-right-item">
            <div>
                <i class="fa fa-user" v-on:click="toggleDropDown()" id="open-drop-down">
                    <label id="open-drop-down" v-if="language == 'indonesia'"> Akun</label>
                    <label id="open-drop-down" v-else> Account</label>
                </i>
            </div>
            <div id="drop-down" v-if="drop_down">
                <div><a href="/pengaturan" v-if="role =='member'"><p>Pengaturan</p></a></div>
                <div><p v-on:click="logout()">Logout</p></div>
            </div>
        </div>

        <div class="nav-right-item" id="hamburger-menu" v-on:click="toggleHamburger">
            <i class="fa fa-bars"></i>
        </div>
    </div>


    <!-- hamburger -->
    <div id="nav-responsive" v-show="show_hamburger">
        <div class="nav-responsive-item">
            <div>
                <i class="fa fa-search"></i>
                <input type="text" 
                    class="search-bar" 
                    placeholder="Cari" 
                    v-on:keyup="search(1)"
                >
                <i class="fa fa-remove"
                    v-on:click="resetResponsive()"
                ></i>
            </div>
            <div id="rekomendasi">
                <div class="rekomendasi-item" 
                    v-for="data in rekomendasi"
                    v-on:click="go(data.id)"
                >
                    <img v-bind:src="'image/company/' + data.image">
                    <p style="color: black;">@{{ data.name }}</p>
                </div>
            </div>
        </div>
        <div class="nav-responsive-item" v-show="role == 'member' || role == 'guest'">
            <a href="/company"><p>Daftar Perusahaan</p></a>
        </div>
        <div class="nav-responsive-item" v-show="role == 'member'">
            <a href="/reviewCompany"><p>Review Perusahaan</p></a>
        </div>
        <div class="nav-responsive-item" v-show="role == 'member'">
            <a href="/salary"><p>Review Gaji</p></a>
        </div>
        <div class="nav-responsive-item" v-show="role != 'guest'">
            <a href="/chat"><p>Ngobrol</p></a>
        </div>
        <div class="nav-responsive-item" v-show="role == 'member'">
            <a href="/feeds"><p>Feeds</p></a>
        </div>
        <div class="nav-responsive-item" v-show="role == 'admin'">
            <a href="/addCompany"><p>Tambah Perusahaan</p></a>
        </div> 

        <div class="nav-responsive-item last-item" v-if="role == 'guest'">
            <div><p v-on:click="toggleLogin()">Masuk</p></div>
            <div><button v-on:click="toggleRegister()"><p>Daftar</p></button></div>
        </div>
        <div class="nav-responsive-item last-item" v-else>
            <div><p v-on:click="logout()">Logout</p></div>
        </div>
    </div>
</div>

<div id="nav-space"></div>