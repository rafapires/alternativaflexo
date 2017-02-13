<?php
include("orcamento.php");
$title = 'Produtos para limpeza de Anilox | Alternativa Flexo - Soluções para sistemas Flexográficos';
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
            <li class="active">Limpeza de Anilox</li>
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
                <h3>Liquido Desincrustante para limpeza de Anilox</h3>
              </div>
            </div>
            <div class="col-md-8">
              <div class="col-md-12 post-image"> <img src="img/produtos/limpeza-anilox1.jpg" alt="APS UL-300 Pro - Liquido Desincrustante para limpeza de Anilox" class="img-responsive" /> </div>
              <p>O APS UL-300 Pro é  produto de limpeza ultra concentrado de ultima geração. Sua  eficácia é devido a conter diversos tenso-ativos e agentes  molhantes. </p>
              <p>A sua ação vai  liquefazer as partículas de tinta polimerizadas e permitir sua volta  para uma fase líquida.</p>
              <p>Para resumir, o APS  UL300 Pro transforma as tintas em fase sólida para uma fase líquida,  resultando em uma maneira fácil de limpar os cilindros Anilox.</p>
              <p><BR>
              </p>
              <ul>
                <li>Fácil aplicação e  limpeza. </li>
                <li> Uso diário com Baixo  Consumo por Anilox.</li>
                <li> Rápido e poderoso,  retornando a tinta ao estado líquido em aprox. 5 minutos.</li>
                <li> Não perigoso ao  Usuário e ao Meio Ambiente.</li>
                <li> PH Neutro - Não  agride Alumínio</li>
              </ul>
              <p><BR>
              </p>
              <p><strong>Para todos os tipos  de Tintas e Vernizes</strong></p>
              <p><BR>
              </p>
              <p><strong>Produzido por:</strong> Access  Printing Solution -<a href="http://www.accessprintingsolution.com"> www.accessprintingsolution.com</a> – Feito na  France</p>
            </div>
            <div class="col-md-4"> <img src="img/produtos/limpeza-anilox3.jpg" style="max-width:100%"alt=""/> </div>
            <div class="row">
              <div class="col-md-12>"> </div>
            </div>
          </article>
          <article>
            <div class="post-image">
              <div class="post-heading">
                <h3>Gel Desincrustante para Limpeza de Anilox</h3>
              </div>
              <img src="img/produtos/limpeza-anilox2.jpg" class="img-responsive" alt="Gel Desincrustante para Limpeza de Anilox - APS C-GEL PRO"/>
            </div>
            <div class="col-md-8">
              <p>A APS C-GEL PRO é um  produto de limpeza muito rápido e eficaz para remover tintas secas  (Solvente, água e tintas à base de UV), vernizes e revestimentos  nos cilindros  Anilox de cerâmica. Uma garrafa de 0.5L / 1 kg será  capaz de limpar entre 5 e 7 m² de superfície. </p>
              <p>Maneira do uso: Aplique  uma camada fina da APS C-GEL PRO com uma luva no rolo e deixe agir  entre 15 minutos a 1 hora, dependendo do nível de entupimento.</p>
              <p>Lavar muito bem o rolo  com um tecido molhado até não permanecer mais do produto no rolo.  Para ajudar a remover a tinta dissolvida dentro das células do rolo  Anilox use uma escova de aço inoxidável com base de PVC.</p>
              <ul>
                <li> Rápido e poderoso!</li>
                <li> Eficiente em todos os  tipos de tintas, vernizes e revestimentos!                </li>
                <li><strong> Restaura o volume  das células como novo!</strong></li>
              </ul>
              <p><BR>
              </p>
              <p>Produzido por: Access  Printing Solution - www.accessprintingsolution.com – Feito na  France</p>
            </div>
            <div class="col-md-4">
              <img src="img/produtos/limpeza-anilox4.jpg" alt="Gel Desincrustante para Limpeza de Anilox" class="img-responsive"  />
              </div>
          </article>
          <div class="comment-area">
            <h4>Solicite agora um orçamento</h4>
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="Produto" value="Produtos para limpesa de Anilox">
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
