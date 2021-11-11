jQuery(document).ready(function ($) {
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
});