jQuery(function($){
		
		var FEED = window.FEED || {};	
		
		//------ TWEETS ------//
			
		FEED.TWEET = function() {					
			$('.tweets_feed').twittie({
				template: 
				'<div class="tweet_user">'+
					'<span class="icon-twitter"><i class="fa fa-twitter"></i></span>'+
					'<span class="username">{{screen_name}}</span>'+
				'</div>'+
				'<div class="tweet_text">'+
					'{{tweet}}'+
				'</div>'+
				'<div class="tweet_time">'+
					'<a href="{{url}}">{{date}}</a>'+
				'</div>'
				,
			}, function(){
				$(".tweets_feed").owlCarousel({
		
					pagination : true,
					navigation : true,
					autoPlay: true,
					singleItem: true
				});
			});
		}
		

		
		  $(document).ready(function(){
				// FEED.TWEET();
			});
	
	});
	 