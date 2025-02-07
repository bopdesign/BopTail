<?php
/**
 * Optimize theme performance.
 */

namespace BopTail\Optimization;

/**
 * Remove wp-embed.min.js
 *
 * @return void
 */
function deregister_scripts() {
	wp_dequeue_script( 'wp-embed' );
}

add_action( 'wp_footer', __NAMESPACE__ . '\deregister_scripts' );

/**
 * Enqueue scripts and styles.
 *
 * @return void
 */
function disable_loading_css_js() {
	wp_dequeue_script( 'devicepx' );

	if ( ! is_user_logged_in() ) {
		wp_dequeue_style( 'dashicons' );

		wp_dequeue_script( 'jquery-ui-datepicker' );
	}

	if ( is_front_page() && ! is_user_logged_in() ) {
		wp_dequeue_style( 'wp-pagenavi' );
		wp_dequeue_style( 'search-filter' );
		wp_dequeue_style( 'search-filter-flatpickr' );
		wp_dequeue_style( 'search-filter-ugc-styles' );
		wp_dequeue_style( 'search-filter-debug' );

		wp_dequeue_script( 'search-filter' );
		wp_dequeue_script( 'search-filter-flatpickr' );
		wp_dequeue_script( 'jquery-ui-datepicker' );
	}
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\disable_loading_css_js', 9999 );

/**
 * Remove JS/CSS version for Speed Optimization.
 *
 * @param $src
 *
 * @return string
 */
function remove_js_css_version( $src ) {
	$parts = explode( '?ver', $src );

	return $parts[0];
}

//add_filter( 'script_loader_src', __NAMESPACE__ . '\remove_js_css_version', 15, 1 );
//add_filter( 'style_loader_src', __NAMESPACE__ . '\remove_js_css_version', 15, 1 );


function my_output_buffer_callback( $buffer, $phase ) {
	if ( is_user_logged_in() ) {
		return $buffer;
	}

	if ( $phase & PHP_OUTPUT_HANDLER_FINAL || $phase & PHP_OUTPUT_HANDLER_END ) {
		$lazy_load_script = '
		<script id="boptail-inline-script-optimization">
		function loadCSS(filename){ var l = document.createElement("link"); l.rel = "stylesheet"; l.href = filename; var h = document.getElementsByTagName("head")[0]; h.parentNode.insertBefore(l, h);}
		document.addEventListener("StartAsyncLoading",function(event){setTimeout(function(){let lazyVideoPlayer=[...document.querySelectorAll(".lazy-video-player")];lazyVideoPlayer.forEach(video=>{video.src=video.dataset.src;})},300);});
		var script_loaded=!1;function loadJSscripts(){if(!script_loaded){script_loaded=!0;var t=document.getElementsByTagName("script");for(i=0;i<t.length;i++)if(null!==t[i].getAttribute("data-src")){var e=document.createElement("script");e.src=t[i].getAttribute("data-src"),document.body.appendChild(e)}setTimeout(function(){document.dispatchEvent(new CustomEvent("StartAsyncLoading"));},200);setTimeout(function(){let lazyVideos=[...document.querySelectorAll(".lazy-video")];lazyVideos.forEach(video=>{video.getElementsByTagName("source")[0].src=video.getElementsByTagName("source")[0].dataset.src;if(window.innerWidth>0.5e3)video.load();else {video.load();video.play();}})},300);}}window.addEventListener("scroll",function(t){setTimeout(function(){loadJSscripts()},500);}),window.addEventListener("mousemove",function(){setTimeout(function(){loadJSscripts()},500);}),window.addEventListener("touchstart",function(){setTimeout(function(){loadJSscripts()},500);}),window.addEventListener?window.addEventListener("load",function(){setTimeout(loadJSscripts,4e3)},!1):window.attachEvent?window.attachEvent("onload",function(){setTimeout(loadJSscripts,4e3)}):window.onload=loadJSscripts;</script>
		';

		$buffer = str_replace( '</body>', $lazy_load_script . "\n</body>", $buffer );
	}

	return $buffer;
}

ob_start( function ( $buffer, $phase ) {
	return my_output_buffer_callback( $buffer, $phase );
} );
