function ajax(url, type, data){
	return $.ajax({
	    url : url,
	    type : type,
	    data : data
	});
}
function ajax(url, type, data, beforeSend){
	return $.ajax({
	    url : url,
	    type : type,
	    data : data,
	    beforeSend : beforeSend
	});
}



function hideModal(){
    vModalLogin.reset();
    vModalRegister.reset();
    vModalRegister.setShowRegister(false);
    vModalRegister.reset();
    vModalLogin.setShowLogin(false);
    vModalLogin.reset();
    vNav.page_mask_opened = false;
}



var recaptcha_login, recaptcha_register;
function setupCaptcha(){
    recaptcha_login = grecaptcha.render('recaptcha-login', {
        'sitekey' : '6LduZkgUAAAAANAX48704CBcZz8x7bYX3ioGD_Ku'
    });
    recaptcha_register = grecaptcha.render('recaptcha-register', {
        'sitekey' : '6LduZkgUAAAAANAX48704CBcZz8x7bYX3ioGD_Ku'
    });
}



firebase.initializeApp({
    apiKey: "AIzaSyC9FqtvwFYkClTLpsyJNKAvOOcBa-T87SU",
    authDomain: "qerja-tpa.firebaseapp.com",
    databaseURL: "https://qerja-tpa.firebaseio.com",
    projectId: "qerja-tpa",
    storageBucket: "qerja-tpa.appspot.com",
    messagingSenderId: "304017577837"
});
var firebaseDB = firebase.database();

