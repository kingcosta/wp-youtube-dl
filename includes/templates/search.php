<?php
	get_header();
?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">	
			<div id="buttons" style="width: 100%;display: inline-flex;"> 
				<input id="query" type="text" style="width: 80%;" />
				<button id="search-button" style="width: 20%;">Buscar</button>
			</div>
			<div id="search-results">
			</div>
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
			<script>
			  	$(document).ready(function () {
				    $('#search-button').click(function (event) {
				        event.preventDefault();
				        var searchTerm = $('#query').val();			        
				        getRequest(searchTerm);
				    });

				    $('#query').change(function(){
				    	var searchTerm = $('#query').val();
				        if(searchTerm.length < 3){
				        	return;
				        }
				        getRequest(searchTerm);
				    });
				});

				function getRequest(searchTerm) {
				    url = 'https://www.googleapis.com/youtube/v3/search';
				    var params = {
				        part: 'snippet',
				        q: searchTerm,
				        //key: 'AIzaSyCGcN6lg12TmCeAm1SdQCz3jCCTqYuzNlA',
				        key: '<?php echo get_option('wp_youtube_dl-api_key'); ?>',
				        maxResults: <?php echo get_option('wp_youtube_dl-nro_max'); ?>
				    };
				  
				    $.getJSON(url, params, function (searchTerm) {
				        showResults(searchTerm);
				    });
				}

				function showResults(results) {
					console.log('results',results);
				    var html = "";
				    var entries = results.items;
				    
				    $.each(entries, function (index, value) {
				        var title = value.snippet.title;
				        var thumbnail = value.snippet.thumbnails.default.url;
				        html += '<p>' + title + '</p>';
				        html += '<img src="' + thumbnail + '">';
				    }); 
				    
				    $('#search-results').html(html);
				}
			</script>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();