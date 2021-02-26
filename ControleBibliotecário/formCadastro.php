<?php include("cabecalho.php");
include("conecta.php");
?>
	<main>
		<?php
		$tag = $_GET['tag'];
		?>
		<form class="blocoCentral" action="addLivro.php" method="post">
		Tag:
			<input type="text" class="textoPreto" name="tag" value="<?=$tag?>"><br><br><br>
		Titulo:
			<input type="text" class="textoPreto" name="titulo"><br><br><br>
			<input class="textoPreto btn btn-info" type="submit" value="CADASTRAR NOVO LIVRO"><br>
		</form>
		
	</main>
	
	<footer>
		
	</footer>
	
<?php include("rodape.php");?>

<!-- INSERT into tagsLidas(tag,dataHora) values('00008','12-12-2020 08:00:00'); -->