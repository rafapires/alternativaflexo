<?php
get_header();
if (have_posts()) :
   while (have_posts()) :
      the_post();
         the_content();
         echo '<hr />';
         $array = get_post_meta( $post->ID, '_complemento_nome', false);
         print_r($array);
         echo '<hr />';
         $array2 = get_post_meta( $post->ID, '_sidebar_produtos', false);
         print_r($array2);
   endwhile;
endif;
echo 'produto single';
get_footer(); 
?>