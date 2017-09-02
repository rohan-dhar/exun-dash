$(document).ready(function(){

	window.isEmail = function(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}		

	window.isPhone = function(num){
		var l = num.length;
		if(l !== 10){
			return false;
		}
		for(var i = 0; i < 10; i++){
			if(num[i].charCodeAt(0) < 48 || num[i].charCodeAt(0) > 57){;
				return false;
			}
		}
		return true;
	}


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