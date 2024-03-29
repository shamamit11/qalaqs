$('form input[type=text]').focus(function () {
	$(this).siblings(".error").hide();
});
$('form input[type=email]').focus(function () {
	$(this).siblings(".error").hide();
});
$('form input[type=password]').focus(function () {
	$(this).siblings(".error").hide();
});
$('form textarea').focus(function () {
	$(this).siblings(".error").hide();
});
$('form select').focus(function () {
	$(this).siblings(".error").hide();
});
$(".digits").keydown(function (e) {
	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		(e.keyCode >= 35 && e.keyCode <= 40)) {
		return;
	}
	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		e.preventDefault();
	}
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

var left_side_bar = ['default', 'condensed'];
var current_left_menu_size = 0;
if (localStorage.currentMenuSize)
    current_left_menu_size = Number(localStorage.currentMenuSize);
$('body').attr('data-leftbar-size', left_side_bar[current_left_menu_size]);
$('a#toggle-sidebar').data('id', current_left_menu_size);

$('a#toggle-sidebar').on('click', function(){
	var $this = $(this);
	var $this_index = $this.data('id') + 1;

	if($this_index > 1)
		$this_index = 0;

	$this.data('id', $this_index);
	localStorage.setItem("currentMenuSize", $this_index);

	$('body').attr('data-leftbar-size', left_side_bar[$this_index]);
});