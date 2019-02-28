<?php

function get_string_between($string, $start, $end){
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0) return '';
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}


function get_post_content($post) {
	return get_string_between($post->post_content, "#TEASER START#", "#TEASER END#")." ".get_string_between($post->post_content, "#MAIN START#", "#MAIN END#");
}

$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];



$all_products = get_posts(array( 'post_type' => 'product', 'posts_per_page' => -1 )); 	

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
	
	$productCollsString = get_string_between($m_product->post_content, $delimiterStart, $delimiterEnd);
	$productCollsArray = explode(',', $productCollsString);
	$productIsMadeByThisCollaborator = in_array($post->post_title, $productCollsArray);
	$collTitleIsNotEmpty = $post->post_title != '';
	
	if($productIsMadeByThisCollaborator && $collTitleIsNotEmpty) {
		array_push($products, $m_product); 
	}
}


?>


<div class="row col-sm-12" id="collaborator-content"> 
	<div class="col-sm-5 col-sm-push-7" id="collaborators-image">
		<img src=<?php echo $image; ?>>
	</div>
	<div class="col-sm-7 col-sm-pull-5 main-content"> 
		<div id="collaborators-text">
			 <?php echo get_post_content($post) ?>	
		</div>
	</div>
</div>

<div class="product-grid col-sm-12">
		<?php
		
		foreach($products as $product) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'single-post-thumbnail' )[0];
		?>

			<div>			
					<img  class="images-pointer" src=<?php echo $image ?> onclick="window.location.href='<?php echo get_post_permalink($product->ID) ?>'">
			</div>
		<?php
		}
		?>
</div>



