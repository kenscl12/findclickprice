fileUploadHandler = function(file){
	// file
	var exts = ['jpg', 'jpeg', 'png'];

	var get_ext = file.name.split('.');
	get_ext = get_ext.reverse();
	if ($.inArray(get_ext[0].toLowerCase(), exts) == -1){
		$('.fileSearch').css("background-color", '#FF6F00');
		$('#fileName>div').text('Неверный формат файла');
		return false;
	}
	
	$('#fileName>div').text(file.name.split('\\').pop());
	$('.fileSearch').css("background-color", '#B7DE00');
	$('.loading-container').fadeIn(1000);
	$('.searchWidget').submit();
}

// ^https?://(?:[a-z0-9\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpg|gif|png)$

function checkSearch(elem) {
	if (!(document.all && !window.atob)) {
		var placeholderVal = $('.input__elem_search').attr("placeholder");

		$(elem).focusin(function () {
			if ($(elem).val() == '') {
				$(elem).attr("placeholder", "");
			}
		});

		$(elem).blur(function () {
			if ($(elem).val() == '') {
				$(elem).attr("placeholder", $(elem).attr("placeholder_"));
			}
		});
	}
}

checkSearch(".input__elem_search");

$(".input__elem_search").on("keyup", function () {
	checkSearch(".input__elem_search");
});

if (document.all && !window.atob) {//placeholder IE <= 9
	var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0) // If Internet Explorer, return version number
    {
		
    }
    else  // If another browser, return 0
    {
		$('input').placeholder();
    }
	
} else { // //placeholder IE > 9 and any browser
	$('.input__elem_search').attr("placeholder_", $('.input__elem_search').attr("placeholder")); 
}
	
$(".modal-fullscreen").on('show.bs.modal', function () {
	
	var videofile = document.getElementById('videofile');
	var videourl = document.getElementById('videourl');
	
	var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");


        videofile.currentTime = '0';
		videourl.currentTime = '0';
	
	videofile.play();
	videourl.play();
	
	$('.ali-close').show();
	setTimeout( function() {
	$(".modal-backdrop").addClass("modal-backdrop-fullscreen");
}, 0);
});

$(".modal-fullscreen").on('hidden.bs.modal', function () {
  $(".modal-backdrop").addClass("modal-backdrop-fullscreen");
  $('.ali-close').hide();
});

$('.ali-close').click(function(){
	$('#modal-video_URL, #modal-video_file').modal('hide');
	$(this).hide();
});
/*
var curVid = getElementById('videofile');

$(document).on('click','#replayBtn',function(){
    curVid.pause();
    curVid.currentTime = '0';
    curVid.play();
});
*/



var b = $('.bxslider-down').bxSlider({
  mode: 'vertical',
  slideMargin: 21,
  auto: true,
  infiniteLoop: true,
  minSlides: 4,
  maxSlides: 4,
  speed: 108000,
  ticker: true,
	pause: 0,
	
	auto: true,
	autoStart: true,
	autoDirection: 'prev',
	autoHover: false,
	autoDelay: 0,
	stopAuto: false,
	tickerDirection: 'prev',
});
var a = $('.bxslider-up').bxSlider({
  mode: 'vertical',
  slideMargin: 21,
  auto: true,
  infiniteLoop: true,
  minSlides: 4,
  maxSlides: 4,
  speed: 108000,
  ticker: true,
	pause: 0,
	
	auto: true,
	autoStart: true,
	autoDirection: 'next',
	autoHover: false,
	autoDelay: 0,
	stopAuto: false,
	tickerDirection: 'next',
});

