<?php
get_header();
?>
<div class="container" id="produtos">
<?php
if(have_posts()) : while(have_posts()) : the_post();?>
	<div class='row'>
		<div class='col-sm-4 col-sm-offset-1'>
			<?php 
			if (has_post_thumbnail() ){
				the_post_thumbnail('full',array('class' => 'img-responsive center-block'));
				}else{
				echo 'não';
			}
			?>
		</div>
		<div class='col-sm-6'>
			<?php
			the_title('<h3 style="background-color:orange;">','</h3>',true);
			the_excerpt('<p style="background-color:cyan;">','</p>',true);
			?>
		</div>
	</div>
<?php
	
// 	the_title();
// 	echo '<div class="af-produtos">';
// 	the_content();
// 	echo '</div>';
 endwhile; endif;
?>
</div>
<?php
get_footer();
?>