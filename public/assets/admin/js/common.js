$('form input[type=text]').focus(function(){
	$(this).siblings(".error").hide();
});
$('form input[type=email]').focus(function(){
	$(this).siblings(".error").hide();
});
$('form input[type=password]').focus(function(){
	$(this).siblings(".error").hide();
});
$('form textarea').focus(function(){
	$(this).siblings(".error").hide();
});
$('form select').focus(function(){
	$(this).siblings(".error").hide();
});
toastr.options = {
	"closeButton": false,
	"debug": false,
	"newestOnTop": true,
	"progressBar": true,
	"positionClass": "toast-top-right",
	"preventDuplicates": false,
	"onclick": null,
	"showDuration": 300,
	"hideDuration": 2000,
	"timeOut": 5000,
	"extendedTimeOut": 2000,
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut"
  }