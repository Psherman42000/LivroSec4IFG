<?php include("cabecalho.php");
include("conecta.php");
?>
	
	<main>
		<?php
			$tag = $_POST['tag'];
			$titulo = $_POST['titulo'];
			$query = " insert into livro(tag,titulo,alugado) values('{$tag}','{$titulo}','0');";
			$query2 = " DELETE FROM tagsLidas where id>0";
			if(mysqli_query($conexao, $query)&&mysqli_query($conexao, $query2)){
			?>
				<p class="alert alert-success">LIVRO CADASTRADO COM SUCESSO</p>
			<?php
			}
			else{
				$msg=mysqli_error($conexao);
			?>
			<p class="alert alert-warning">Ocorreu um erro, por favor tente novamente<?= $msg?></p>
			<?php
			}
			?>
		
	</main>
	
	<footer>
		
	</footer>
	
<?php include("rodape.php");?>