<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
 <meta charset="<?php bloginfo( ´charset´ ); ?> ">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
 <!--[if lt IE 9]>
 <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
 <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 <![endif]-->
 <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >

<!-- start header -->
  <header>
    <!-- start toparea -->
    <div class="top">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <ul class="topleft-info">
              <li><i class="fa fa-phone"></i> (19) 3371.4772</li>
              <li><i class="fa fa-envelope"></i> contato@alternativaflexo.com.br</li>
            </ul>
          </div>
          <div class="col-sm-6 col-xs-8">
            <div class="social">
              <ul class="social-network">
              <li><a href="https://www.facebook.com/people/Alternativa-Flexo/100008224661323" data-placement="top" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
              <li><a href="https://www.linkedin.com/company/alternativaflexo?trk=prof-following-company-logo" data-placement="top" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
              <li><a href="https://plus.google.com/110351477583346034503" data-placement="top" title="Google plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
              <li><a href="http://200.207.142.156:9090/" target="_blank" data-placement="top" title="Área do cliente"><i class="fa fa-user"></i> Área do cliente</a></li>              
            </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
	<!-- end toparea -->

	<!-- start topmenu -->
    <div class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php bloginfo('url')?>"><img src="<?php echo get_template_directory_uri(); ?>/img/logo_alternativa_flexo.png" alt="" width="131" height="100" /></a>
        </div>
        <div class="navbar-collapse collapse ">
          <?php
          wp_nav_menu(
            array (
              'menu' => 'top_menu',
              'depth' => 2,
              'container' => false,
              'menu_class' => 'nav navbar-nav')
          );
          ?>

        </div>
      </div>
    </div>
    <!-- end topmenu -->

  </header>
  <!-- end header -->