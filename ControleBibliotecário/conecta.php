<?php $conexao = mysqli_connect('bmawg2lmbs58mxjxnxgd-mysql.services.clever-cloud.com','ui8uwuxvmzk1vdfa','TX5MB6aD4zGy2hldfaAd','bmawg2lmbs58mxjxnxgd');?>

<?php 
function listaTag($conex){
	$query = "select * from tagsLidas;";
    $resultado = mysqli_query($conex, $query);
    return mysqli_fetch_assoc($resultado);
}

function removeLivro($conex, $tag) {
	$query = "delete from livro where tag = '{$tag}'";
	$query2 = " DELETE FROM tagsLidas where id>0";
	mysqli_query($conex, $query2);
	return mysqli_query($conex, $query);
}
	
function buscaLivro($conex, $tag) {
    $query = "select * from livro where tag = '{$tag}'";
    $resultado = mysqli_query($conex, $query);
    return mysqli_fetch_assoc($resultado);
}

?>