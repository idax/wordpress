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

$all_products = get_posts(array( 'post_type' => 'product', 'posts_per_page' => -1 )); 	//Hent alle produkter
$products = [];																			//Lav array som vi kan gemme de produkter vi egentlig vil vise

$delimiterStart;
$delimiterEnd;
switch ($post->post_type) {
    case 'f_designer':
		$delimiterStart = '¤designers¤';
		$delimiterEnd = '¤/designers¤';
        break;
    case 'f_distributor':
		$delimiterStart = '¤distributors¤';
		$delimiterEnd = '¤/distributors¤';
        break;
    case 'f_manufacturer':
		$delimiterStart = '¤manufacturers¤';
		$delimiterEnd = '¤/manufacturers¤';
		break;
	default:
		$delimiterStart = 'NOPE';
		$delimiterEnd = 'NOPE';
}

foreach($all_products as $m_product) {
	$collaborators_on_product =  explode(',', get_string_between($m_product->post_content, $delimiterStart, $delimiterEnd));
	if($post->post_title != '' && in_array($post->post_title, $collaborators_on_product)) {
		array_push($products, $m_product);
	}
}

?>


<div class="row col-sm-12" id="collaborator-content"> 
	<div class="col-sm-7"> 
		 <h2 id="collaborators-title"><?php echo $post->post_title; ?> </h2>
		 <p><?php echo print_post_text("collaborators-text", $post); ?></p> 
	</div>
	<div class="col-sm-5" id="collaborators-image">
		<img src=<?php echo $image; ?>>
	</div>

	<div>
		<?php
		foreach($products as $product) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'single-post-thumbnail' )[0];
		?>
		


		<div>
				<img src=<?php echo $image ?>>
		</div>
		


		<?php
		}
		?>
	</div>


</div>



