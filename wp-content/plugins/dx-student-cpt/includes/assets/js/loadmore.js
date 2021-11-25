jQuery(document).ready(function ($) {
	// Load More button
		$('body').on('click', '.loadmore', function(){
			let button = $(this),
			currentPage = button.data( 'current-page' ),
			maxPage = button.data( 'max-page' ),
			queryArgs = button.data( 'args' );

			$.ajax({
				url : loadmore_params.ajaxurl, // AJAX handler
				data : {
					'action': 'loadmore',
					'query': queryArgs,
					'page' : currentPage,
				},
				type : 'POST',
				beforeSend : function ( xhr ) {
					button.text('Loading...'); // some type of preloader
				},
				success : function( data ){
					currentPage++;
					button.text('More Posts').data( 'current-page', currentPage ).before(data);
	
					if( currentPage == maxPage ) {
						button.remove();
					}
	
				}
			});
		});


	/* // Infinite scroll
	$(function($){
		let canBeLoaded = true,
			bottomOffset = 9000;
	
		$(window).scroll(function(){
			let data = {
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
	});*/
}); 