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
/* $(window).scroll(function () {
	if ($(this).scrollTop() > 100) {
		$('body').addClass('menu-fix');
	}
	else {
		$('body').removeClass('menu-fix');
	}
}); */
$(window).scroll(function () {
	if ($(this).scrollTop() > 200) {
		$('.scroll-top').fadeIn();
	} 
	else {
		$('.scroll-top').fadeOut();
		}
});

$(function() {
		
	$('select').selectpicker();

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
	$('.sub-cat > a').click(function(){
		$('.hidden-subcat-menu-item').show();
		$(this).remove();
		return false;
	});
	$('.edit, .ch-box-wrap .pr-type, .search-icon').click(function(){
		$(this).parent().toggleClass('act');
		return false;
	});
	$('.search-icon').on('click', function(){
		$('.search-toggle').toggleClass('act');
		return false;
	});
	$('.add-review').on('click', function(){
		$('.review-form').parent().toggle();
		return false;
	});
	$('.ch-box-wrap .checkbox').change(function(){
		$(this).toggleClass('act');
		return false;
	});
	if ($.browser.msie) { 
		$('.ch-box-wrap .checkbox').bind('click', function(){
			$(this).toggleClass('act');
			this.blur();  
			this.focus();
			return false;
		});
	}
	$(document).click(function(event){
		if($(event.target).closest('.edit-wrap .dropdown-menu, .search-toggle').length) 
		return;
		$('.edit-wrap').removeClass('act');
		$('.search-toggle').removeClass('act');
		event.stopPropagation();
	});

	/*var pane = $('.scroll-pane');
	pane.jScrollPane(
    {
        autoReinitialise: true,
		stickToBottom: true,
		maintainPosition: true,
    }
	);*/
	$('.scroll-top').click(function () {$('body,html').animate({scrollTop: 0}, 400); return false;});
	
});