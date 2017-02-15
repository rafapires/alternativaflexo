<?php get_header(); ?>

<!-- start slider -->


<div id="carousel-frontpage" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-frontpage" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-frontpage" data-slide-to="1"></li>
    <li data-target="#carousel-frontpage" data-slide-to="2"></li>
    <li data-target="#carousel-frontpage" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
		<img src="<?php echo get_template_directory_uri(); ?>/img/slides/flexslider/banner4.jpg" alt="" />
      	<div class="carousel-caption">
			<h3>lavadora de Clichês - ACQUASOLVE</h3>
            <p>Soluções econômicas de alta qualidade</p>
            <a href="lavadora-de-cliche-acquasolve.php" class="btn btn-theme">Veja mais</a>
      </div>
    </div>
    <div class="item">
      <img src="<?php echo get_template_directory_uri(); ?>/img/slides/flexslider/banner2.jpg" alt="">
      <div class="carousel-caption">
  			<h3>SWED/CUT® Premium Doctor Blades</h3>
            <p>Aço e rebaixo totalmente produzido na suécia</p>
            <a href="laminas-swed-cut-doctor-blades.php" class="btn btn-theme">Veja mais</a>        
      </div>
    </div>
    <div class="item">
      <img src="<?php echo get_template_directory_uri(); ?>/img/slides/flexslider/banner3.jpg" alt="">
      <div class="carousel-caption">
  			<h3>DEMOUNTER</h3>
            <p>Sistema automático para descolagem de clichês</p>
            <a href="laminas-swed-cut-doctor-blades.php" class="btn btn-theme">Veja mais</a>        
      </div>
    </div>
    <div class="item">
      <img src="<?php echo get_template_directory_uri(); ?>/img/slides/flexslider/banner5.jpg" alt="">
      <div class="carousel-caption">
  			<h3>Lavadora de Anilox ECOCLEAN</h3>
            <p>Equipamento Automatizado 100% nacional. Desenvolvidas pela Flexocom, e fabricadas por nossa equipe</p>
            <a href="laminas-swed-cut-doctor-blades.php" class="btn btn-theme">Veja mais</a>        
      </div>
    </div>
    ...
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-frontpage" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-frontpage" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>




<!-- end slider -->




<?php get_footer(); ?>