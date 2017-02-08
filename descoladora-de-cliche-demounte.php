<?php
include("orcamento.php");
$title = 'Descoladora de ClichÊs - Demounter | Alternativa Flexo - Soluções para sistemas Flexográficos';
include("_head.php"); ?>
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
          <li class="active">Demounter</li>
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
              <h3>DEMOUNTER - DESCOLADORA DE CLICHÊS</h3>
            </div>
            <img src="img/produtos/demounter1.jpg" alt="" class="img-responsive" /> </div>
          <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                <thead>
              <tr>
                <td colspan="2" align="center" valign="middle"><strong>Especificações Demounter</strong></td>
              </tr>
              </thead>
              <tr>
                <td>Diâmetro Mínimo da Camisa (mm/pol)</td>
                <td>90 / 3</td>
              </tr>
              <tr>
                <td>Diâmetro Máximo da Camisa (mm/pol)</td>
                <td>500 / 19</td>
              </tr>
              <tr>
                <td>Peso máximo da Camisa (kg)</td>
                <td>35</td>
              </tr>
              <tr>
                <td>Tensão (V)</td>
                <td>220V mono</td>
              </tr>
              <tr>
                <td>Dimensões (CxLxA) cm</td>
                <td>203 x 76,5 x 114</td>
              </tr>
              <tr>
                <td>Peso (kg)</td>
                <td>160</td>
              </tr>
            </table>
           </div>
            <p>&nbsp;</p>
            <p>Sistema automático para descolagem de clichês</p>
            <ul>
              <li>Dispositivo com tração elétrica para uma ágil retirada do clichê.</li>
              <li>Velocidade e ângulo constante para evitar danos</li>
              <li>Estrutura em aço</li>
              <li>Suporte da Camisa com altura ajustável</li>
              <li>Aceita vários tamanhos de camisas com diâmetro de 90 a 500mm</li>
              <li>Maior segurança e economia de tempo para o operador </li>
            </ul>
          </div>
          <div class="row">
            <div class="col-md-4"> <img src="img/produtos/demounter2.jpg" style="max-width:100%" alt="Descoladora de ClichÊs - Demounter"/>
            </div>
            <div class="col-md-4"> <img src="img/produtos/demounter3.jpg" style="max-width:100%" alt="Descoladora de ClichÊs - Demounter"/> </div>
            <div class="col-md-4"> <img src="img/produtos/demounter4.jpg" style="max-width:100%" alt="Descoladora de ClichÊs - Demounter"/> </div>
          </div>
        </article>
        <div class="comment-area">          
          <h4>Solicite agora um orçamento</h4>
          <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <input type="hidden" name="Produto" value="Descoladora de Clichê Demounte">
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
