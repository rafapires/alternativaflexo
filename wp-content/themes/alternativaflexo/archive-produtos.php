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
			<h3 style="background-color: yellow">Título</h3>
			<p style="background-color: green">Descrição</p>
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