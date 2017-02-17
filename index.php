<?php
$title = 'Alternativa Flexo - Soluções para sistemas Flexográficos';
include("_head.php"); ?>
<style>
.h2light {
	font-weight:400;
}

#parallax1 .icon, #parallax1 h3 {
	color:#fff;	
}
body {
	background-color: #fcfcfc;
}
.home {
	text-decoration:underline;
	font-weight:bold!important;
}
@media (max-width: 480px) {
  .btn-theme {
	  font-size: 14px;	
  }
}
</style>
<body>
<div id="wrapper"> 
  <?php include("_header.php"); ?>
  <section id="featured" class="bg"> 
  <?php include("_slider.php"); ?>
  </section>

  <section class="callaction">
    <div class="container">
      <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-2">
        <img src="img/produtos-limpeza.jpg" alt="Produtos para  limpeza de Anilox" style="max-width:100%;"/>
        </div>
        <div class="col-lg-4">
          <div class="cta-text">
            <h2><span>Produtos para  limpeza de Anilox</span></h2>
            <p>Desenvolvidos nos Estados Unidos sem solventes a base de petróleo, para limpeza profunda das células do cilindro Anilox. Produtos biodegradáveis.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="cta-btn"> <a href="produtos-limpeza-anilox.php" class="btn btn-theme btn-lg">Conheça nossa linha completa. <i class="fa fa-angle-right"></i></a> </div>
        </div>
        <div class="col-lg-1">
        </div>
      </div>
    </div>
  </section>
  <section id="content">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center cta-text2">
            <h2>Oferecemos soluções que <span>agregam valor</span> e <span>melhoram</span> o ambiente de trabalho.</h2>
            <p>Reduzindo desperdícios, aumentando a vida útil e incrementando a produtividade.</p>
          </div>
        </div>
      </div>
    </div>
    
        <!-- divider -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="solidline"> </div>
        </div>
      </div>
    </div>
    <!-- end divider --> 
    
    <!-- parallax  -->
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
    
    <!-- clients -->
    <div class="container">
    <div class="text-center">
                <h2>Parcerias</h2>
            </div>
      <div class="row">
        <div class="col-xs-6 col-md-2 aligncenter client"> <a href="http://www.agigraphics.it/it/" target="_blank" title="AGI Graphics"><img alt="AGI Graphics" src="img/clients/logo1.png" class="img-responsive" /></a> </div>
        <div class="col-xs-6 col-md-2 aligncenter client"> <a href="http://swedev.se/" target="_blank" title="Swedev"><img alt="Swedev" src="img/clients/logo2.png" class="img-responsive" /></a> </div>
        <div class="col-xs-6 col-md-2 aligncenter client"> <a href="http://www.flintgrp.com/" target="_blank" title="Flint Group"><img alt="Flint Group" src="img/clients/logo3.png" class="img-responsive" /></a> </div>
        <div class="col-xs-6 col-md-2 aligncenter client"> <a href="http://www.leadlasers.com/" target="_blank" title="Lead Laser"><img alt="Lead Laser" src="img/clients/logo4.png" class="img-responsive" /></a> </div>
        <div class="col-xs-6 col-md-2 aligncenter client"> <a href="http://www.keencut.com/" target="_blank" title="Keen Cut - Cutting Machines"><img alt="Keen Cut - Cutting Machines" src="img/clients/logo5.png" class="img-responsive" /></a> </div>
        <div class="col-xs-6 col-md-2 aligncenter client"> <a href="http://www.pcicoatings.com/" target="_blank" title="PCI - Precision Coatings, Inc"><img alt="PCI - Precision Coatings, Inc" src="img/clients/logo6.png" class="img-responsive" /></a> </div>
      </div>
    </div>
  </section>
<?php include("_footer.php"); ?>