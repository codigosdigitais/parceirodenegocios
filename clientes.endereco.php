 <?php 
	@header('Content-Type: text/html; charset=utf-8');
//	mysql_connect("localhost", "pixxdigi_administrador", "]X!^om5m+WW^");
//	mysql_select_db("pixxdigi_entrega");

// 	mysql_connect("mysql02.andyfriends.hospedagemdesites.ws", "andyfriends", "billiemysqlA1");
// 	mysql_select_db("andyfriends");

	mysql_connect("localhost", "root", "");
	mysql_select_db("sistema2");

	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
			 
    $idCliente = $_GET['id'];
	
	$sql = mysql_query("SELECT * FROM cliente WHERE idCliente = '".$idCliente."'");
	$row = mysql_fetch_array($sql);	
	
    ?>


{"endereco":"<? echo $row['endereco']; ?>","bairro":"<? echo $row['endereco_bairro']; ?>","cidade":"<? echo $row['endereco_cidade']; ?>","estado":<? echo $row['endereco_estado']; ?>,"cep":null,"numero":"<? echo $row['endereco_numero']; ?>","capital":true}