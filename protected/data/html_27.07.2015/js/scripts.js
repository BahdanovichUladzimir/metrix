var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;
$(window).scroll(function () {
	if ($(this).scrollTop() > 100) {
		$('body').addClass('menu-fix');
	}
	else {
		$('body').removeClass('menu-fix');
	}
});
$(function() {
	 $('select').selectpicker();
	 $('.fancybox').fancybox({
		tpl: {
			next: '<a title="" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
			prev: '<a title="" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>',
			closeBtn : '<a href="javascript:;" class="fancybox-item fancybox-close"></a>'
		}
	});
	$('.navbar-toggle').bind('click', function(){
		$('body').toggleClass('menu-static');
		$(window).scrollTop(0);
	});
	/*$('.rating-form span:not(.rating-form.static span)').hover(function(){
		$(this).prevAll().addClass('act');
		$(this).addClass('act');
	},
	function(){
		$(this).prevAll().removeClass('act');
		$(this).removeClass('act');
	});
	
	$('.rating-form span:not(.rating-form.static span)').click( function() {
		if(!$(this).data('fix')) return;
		$('#rating').val($(this).data('num'));
		$(this).addClass('active').nextAll().removeClass('active').end().prevAll().addClass('active');
	});*/
	$('.show-all').click(function(){
		$('#unvisible-'+$(this).data('name')).fadeIn(400);
		$(this).fadeOut(200).remove();
		return false;
	});
	$('.filter-toggle').click(function(){
		$('.filter-m-wrap').slideToggle(200);
		$(this).toggleClass('act');
		return false;
	});
	$('.edit, .ch-box-wrap .cat-name').click(function(){
		$(this).parent().toggleClass('act')
		return false;
	});
	

	$('.ch-box-wrap .checkbox').on('change', function(){
		$(this).toggleClass('act');
		return false;
	});
	$(document).click(function(event){
		if($(event.target).closest('.edit-wrap .dropdown-menu').length) 
		return;
		$('.edit-wrap').removeClass('act');
		event.stopPropagation();
	});
	var pane = $('.scroll-pane');
	pane.jScrollPane(
    {
        autoReinitialise: true,
		stickToBottom: true,
		maintainPosition: true,
    }
	);
	
	
});