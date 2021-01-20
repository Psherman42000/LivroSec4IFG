<?php include("cabecalho.php");
include("conecta.php");

$tag = $_GET['tag'];
if(removeLivro($conexao, $tag)){?>
	<p class="alert alert-success"> Livro removido!</p>
	<?php
}
else{
	$msg=mysqli_error($conexao);?>
	<p class="alert alert-warning">Ocorreu um erro, por favor tente novamente: <?= $msg?></p>
	<?php
}?>
<?php include("rodape.php");?>