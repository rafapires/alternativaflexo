<?php 
include("orcamento.php");
$title = 'QSpac Filme adesivo para Laminação | Alternativa Flexo - Soluções para sistemas Flexográficos';
include("_head.php"); ?>
<style>
th {
    text-align: center;
}
table {
	font-size:13px;
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
            <li class="active">QSpac</li>
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
                <h3>Fitas adesivas para Laminação QSpac</h3>
              </div>
              <img src="img/qspac.jpg" alt="Fitas adesivas para Laminação QSpac" class="img-responsive" /> </div>
            <div class="col-md-12">
              <p>O único e primeiro filme adesivo para laminação 100% desenvolvido para impressoras industriais da área gráfica de embalagens, desenvolvida pela QSpac, empresa americana lider mundial no segmento, com produção mensal na casa dos bilhões de metros quadrados mês. Investe em tecnologia própria e exclusiva trasendo benefícios únicos para a indústria de embalagens.</p>
              <ul>
                <li>utilização das impressoras em velocidades maiores e com mais qualidade na laminação</li>
                <li>Diminuição expressiva do ruído de descolamento da fita, melhorando o ambiênte de impressão</li>
                <li>não utiliza solventes em seu adesivo possibilitando o uso em embalagens e rótulos para alimentos, remédios, agrículas e pets.</li>
                <li>Proteção UV que diminui substancialmente desbotamento das cores impressas em embalagens expostas ao ar livre expostas ao sol</li>
                <li>Resistência à humidade permitindo o uso em embalagens de congelados ou expostas em câmaras frias, evitando borrar a tinta dos rótulos e etiquetas</li>
                <li>Menor expessura do mercado ( 0,6 mil / 15 microns )</li>
                <li>Maior flexibilidade evitando rasgos e permitindo melhor dobra e contato em superfícies irregulares.</li>
                <li>Apresentados nos acabamentos fosco e brilhante</li>
              </ul>
              <p>Todos esses benefícios técnicos com maior satisfação de seu cliente que perceberá a olhos nús e pelo tato a melhoria na qualidade do seu produto.</p>
            </div>
          </article>
          <div class="comment-area">
            <h4>Solicite agora um orçamento</h4>
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="Produto" value="QSpac">
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
