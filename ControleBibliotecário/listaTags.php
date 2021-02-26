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
					<?php 
						$livro = buscaLivro($conexao,$tag['tag']);
						if($livro['alugado']=='1'){
					?>
							<td><?= $livro['titulo']?></td>
							<td><a class="btn btn-info" href="devolve.php?tag=<?=$tag['tag']?>">Devolver</a>
							<td><a class="btn btn-danger" href="removeLivro.php?tag=<?=$tag['tag']?>">Remover</a>
					<?php
						}else if($livro['alugado']=='0'){
					?>
							<td><?= $livro['titulo']?></td>
							<td><a class="btn btn-info" href="aluga.php?tag=<?=$tag['tag']?>">Alugar</a>
							<td><a class="btn btn-danger" href="removeLivro.php?tag=<?=$tag['tag']?>">Remover</a>
					<?php
						}else{
					?>
							<td><a class="btn btn-primary" href="formCadastro.php?tag=<?=$tag['tag']?>">Cadastrar</a>
					<?php } ?>
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