<div id="modal-register" v-show="showRegister">
    <div>
        <img src="image/logo.jpg">
    </div>
    <div>
        <p>Daftar untuk meihat informasi Karir lebih banyak</p>
    </div>
    <div>
        <input type="text" placeholder="Nama Lengkap" name="regis-fullname">
        <span class="tooltip" v-if="fullname_error.length != 0 ">
            @{{ fullname_error }}
        </span>
    </div>
    <div>
        <input type="text" placeholder="Email" name="regis-email">
        <span class="tooltip" v-if="email_error.length != 0 ">
            @{{ email_error }}
        </span>
    </div>
    <div>
        <input type="password" placeholder="Password" name="regis-password">
        <span class="tooltip" v-if="password_error.length != 0 ">
            @{{ password_error }}
        </span>
    </div>
    <div>
        <input type="password" placeholder="Konfirmasi Password" name="regis-confirm-password">
        <span class="tooltip" v-if="confirm_error.length != 0 ">
            @{{ confirm_error }}
        </span>
    </div>
    <div class="captcha-container">
        <!-- <div class="g-recaptcha" data-sitekey="6LduZkgUAAAAANAX48704CBcZz8x7bYX3ioGD_Ku"></div> -->
        <div id="recaptcha-register"></div>
        <span class="tooltip" id="captcha-tooltip" v-if="captcha_error.length != 0 ">
            @{{ captcha_error }}
        </span>
    </div>
    <div>
        <button v-on:click="register">Daftar</button>
    </div>
    <div>
        <p v-if="message.length != 0">@{{ message }}</p>
        <div v-show="validating" id="modal-loading">
            <div><img src="image/loading_qerja.gif"></div>
            <div><p>tunggu sebentar</p></div>
        </div>
    </div>
</div>