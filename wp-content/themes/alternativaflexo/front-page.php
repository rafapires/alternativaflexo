<?php get_header(); ?>


<section id="carousel"><!-- start slider -->

    <div id="carousel-frontpage" class="carousel slide" data-ride="carousel">

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
    		<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/img/slides/flexslider/banner4.jpg" alt="" />
          	<div class="carousel-caption">
    			<h3>lavadora de Clichês - ACQUASOLVE</h3>
                <p>Soluções econômicas de alta qualidade</p>
                <a href="lavadora-de-cliche-acquasolve.php" class="btn btn-theme">Veja mais</a>
          </div>
        </div>
        <div class="item">
          <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/img/slides/flexslider/banner2.jpg" alt="">
          <div class="carousel-caption">
      			<h3>SWED/CUT® Premium Doctor Blades</h3>
                <p>Aço e rebaixo totalmente produzido na suécia</p>
                <a href="laminas-swed-cut-doctor-blades.php" class="btn btn-theme">Veja mais</a>        
          </div>
        </div>
        <div class="item">
          <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/img/slides/flexslider/banner3.jpg" alt="">
          <div class="carousel-caption">
      			<h3>DEMOUNTER</h3>
                <p>Sistema automático para descolagem de clichês</p>
                <a href="laminas-swed-cut-doctor-blades.php" class="btn btn-theme">Veja mais</a>        
          </div>
        </div>
        <div class="item">
          <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/img/slides/flexslider/banner5.jpg" alt="">
          <div class="carousel-caption">
      			<h3>Lavadora de Anilox ECOCLEAN</h3>
                <p>Equipamento Automatizado 100% nacional. Desenvolvidas pela Flexocom, e fabricadas por nossa equipe</p>
                <a href="laminas-swed-cut-doctor-blades.php" class="btn btn-theme">Veja mais</a>        
          </div>
        </div>
        ...
      </div>

      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carousel-frontpage" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-frontpage" data-slide-to="1"></li>
        <li data-target="#carousel-frontpage" data-slide-to="2"></li>
        <li data-target="#carousel-frontpage" data-slide-to="3"></li>
      </ol>


    </div>
</section>    <!-- end slider -->

<section id="call_to_action"> <!-- call to action -->
<div class="container">
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="thumbnail">
          <img src="<?php echo get_template_directory_uri(); ?>/img/produtos-limpeza.jpg" alt="..." class="img-responsive pull-left" width="200px" >
          <div class="caption">
            <h3>Produtos para limpeza de Anilox</h3>
            <p>Desenvolvidos nos Estados Unidos sem solventes a base de petróleo, para limpeza profunda das células do cilindro Anilox. Produtos biodegradáveis.</p>
            <p class="pull-right"><a href="#" class="btn btn-theme" role="button">Conheça a linha completa</a></p>
          </div>
        </div>

    </div>
  </div>
  <h2 class="text-center">
  		Oferecemos soluções que <span class="vermelho">agregam valor</span> e <span class="vermelho">melhoram</span> o ambiente de trabalho.
  </h2>
  <p class="text-center">Reduzindo desperdícios, aumentando a vida útil e incrementando a produtividade.</p>
</div>
</section> <!-- end call to action -->

<section id="parallax"> <!-- parallax -->

<div id="parallax1" class="parallax text-light text-center marginbot50" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row appear">
          <div class="col-sm-3 col-md-3 col-lg-3">
              <div class="box">
                <div class="aligncenter">
                <a href="lavadora-de-cliche-acquasolve.php">
                  <div class="icon"> <i class="fa fa-clock-o fa-5x"></i> </div>
                  <h3>Aumentam a vida útil</h3>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3">
              <div class="box">
                <div class="aligncenter">
                <a href="laminas-swed-cut-doctor-blades.php">
                  <div class="icon"> <i class="fa fa-signal fa-5x"></i> </div>
                  <h3>Incrementam a produtividade</h3>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3">
              <div class="box">
                <div class="aligncenter">
                <a href="produtos-limpeza-anilox.php">
                  <div class="icon"> <i class="fa fa-lightbulb-o fa-5x"></i> </div>
                  <h3>Inovação e exclusividade</h3>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3">
              <div class="box">
                <div class="aligncenter">
                <a href="lavadora-de-anilox-ecoclean.php">
                  <div class="icon"> <i class="fa fa-star-o fa-5x"></i> </div>
                  <h3>Melhor ambiente de trabalho</h3>
                  </a>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
</section> <!-- end parallax -->

<?php get_footer(); ?>