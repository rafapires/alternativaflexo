<?php
include("orcamento.php");
$title = 'Lâminas Doctor Blades - Swed-Cut | Alternativa Flexo - Soluções para sistemas Flexográficos';
include("_head.php"); ?>
<style>
th {
    text-align: center;
}
</style>
<body>
<div id="wrapper">
<?php include("_header.php"); ?>
<!-- end header -->
<section id="inner-headline">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <ul class="breadcrumb">
          <li><a href="index.php"><i class="fa fa-home"></i></a></li>
          <li><a href="produtos.php">Produtos</a></li>
          <li class="active">SWED/CUT®</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section id="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
      <article>
        <div class="post-image">
          <div class="post-heading">
            <h3>SWED/CUT® Premium Doctor Blades</h3>
          </div>
          <img src="img/produtos/doctor-blade1.jpg" alt="SWED/CUT® Premium DoctorBlades" class="img-responsive" /> </div>
        <div class="col-md-8">
          <p><strong>SWED/CUT® Premium DoctorBlades</strong> é uma linha de lâminas de alta performance para flexografia e rotogravura, desenvolvida e manufaturada pela empresa SWEDEV AB, com sede em Munkfors na Suécia.</p>
          <p>Com mais de 20 anos de experiência, a SWED/CUT tem conquistado milhares de clientes, tornando-se "a marca preferencial" de impressores e convertedores em todo o mundo.</p>
          <p>O aço Sueco vem evoluindo há centenas de anos e hoje é reconhecido mundialmente pela sua mais alta qualidade e confiabilidade. Além disso, a Swedev está sempre investindo e desenvolvendo sua própria tecnologia. Isto garante rigidez, linearidade e durabilidade nas lâminas que naturalmente resulta em uniformidade nos resultados impressos, em todas as etapas do trabalho, maximizando a produção.</p>
          <p>Todo o processo de fabricação é rigorosamente controlado pelos certificados de qualidade ISO 9001 e ISO 14001, conferindo ao produto sempre as mesmas características.</p>
          <p>São por estes motivos que a Alternativa Flexo buscou se tornar distribuidor exclusivo da Swedev/ SwedCut no Brasil trazendo o mais alto nível de serviço e competência, sempre oferecendo soluções econômicas de alta qualidade. </p>
          <p>&nbsp;</p>
                    <ul>
                      <li>ENtrE OS MAIORES FABRICANTES DE LAMINAS DOCTOR BLADE PARA IMPRESSÃO</li>
                      <li> AÇO E REBAIXO TOTALMENTE PRODUZIDO NA SUÉCIA</li>
                      <li>DETÉM APROXIMADAMENTE 11% DO MERCADO MUNDIAL PARA ARTES GRÁFICAS</li>
                      <li>REDE DE DIStrIBUIDORES ATENDENDO 80 PAÍSES</li>
                      <li>ISO 9001 E 14001</li>
                    </ul>
          <p>&nbsp;</p>
          <p><img src="img/produtos/download_pdf.png" width="200" height="80" alt="Download ficha técnica"/></p>
        </div>
        <div class="col-md-4">
        <img src="img/produtos/doctor-blad3.jpg" style="max-width:100%" alt="SWED/CUT® Premium DoctorBlades"/><br>
          <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                <thead>
              <tr>
                <th align="center"><strong>Dimensões (mm)</strong></th>
              </tr>
              </thead>
              <tr>
                <td align="center">25 x 0,15</td>
              </tr>
              <tr>
                <td align="center">30 x 0,15</td>
              </tr>
              <tr>
                <td align="center">35 x 0,15</td>
              </tr>
              <tr>
                <td align="center">40 x 0,15</td>
              </tr>
              <tr>
                <td align="center">50 x 0,15</td>
              </tr>
              <tr>
                <td align="center">17 x 0,20</td>
              </tr>
              <tr>
                <td align="center">20 x 0,20</td>
              </tr>
              <tr>
                <td align="center">30 x 0,20</td>
              </tr>
              <tr>
                <td align="center">20 x 0,15</td>
              </tr>
              <tr>
                <td align="center">25 x 0,20</td>
              </tr>
              <tr>
                <td align="center">35 x 0,20</td>
              </tr>
              <tr>
                <td align="center">40 x 0,20</td>
              </tr>
              <tr>
                <td align="center">35 x 0,25</td>
              </tr>
              <tr>
                <td align="center">20 x 0,30</td>
              </tr>
           </table> 
           </div>         
          <br><img src="img/produtos/doctor-blade4.jpg" style="max-width:100%" alt="SWED/CUT® Premium DoctorBlades"/>
          <br><img src="img/produtos/doctor-blade5.jpg" style="max-width:100%" alt="SWED/CUT® Premium DoctorBlades"/>
        </div>
        <div class="row">
          <div class="col-md-12"> <img src="img/produtos/doctor-blade2.png" style="max-width:100%" alt="SWED/CUT® Premium DoctorBlades"/> </div>
          <div class="col-md-6">  </div>
          <div class="col-md-6">  </div>
          <div class="col-md-6">  </div>
        </div>
      </article>
      <div class="comment-area">
        <h4>Solicite agora um orçamento</h4>
        <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="Produto" value="SWED/CUT® Premium Doctor Blades">
            <div class="form-group">
              <input type="text" name="Nome" class="form-control" id="name" placeholder="* Seu nome">
            </div>
            <div class="form-group">
              <input type="email" name="Email" class="form-control" id="email" placeholder="* Seu e-mail">
            </div>
            <div class="form-group">
              <textarea name="Mensagem" class="form-control" rows="8" placeholder="* Sua necessidade"></textarea>
            </div>
            <button type="submit" class="btn btn-theme btn-md">Enviar</button>
          </form>
      </div>
      <div class="clear"></div>
    </div>
    <div class="col-lg-4">
      <aside class="right-sidebar">
        <div class="widget">
          <h5 class="widgetheading">Nossos Produtos</h5>
          <?php include("_produtos.php"); ?>
        </div>
      </aside>
    </div>
  </div>
  </div>
</section>
<?php include("_footer.php"); ?>
