<?php

//Empty
//This eliminates the default comments form for wordpress

$options = get_option('saic_options');

if($options['auto_show'] == 'true' && $options['where_add_comments_box'] == 'same-place'){
		echo display_saic();
}
?>