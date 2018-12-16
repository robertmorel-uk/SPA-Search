/*
Basic WordPress Ajax search request
Filename: ajax_get_search.js
Use only in plugin or modify for theme
User enters search text
On key up over 500ms run function to do ajax
Pass input field search text to ajax function
Pass to php on server
Get relevant search result response back
*/
(function($) {

$("#spasearch-ajax-search-results-container-main").on("click",".spasearch-ft-ajax-post-title-main", function(){
      amw_spa_clicked_title_id = $(this).attr('id');
      spasearch_search_ajax_show_post_main( amw_spa_clicked_title_id )


});

function spasearch_search_ajax_show_post_main( $amw_spa_clicked_title_id ) {
	//event.preventDefault();
    $('#spasearch-ajax-post-container-main').html( "<div class='loader'></div>" );
    //alert($amw_spa_clicked_title_id);
	$.ajax({
		url: amwspasearchconf.ajax_url,
		type: 'post',
		data: {
			action: 'spasearch_ajax_get_post_main',
			//query_vars: spasearchajaxgetpostsvar.query_vars,
            igetsearchpostmain: $amw_spa_clicked_title_id
		},
		success: function( result ) {
            //$('#spasearch-ajax-search-results-container-main').css("opacity", "0");
			$('#spasearch-ajax-post-container-main').html( result );
            //$('#spasearch-ajax-search-results-container-main').animate({opacity: "1"},1000);

		}
	})
}

var i_changeInterval_main = null;

$("#spasearch-ajax-search-input-main").keyup(function() {
    clearInterval(i_changeInterval_main)

    i_changeInterval_main = setInterval(function() {
        var isearch_input_main = $('#spasearch-ajax-search-input-main').val();
        if (isearch_input_main != ""){spasearch_search_ajax_main(isearch_input_main);} 
        else { $('#spasearch-ajax-search-results-container-main')
            .html("<h6 class='spasearch-ajax-search-form-text-main'>Please enter a search term to see results....</h6>"); }
        clearInterval(i_changeInterval_main)
    }, 500);

});

function spasearch_search_ajax_main( $isearch_input_main ) {
	//event.preventDefault();
    $('#spasearch-ajax-search-results-container-main').html( "<div class='loader'></div>" );
	$.ajax({
		url: amwspasearchconf.ajax_url,
		type: 'post',
		data: {
			action: 'spasearch_ajax_get_search_main',
			//query_vars: spasearchajaxgetpostsvar.query_vars,
            igetsearchresultsmain: $('#spasearch-ajax-search-input-main').val()
		},
		success: function( result ) {
            //$('#spasearch-ajax-search-results-container-main').css("opacity", "0");
			$('#spasearch-ajax-search-results-container-main').html( result ); 
            //$('#spasearch-ajax-search-results-container-main').animate({opacity: "1"},1000);

		}
	})
}

})(jQuery);