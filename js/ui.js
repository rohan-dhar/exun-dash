$(document).ready(function(){
	$(document).scroll(function(){
		var n = 200, scroll = window.scrollY;

		var scalePerScroll = 0.7 / n, opacityPerScroll = 1.2/n;

		if(scroll < n){	
			$(".ui-page-head").stop().velocity({
				"scaleX": (1 - scalePerScroll * scroll),
				"scaleY": (1 - scalePerScroll * scroll),
				"opacity": (1 - opacityPerScroll * scroll),
			}, 40);
			$(".ui-page-desc").stop().velocity({
				"opacity": (1 - opacityPerScroll * scroll),
				"scaleX": (1 - scalePerScroll * scroll),
				"scaleY": (1 - scalePerScroll * scroll),
			}, 40);
		}else{
			$(".ui-page-head").css({
				"scaleX": (1 - scalePerScroll * n),
				"scaleY": (1 - scalePerScroll * n),
				"opacity": (1 - opacityPerScroll * n),
			});			
		}

	});
});