jQuery(document).ready(function ($) {
	// Load More button
	$(function($){
		$('.loadmore').click(function(){
	
			let button = $(this),
				data = {
				'action': 'loadmore',
				'query': loadmore_params.posts, // get params from wp_localize_script() function
				'page' : loadmore_params.current_page
			};
	
			$.ajax({
				url : loadmore_params.ajaxurl, // AJAX handler
				data : data,
				type : 'POST',
				beforeSend : function ( xhr ) {
					button.text('Loading...'); 
				},
				success : function( data ){
					if( data ) { 
						button.text( 'Load More Posts' ).prev().before(data); // insert new posts
						loadmore_params.current_page++;
	
						if ( loadmore_params.current_page == loadmore_params.max_page ) {
							button.remove(); // if last page, remove the button
						}
							
					} else {
						button.remove(); // if no data, remove the button
					}
				}
			});
		});
	});

	// Infinite scroll
	$(function($){
		var canBeLoaded = true,
			bottomOffset = 9000;
	
		$(window).scroll(function(){
			var data = {
				'action': 'loadmore',
				'query': loadmore_params.posts,
				'page' : loadmore_params.current_page
			};
			if( $(document).scrollTop() > ( $(document).height() - bottomOffset ) && canBeLoaded == true ){
				$.ajax({
					url : loadmore_params.ajaxurl,
					data:data,
					type:'POST',
					beforeSend: function( xhr ){
						// ajax call is in process
						canBeLoaded = false; 
					},
					success:function(data){
						if( data ) {
							$('#main').find('article:last-of-type').after( data ); // insert posts
							canBeLoaded = true; // ajax is completed
							loadmore_params.current_page++;
						}
					}
				});
			}
		});
	});
});