$(function() {
	 $('select').selectpicker();
	 $('.fancybox').fancybox({
		tpl: {
			next: '<a title="" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
			prev: '<a title="" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>',
			closeBtn : '<a href="javascript:;" class="fancybox-item fancybox-close"></a>',
		}
	});
	 $('.rating-form span:not(.rating-form.static span)').hover(function(){
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
	});
	$('.show-all').click(function(){
		$('#unvisible-'+$(this).data('name')).fadeIn(400);
		$(this).fadeOut(200).remove();
		return false;
	});
});