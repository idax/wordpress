<?php

function get_string_between($string, $start, $end){
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0) return '';
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}


function print_post_text($textCssId, $single_post) {
	?>
	<div id="<?php echo $textCssId ?>">	
		<p > <?php echo get_string_between($single_post->post_content, "#MAIN START#", "#MAIN END#") ?> </p>
	</div>
	<?php
}

$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0]; 

?>


<div class="row col-sm-12"> 
	<div class="col-sm-7"> 
		 <h2 id="collaborators-title"><?php echo $post->post_title; ?> </h2>
		 <p><?php echo print_post_text("collaborators-text", $post); ?></p> 
	</div>
	<div class="col-sm-5" id="collaborators-image">
		<img src=<?php echo $image; ?>>
	</div>
</div>


