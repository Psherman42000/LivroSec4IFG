<?php include("cabecalho.php");
include("conecta.php");
?>
	
	<main>
		<?php
			$tag = $_GET['tag'];
			$query = " update livro set alugado = 1 where tag = '{$tag}';";
			$query2 = " DELETE FROM tagsLidas where id>0";
			if(mysqli_query($conexao, $query)&&mysqli_query($conexao, $query2)){
			?>
				<p class="alert alert-success msg">ALUGUEL RELIZADO.</p>
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
	
<?php include("rodape.php");?>