<div id="modal-login" v-show="showLogin">
    <input type="hidden" id="token-login" value="{{ csrf_token() }}">
    
    <div>
        <img src="image/logo.jpg">
    </div>
    <div>
        <p>Masuk untuk meihat informasi Karir lebih banyak</p>
    </div>
    <div>
        <input type="text" placeholder="Email" name="login-email">
        <span class="tooltip" v-if="login_email_error.length != 0 ">
            @{{ login_email_error }}
        </span>
    </div>
    <div>
        <input type="password" placeholder="Password" name="login-password">
        <span class="tooltip" v-if="login_password_error.length != 0 ">
            @{{ login_password_error }}
        </span>
    </div>
    <div id="remember-container">
        <input type="checkbox" id="remember">
        <p>Ingat saya</p>
    </div>
    <div class="captcha-container">
        <div id="recaptcha-login" v-show="showLoginCaptcha"></div>
        <span class="tooltip" id="captcha-tooltip" v-if="login_captcha_error.length != 0 ">
            @{{ login_captcha_error }}
        </span>
    </div>
    <div>
        <button v-on:click="login">Masuk</button>
    </div>
    <div>
        <p v-if="message.length != 0">@{{ message }}</p>
        <div id="modal-loading" v-show="validating" >
            <div><img src="image/loading_qerja.gif"></div>
            <div><p>tunggu sebentar</p></div>
        </div>
        <p v-if="resend" id="resend" v-on:click="doResend()">
            kirim ulang konfirmasi email
        </p>
    </div>
</div>