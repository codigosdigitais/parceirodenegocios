        <?php 
		//echo "<pre>";
		//print_r($results);
		//echo "</pre>";
		//abre o controller o model e o view eu abri
		
		foreach ($results as $r) {
			if(isset($r->status->status)) $status = $r->status->status; else $status="OFF-LINE";
			
			if(!empty($status) and $r->data==date("d/m/Y") and $status == "ONLINE" or $status == "AUSENTE" )
			{
				if($status=="ONLINE"){
					$cor = "#FFCC00"; 
				} else { 
					$cor = "#44B03D";
				}
				//$status = $r->status->status;
				$data = date("d/m/Y H:i", strtotime($r->status->data));
				
				
			} 
				else
			{ 
				$cor = "";
				//$status = "OFF-LINE"; // no model, eu coloquei pra vir somente a data sem a hora... 
				
				$data = "<span style='color:red'  >".( (isset($r->status->data)) ? date("d/m/Y H:i", strtotime($r->status->data)) : "Sem Registro" )."</span>";
			}
			if(strtoupper($status)=="ONLINE") $class_online = "class='div_online'"; else $class_online = "";
            echo "<tr>";
            echo '<td>'.$r->nome.'</td>';
            echo '<td>('.$r->responsaveltelefoneddd.') '.$r->responsaveltelefone.' | '.$r->responsavelcelular.' </td>';
            echo '<td>'.$data.'</td>';
			echo "<td style='text-transform: uppercase' bgcolor='".$cor."' ".$class_online."><center>".$status."</center></td>";
			echo '<td>'.$r->imei_usuario.'</td>';
			echo '<td>'.$r->total_aberto.'</td>';
			echo '<td>'.$r->total_concluido.'</td>';
			echo '<td>'.$r->total_cancelado.'</td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
