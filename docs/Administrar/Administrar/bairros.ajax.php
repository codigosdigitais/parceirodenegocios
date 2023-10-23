<meta http-equiv="content-type" content="text/html;charset=utf-8" />
 <?php 
	header('Content-Type: text/html; charset=utf-8');
//	mysql_connect("localhost", "root", "");
//	mysql_select_db("sistema2");

// 	mysql_connect("mysql02.andyfriends.hospedagemdesites.ws", "andyfriends", "billiemysqlA1");
// 	mysql_select_db("andyfriends");

	$conexao = mysqli_connect("localhost", "parceiro_site1", "p4Rc3Ir055", "parceiro_site");
//	mysqli_select_db("parceiro2016");


	mysqli_query($conexao, "SET NAMES 'utf8'");
	mysqli_query($conexao, 'SET character_set_connection=utf8');
	mysqli_query($conexao, 'SET character_set_client=utf8');
	mysqli_query($conexao, 'SET character_set_results=utf8');
			 
    $cidade = $_POST['cidade'];
	
    $sql = "SELECT * FROM bairro WHERE idCidade = '$cidade' ORDER BY bairro ASC";
    $qr = mysqli_query($conexao, $sql) or die(mysql_error());

    if(mysqli_num_rows($qr) == 0){
       echo  '<option value="0">'.htmlentities('Não bairros nesta cidade').'</option>';
       
    }else{
       while($ln = mysqli_fetch_assoc($qr)){
		  echo '<option value="'.$ln['idBairro'].'">'.$ln['bairro'].'</option>';
       }
    }

    ?>