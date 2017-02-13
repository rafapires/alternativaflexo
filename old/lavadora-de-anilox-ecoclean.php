<?php
include("orcamento.php");
$title = 'Lavadora de ANilox - Ecoclean | Alternativa Flexo - Soluções para sistemas Flexográficos';
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
            <li class="active">Ecoclean</li>
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
                <h3>LAVADORA DE ANILOX <img src="img/produtos/logo_ecoclean.jpg" width="185" height="44" alt="Ecoclean - LAVADORA DE ANILOX"/></h3>
              </div>
              <img src="img/produtos/ecoclean1.jpg" alt="Ecoclean - LAVADORA DE ANILOX" class="img-responsive" />
            </div>
            <div class="col-md-6">
            <p> As máquinas <strong><em>ECOCLEAN</em></strong>, 
            100% nacional, desenvolvidas pela Flexocom, e fabricadas nossa equipe, são maquinas automáticas para a lavagem de anilox e cilindros ou camisas em geral, incluindo cilindros rotográficos e de aplicação de adesivos utilizando desengraxante a base de água e matérias primas renováveis.</p>
            <p><strong>Características:</strong> </p>
            <ul>
              <li>Baixo custo de limpeza por unidade</li>
              <li>Baixo consumo de energia</li>
              <li>Processo de limpeza não gera resíduo</li>
              <li>Reaproveitamento do produto de limpeza</li>
              <li>Produto 100% ecológico</li>
              <li>Maquina Construída em Aço Inox</li>
              <li>Baixíssimo custo de manutenção</li>
              <li>4 programas de tipos de limpeza</li>
              <li>Ajustável para diversos tamanhos de cilindros e camisas. </li>
            </ul>
            </div>
            <div class="col-md-6">
            <img src="img/produtos/ecoclean3.jpg" alt="" style="max-width:100%"/>
            </div>
            <div class="row">
            <div class="col-md-8">
            <p><strong>Vantagens que a limpeza diária dos anilox possibilita: </strong></p>
            <ul>
              <li>Set-ups mais rápidos</li>
              <li>Redução de custo no processo, especialmente no consumo de tinta.</li>
              <li>Aumento na vida útil dos cilindros e camisas. </li>
            </ul>
            </div>
            <div class="col-md-4">
            <img src="img/produtos/ecoclean2.jpg" style="max-width:100%" alt="Ecoclean - LAVADORA DE ANILOX"/>
            </div>
            </div>
          </article>
          <div class="comment-area">
            <h4>Solicite agora um orçamento</h4>
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="Produto" value="ECOCLEAN">
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