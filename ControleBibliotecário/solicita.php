<?php include("cabecalho.php");
include("conecta.php");
?>
	
	<main>
		<?php
			
			$query = " update solicitacao set ler = 1 where id = 1;";
			$query2 = " DELETE FROM tagsLidas where id>0";
			if(mysqli_query($conexao, $query)&&mysqli_query($conexao, $query2)){
			?>
				<p class="alert alert-success msg">Pronto para leitura...<br>Aproxime a TAG do material bibliográfico no leitor...</p>
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