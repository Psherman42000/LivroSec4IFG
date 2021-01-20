<?php include("cabecalho.php");
include("conecta.php");
?>
	<main class=" blocoCentral">
	
			<table class="table table-striped table-bordered "> 
				<?php $tag = listaTag($conexao);
				if($tag!=""){?>
				
				<tr>
					<td><?= $tag['tag']?></td>
					<td><?= $tag['dataHora']?></td>
					<td><a class="btn btn-info" href="produtoalteraformulario.php?tag=<?=$tag['tag']?>">Alugar</a>
					<td><a class="btn btn-primary" href="produtoalteraformulario.php?tag=<?=$tag['tag']?>">Cadastrar</a>
					<td><a class="btn btn-danger" href="removeLivro.php?tag=<?=$tag['tag']?>">Remover</a>
				</tr>
			</table>
				<?php } ?>
			<form action="solicita.php">
				<input class="textoPreto transicao btn btn-info" type="submit" value="SOLICITAR LEITURA DE TAG"><br>
			</form>
		
	</main>
	
	<footer>
		
	</footer>
	
<?php include("rodape.php");?>