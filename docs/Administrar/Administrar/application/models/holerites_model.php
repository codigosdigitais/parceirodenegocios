<?php

class holerites_model extends CI_Model
{

    # Estrutura Base
    public function __construct()
    {
        parent::__construct();
    }

    public function getModulosCategoria()
    {
        $sql = "SELECT * FROM modulos WHERE idModuloBase = '0' ORDER BY modulo ASC";
        $consulta = $this->db->query($sql)->result();

        foreach ($consulta as &$valor) {
            $sql_model = "SELECT * FROM modulos WHERE idModuloBase = '{$valor->idModulo}' ORDER BY modulo ASC";
            $valor->subModulo = $this->db->query($sql_model)->result();
        }

        return $consulta;
    }

    public function getBase($tabela, $cod, $order)
    {
        $this->db->order_by($cod, $order);
        return $this->db->get($tabela)->result();
    }
    # Fim Estrutura Base

    # Trabalhando Periodo
    public function periodo($periodo = null, $idFuncionario = null, $dataInicial=null, $dataFinal=null)
    {
        if (!empty($periodo)) {
            $periodo = $periodo;
        } else {
            $periodo = date("m") - 1;
        }

        $ano_atual = date("Y");
        $ano_anterior = date("Y") - 1;

        if ($periodo == 13 or $periodo==null) {
            $data_inicial = $dataInicial;
            $data_final = $dataFinal;
            $ano_atual = date("Y");
        }

        switch ($periodo) {

            case 0:
                $data_inicial = "{$ano_anterior}-11-21";
                $data_final = "{$ano_anterior}-12-20";
                $referencia = "Dezembro";
                break;

            case 1:
                $data_inicial = "{$ano_anterior}-12-21";
                $data_final = "{$ano_atual}-01-20";
                $referencia = "Janeiro";
                break;

            case 2:
                $data_inicial = "{$ano_atual}-01-21";
                $data_final = "{$ano_atual}-02-20";
                $referencia = "Fevereiro";
                break;

            case 3:
                $data_inicial = "{$ano_atual}-02-21";
                $data_final = "{$ano_atual}-03-20";
                $referencia = "Março";
                break;

            case 4:
                $data_inicial = "{$ano_atual}-03-21";
                $data_final = "{$ano_atual}-04-20";
                $referencia = "Abril";
                break;

            case 5:
                $data_inicial = "{$ano_atual}-04-21";
                $data_final = "{$ano_atual}-05-20";
                $referencia = "Maio";
                break;

            case 6:
                $data_inicial = "{$ano_atual}-05-21";
                $data_final = "{$ano_atual}-06-20";
                $referencia = "Junho";
                break;

            case 7:
                $data_inicial = "{$ano_atual}-06-21";
                $data_final = "{$ano_atual}-07-20";
                $referencia = "Julho";
                break;

            case 8:
                $data_inicial = "{$ano_atual}-07-21";
                $data_final = "{$ano_atual}-08-20";
                $referencia = "Agosto";
                break;

            case 9:
                $data_inicial = "{$ano_atual}-08-21";
                $data_final = "{$ano_atual}-09-20";
                $referencia = "Setembro";
                break;

            case 10:
                $data_inicial = "{$ano_atual}-09-21";
                $data_final = "{$ano_atual}-10-20";
                $referencia = "Outubro";
                break;

            case 11:
                $data_inicial = "{$ano_atual}-10-21";
                $data_final = "{$ano_atual}-11-20";
                $referencia = "Novembro";
                break;

            case 12:
                $data_inicial = "{$ano_atual}-11-21";
                $data_final = "{$ano_atual}-12-20";
                $referencia = "Dezembro";
                break;

            case 13:
                $data_inicial = $dataInicial;
                $data_final = $dataFinal;
                $referencia = "PERS.";
                break;
        }


        $data['data_inicial'] = $data_inicial;
        $data['data_final'] = $data_final;
        $data['referencia'] = $referencia;
        $data['ano'] = $ano_atual;
        $data['idFuncionario'] = $idFuncionario;

        return $data;
    }
    # Fim Periodo

    # Listagem de Holerites
    /*
    @ neste caso não iremos usar a $ciclo, pois iremos listar
    @ de forma diferente e básica
    */
    public function listaHolerite($ciclo, $metodo)
    {
        $funcionarios = $this->db
                                ->select('
											c1.nome,
											c1.idFuncionario,
											c1.situacao,
											c2.funcao,
											c3.parametro as funcao_nome,
											c4.bancoagencia,
											c4.bancoconta,
											c4.bancooperacao,
											(SELECT parametro FROM parametro WHERE idParametro=c4.bancobanco) as bancobanco
								')
                                ->join('funcionario_dadosregistro as c2', 'c2.idFuncionario=c1.idFuncionario')
                                ->join('parametro as c3', 'c3.idParametro=c2.funcao')
                                ->join('funcionario_remuneracao as c4', 'c4.idFuncionario=c1.idFuncionario')
                                ->where('c1.situacao', 1)
                                ->order_by('c1.situacao', 'DESC')
                                ->order_by('c1.nome', 'ASC')
                                ->group_by('c1.idFuncionario')
                                ->get('funcionario as c1')
                                ->result();

        foreach ($funcionarios as &$salario_liquido) {
            $salario_liquido->salario = $this->db
                                                    ->where('ciclo_1', $ciclo[0])
                                                    ->where('idFuncionario', $salario_liquido->idFuncionario)
                                                    ->get('folhapagamento_holerite')
                                                    ->row();
        }


        return $funcionarios;
    }


    # Buscando dados para inicio da estruturade Holerites
    public function getDados($idFuncionario, $ciclo=null, $datas_ciclo_selecionado=null)
    {
        //print_r($ciclo);


        if (is_array($datas_ciclo_selecionado) && !empty($datas_ciclo_selecionado)) {
            $data_inicial = $datas_ciclo_selecionado[0];
            $data_final = $datas_ciclo_selecionado[1];
        } else {
            $data_inicial = $ciclo[0];
            $data_final = $ciclo[1];
        }
     

        # resultados
        $consulta = array();

        # Funcionário
        # Revisado (11/10/2021)
        $consulta['dados_funcionario'] 	= $this->db
                                                ->where('idFuncionario', $idFuncionario)
                                                ->get('v_holerite_funcionario')->row();

        # Provento
        # Revisado (11/10/2021)
        $consulta['provento'] 			= $this->db
                                                ->where("data BETWEEN '$data_inicial' AND '$data_final'")
                                                ->where('idFuncionario', $idFuncionario)
                                                ->get('v_holerite_provento')->result();

        # Periculosidade
        # Revisado (11/10/2021)
        $consulta['periculosidade'] 	= $this->db
                                                ->where('idFuncionario', $idFuncionario)
                                                ->get('v_holerite_valor_fixo')
                                                ->row('valor_periculosidade');

        # Insalubridade
        # Revisado (11/10/2021)
        $consulta['insalubridade'] 		= $this->db
                                                ->where('idFuncionario', $idFuncionario)
                                                ->get('v_holerite_valor_fixo')
                                                ->row('valor_insalubridade');

        # Desconto
        # Revisado (11/10/2021)
        $consulta['desconto'] 			= $this->db
                                                ->where("data BETWEEN '$data_inicial' AND '$data_final'")
                                                ->where('idFuncionario', $idFuncionario)
                                                ->get('desconto')->result();

        # Folha Provento
        # Revisado (11/10/2021)
        $consulta['folha_provento'] 	= $this->db
                                                ->where('idParametro', $consulta['dados_funcionario']->idFuncao)
                                                ->where('idCedente', $consulta['dados_funcionario']->idCedente)
                                                ->where('tipo !=', 203) // Adicional de Periculosidade
                                                ->get('v_holerite_provento_folha')
                                                ->result();

    
        # Folha Desconto
        # Revisado (11/10/2021)
        $consulta['folha_desconto'] 	= $this->db
                                                ->select('sum(c1.valor) valor_total, c2.parametro as nome_parametro, c2.codigoeSocial')
                                                ->join('parametro AS c2', 'c2.idParametro=c1.tipo')
                                                ->where("c1.data BETWEEN '$data_inicial' AND '$data_final'")
                                                ->where('c1.idFuncionario', $idFuncionario)
                                                ->group_by('c2.parametro')
                                                ->get('desconto AS c1')
                                                ->result();

        # Folha FGTS
        # Verificar ao certo como funciona
        $consulta['folha_base_fgts'] 	= $this->db
                                                ->where('idParametro', $consulta['dados_funcionario']->idFuncao)
                                                ->where('idCedente', $consulta['dados_funcionario']->idCedente)
                                                ->get('v_holerite_inss_folha')
                                                ->result();

        # Falta
        # Revisado (11/10/2021)
        $consulta['falta'] 				= $this->db
                                                ->where("data_solicitado BETWEEN '$data_inicial' AND '$data_final'")
                                                ->where('idFuncionario', $idFuncionario)
                                                ->get('v_holerite_falta')->result();

        $totalFaltas = 0;
        foreach ($consulta['falta'] as $falta) {
            $totalFaltas += $this->getValorFaltasAtrasos(
                $falta->idTipo,
                $consulta['dados_funcionario']->idFuncao,
                $consulta['dados_funcionario']->idCedente,
                $consulta['dados_funcionario']->idFuncionario,
                12,
                $falta->hora_inicio,
                $falta->hora_final,
                $consulta['dados_funcionario']->salario,
                $consulta['periculosidade'],
                $consulta['insalubridade']
            );
        }
        unset($consulta['falta']);
        $consulta['falta_total_valor'] = $totalFaltas;

        # Atraso
        # Revisado (11/10/2021)
        $consulta['atraso'] 			= $this->db
                                                ->where("data_solicitado BETWEEN '$data_inicial' AND '$data_final'")
                                                ->where('idFuncionario', $idFuncionario)
                                                ->get('v_holerite_atraso')->result();



        $totalAtrasos = 0;
        foreach ($consulta['atraso'] as $atraso) {
            $totalAtrasos += $this->getValorFaltasAtrasos(
                $atraso->idTipo,
                $consulta['dados_funcionario']->idFuncao,
                $consulta['dados_funcionario']->idCedente,
                $consulta['dados_funcionario']->idFuncionario,
                12,
                $atraso->hora_inicio,
                $atraso->hora_final,
                $consulta['dados_funcionario']->salario,
                $consulta['periculosidade'],
                $consulta['insalubridade']
            );
        }
        unset($consulta['atraso']);
        $consulta['atraso_total_valor'] = $totalAtrasos;
                                                
        # Faixa de INSS
        # Revisado (11/10/2021)
        $consulta['inss'] 				= $this->db
                                                ->where("valor_min <= ".$consulta['dados_funcionario']->salario)
                                                ->where("valor_max >= ".$consulta['dados_funcionario']->salario)
                                                ->where("categoria", "inss")
                                                ->where("idFolhaParametro", $consulta['dados_funcionario']->idFolhaParametro)
                                                ->get("folhapagamento_storages")
                                                ->row();

        # Faixa de IRRF
        # Revisado (11/10/2021)
        $consulta['irrf'] 				= $this->db
                                                ->where("valor_min <= ".$consulta['dados_funcionario']->salario)
                                                ->where("valor_max >= ".$consulta['dados_funcionario']->salario)
                                                ->where("categoria", "irr")
                                                ->where("idFolhaParametro", $consulta['dados_funcionario']->idFolhaParametro)
                                                ->get("folhapagamento_storages")
                                                ->row();

        # Crédito Funcionário
        # Revisado (11/10/2021)
        $consulta['credito'] 			= $this->db
                                                ->select("SUM(valor) as valor")
                                                ->where("modulo", "funcionario")
                                                ->where("tipoValor", "C")
                                                ->where("idAdministrativo", $idFuncionario)
                                                ->where("data BETWEEN '$data_inicial' AND '$data_final'")
                                                ->get('adicional')
                                                ->row('valor');

        # Débito Funcionário
        # Revisado (11/10/2021)
        $consulta['debito'] 			= $this->db
                                                ->select("SUM(valor) as valor")
                                                ->where("modulo", "funcionario")
                                                ->where("tipoValor", "D")
                                                ->where("idAdministrativo", $idFuncionario)
                                                ->where("data BETWEEN '$data_inicial' AND '$data_final'")
                                                ->get('adicional')
                                                ->row('valor');

        # Débito Funcionário
        # Revisado (11/10/2021)
        $consulta['emprestimo'] 		= $this->db
                                                ->select('sum(valor_parcelas) as p_total')
                                                ->where('c1.idFuncionario', $idFuncionario)
                                                ->where('situacao', 'aprovado')
                                                ->where('localLancamento', 'interno')
                                                ->where("dataPrimParcela BETWEEN '$data_inicial' AND '$data_final'")
                                                ->get('emprestimos_grava_financiamento as c1')
                                                ->row();

        # Holerite Salvo no Banco (fechado ou não)
        # Revisado (11/10/2021)
        $consulta['holerite_confirmado'] = $this->db
                                                ->where('idFuncionario', $idFuncionario)
                                                ->where('ciclo_1 >=', $data_inicial)
                                                ->where('ciclo_2 <=', $data_final)
                                                ->get('folhapagamento_holerite')
                                                ->num_rows();

        # Enviar ciclo selecionado
        $consulta['ciclo_selecionado'] = array($data_inicial, $data_final);

        # Retorno
        return $consulta;
    }

    public function getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, $p_tipoCD)
    {
        $sql = "SELECT CASE '$p_tipoCD'  
                WHEN 'C' THEN `cargahorariacompleta`
                WHEN 'D' THEN `cargahorariadiaria`
                END
                AS horas
                FROM `funcionario_dadosregistro` 
                WHERE `idFuncionario` = $p_idFuncionario
                AND `empresaregistro` = $p_idCedente";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $consulta->row()->horas;
        }
        return 0;
    }

    public function getIdClienteFreteVigente($p_idCliente)
    {
        $sql = "SELECT idClienteFrete
                FROM cliente_frete
                WHERE idCliente = p_idCliente
                AND vigencia_final is null";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $consulta->row()->idClienteFrete;
        }
        return 0;
    }

    public function getValorAtrazoInjustPericulosidade($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_hrInicio, $p_hrFinal)
    {
        $sql = "SELECT ((a.salario / " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') . ") *
                          ((TIME_TO_SEC(TIMEDIFF('$p_hrFinal', '$p_hrInicio')))/60/60)
                        )
                as p_valor
                    FROM folhapagamento_parametro a 
                    RIGHT JOIN folhapagamento_atrasoinjust b
                        ON (a.idFolhaParametro = b.idFolhaParametro
                        and b.tipo = 203/*periculosidade*/)
                    RIGHT JOIN `funcionario_remuneracao` c
                        ON (c.idFuncionario = $p_idFuncionario
                        AND c.periculosidade = 1)/*periculosidade=SIM*/
                    RIGHT JOIN `folhapagamento_provento` d
                        ON (d.tipo = 203
                        AND a.idFolhaParametro = d.idFolhaParametro)
                    WHERE a.idParametro = $p_idParamFuncaoFunc
                    AND a.idCedente = $p_idCedente";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $consulta->row()->p_valor;
        }
        return 0;
    }

    public function getValorAtrazoInjustProventos($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_referencia, $p_hrInicio, $p_hrFinal)
    {
        $valor = 0;

        $sql = "SELECT SUM(a.valor / " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') . " *
                          ((TIME_TO_SEC(TIMEDIFF('$p_hrFinal', '$p_hrInicio')))/60/60)
                        )
                AS p_valor
                FROM provento a 
                WHERE a.tipo IN (
                    SELECT c.tipo
                    FROM folhapagamento_parametro b
                    LEFT JOIN folhapagamento_atrasoinjust c
                        ON (b.idFolhaParametro = c.idFolhaParametro)
                    WHERE b.idParametro = $p_idParamFuncaoFunc
                    AND b.idCedente = $p_idCedente
                )
                AND a.idFuncionario = $p_idFuncionario
                AND a.referencia = $p_referencia";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            $valor += $consulta->row()->p_valor;
        }
        //valores recorrentes
        $sqlRecorrentes = "SELECT SUM(fpr.valor / " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') . " *
                              ((TIME_TO_SEC(TIMEDIFF('$p_hrFinal', '$p_hrInicio')))/60/60)
                            ) 
                            AS p_valor
                            FROM (`folhapagamento_provento` as fpr)
                              JOIN `folhapagamento_parametro` as fpa ON `fpa`.`idFolhaParametro`=`fpr`.`idFolhaParametro` AND fpa.idCedente = $p_idCedente
                              JOIN `parametro` as p ON `p`.`idParametro`=`fpr`.`tipo`
                            WHERE `fpr`.`tipo` != 203
                                  AND fpr.tipo IN (SELECT c.tipo
                                                   FROM folhapagamento_parametro b
                                                     LEFT JOIN folhapagamento_faltainjust c
                                                       ON (b.idFolhaParametro = c.idFolhaParametro)
                                                   WHERE b.idParametro = $p_idParamFuncaoFunc
                                                         AND b.idCedente = $p_idCedente)
                                  AND `fpa`.`idParametro` =  '$p_idParamFuncaoFunc'";


        $folha_proventos = $this->db->query($sqlRecorrentes);

        $query = $this->db->last_query();
        
        #Código que deu pani
        /*
        if ($folha_proventos->num_rows()) {
            $valor += $folha_proventos->row()->p_valor;
        }*/
        
        # Novo codigo alterado, para conserto.
        if ($folha_proventos !== false && $folha_proventos->num_rows()==true) {
            $valor += $folha_proventos->row()->p_valor;
        } else {
            return false;
        }

        return $valor;
    }

    public function getValorAtrazoInjustSalario($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_hrInicio, $p_hrFinal)
    {
        $sql = "SELECT ((a.salario / " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') . ") *
                          ((TIME_TO_SEC(TIMEDIFF('$p_hrFinal', '$p_hrInicio')))/60/60)
                        )
                AS p_valor
                FROM folhapagamento_parametro a 
                RIGHT JOIN folhapagamento_atrasoinjust b
                    ON (a.idFolhaParametro = b.idFolhaParametro
                    and b.tipo = 186/*salario*/)
                WHERE a.idParametro = $p_idParamFuncaoFunc
                AND a.idCedente = $p_idCedente";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $consulta->row()->p_valor;
        }
        return 0;
    }

    public function getValorAtrazoJustPericulosidade($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_hrInicio, $p_hrFinal)
    {
        $sql = "SELECT ((a.salario / " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') . ") *
                          ((TIME_TO_SEC(TIMEDIFF('$p_hrFinal', '$p_hrInicio')))/60/60)
                        )
                AS p_valor
                FROM folhapagamento_parametro a 
                RIGHT JOIN folhapagamento_atrasojust b
                    ON (a.idFolhaParametro = b.idFolhaParametro
                    and b.tipo = 203/*periculosidade*/)
                RIGHT JOIN `funcionario_remuneracao` c
                    ON (c.idFuncionario = $p_idFuncionario
                    AND c.periculosidade = 1)/*periculosidade=SIM*/
                RIGHT JOIN `folhapagamento_provento` d
                    ON (d.tipo = 203
                    AND a.idFolhaParametro = d.idFolhaParametro)
                WHERE a.idParametro = $p_idParamFuncaoFunc
                AND a.idCedente = $p_idCedente";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $consulta->row()->p_valor;
        }
        return 0;
    }

    public function getValorAtrazoJustProventos($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_referencia, $p_hrInicio, $p_hrFinal)
    {
        $valor = 0;

        $sql = "SELECT SUM(a.valor / " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') . " *
                          ((TIME_TO_SEC(TIMEDIFF('$p_hrFinal', '$p_hrInicio')))/60/60)
                        )
                AS p_valor
                FROM provento a
                WHERE a.tipo IN (
                    SELECT c.tipo
                    FROM folhapagamento_parametro b
                    LEFT JOIN folhapagamento_atrasojust c
                        ON (b.idFolhaParametro = c.idFolhaParametro)
                    WHERE b.idParametro = $p_idParamFuncaoFunc
                    AND b.idCedente = $p_idCedente
                )
                AND a.idFuncionario = $p_idFuncionario
                AND a.referencia = $p_referencia";

        $consulta = $this->db->query($sql);

        $query = $this->db->last_query();

        if ($this->db->affected_rows() > 0) {
            $valor += $consulta->row()->p_valor;
        }
        //valores recorrentes
        $sqlRecorrentes = "SELECT SUM(fpr.valor / " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') . " *
                              ((TIME_TO_SEC(TIMEDIFF('$p_hrFinal', '$p_hrInicio')))/60/60)
                            ) 
                            AS p_valor
                            FROM (`folhapagamento_provento` as fpr)
                              JOIN `folhapagamento_parametro` as fpa ON `fpa`.`idFolhaParametro`=`fpr`.`idFolhaParametro` AND fpa.idCedente = $p_idCedente
                              JOIN `parametro` as p ON `p`.`idParametro`=`fpr`.`tipo`
                            WHERE `fpr`.`tipo` != 203
                                  AND fpr.tipo IN (SELECT c.tipo
                                                   FROM folhapagamento_parametro b
                                                     LEFT JOIN folhapagamento_faltainjust c
                                                       ON (b.idFolhaParametro = c.idFolhaParametro)
                                                   WHERE b.idParametro = $p_idParamFuncaoFunc
                                                         AND b.idCedente = $p_idCedente)
                                  AND `fpa`.`idParametro` =  '$p_idParamFuncaoFunc'";


        $folha_proventos = $this->db->query($sqlRecorrentes);

        $query = $this->db->last_query();

        if ($folha_proventos->num_rows()) {
            $valor += $folha_proventos->row()->p_valor;
        }

        return $valor;
    }

    public function getValorAtrazoJustSalario($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_hrInicio, $p_hrFinal)
    {
        $sql = "SELECT ((a.salario / " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') . ") *
                      ((TIME_TO_SEC(TIMEDIFF('$p_hrFinal', '$p_hrInicio')))/60/60)
                    )
                AS p_valor
                FROM folhapagamento_parametro a 
                RIGHT JOIN folhapagamento_atrasojust b
                    ON (a.idFolhaParametro = b.idFolhaParametro
                    and b.tipo = 186/*salario*/)
                WHERE a.idParametro = $p_idParamFuncaoFunc
                AND a.idCedente = $p_idCedente";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $consulta->row()->p_valor;
        }
        return 0;
    }

    public function getValorComprometidoFuncionario($p_idFuncionario, $p_tipo, $p_idEmprestimo)
    {
        $sql = "CASE $p_tipo
                WHEN 'FIN' /*valores de financiamentos*/
                THEN		/*atualmente está buscando tudo*/
                SELECT SUM(a.valor_parcelas)
                AS p_valor
                FROM `emprestimos_grava_financiamento` a
                WHERE a.idFuncionario = $p_idFuncionario
                AND a.situacao = 'aprovado'
                AND a.idEmprestimo != $p_idEmprestimo
                AND (
                    '' = $p_idEmprestimo
                    OR
                    a.dataSolicitacao <=
                        (SELECT b.dataSolicitacao 
                        FROM `emprestimos_grava_financiamento` b
                        WHERE b.idEmprestimo = $p_idEmprestimo)
                )
                GROUP BY a.idFuncionario";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $consulta->row()->p_valor;
        }
        return 0;
    }

    public function getValorFaltaInjustPericulosidade($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario)
    {
        $valor = 0;
        //antigo: (a.salario * (d.valor /100) ) /22
        $sql = "SELECT case b.formato
                when 1 then d.valor /22
                when 2 then (d.valor  / " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') . " *
                                        " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'D') . ")
                end
                AS p_valor
                FROM folhapagamento_parametro a 
                LEFT JOIN folhapagamento_faltainjust b
                    ON (a.idFolhaParametro = b.idFolhaParametro
                    and b.tipo = 203/*periculosidade*/)
                RIGHT JOIN `funcionario_remuneracao` c
                    ON (c.idFuncionario = $p_idFuncionario
                    AND c.periculosidade = 1)/*periculosidade=SIM*/
                RIGHT JOIN `folhapagamento_provento` d
                    ON (d.tipo = 203
                    AND a.idFolhaParametro = d.idFolhaParametro)
                WHERE a.idParametro = $p_idParamFuncaoFunc
                AND a.idCedente = $p_idCedente";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            $valor = $consulta->row()->p_valor;
        }

        return $valor;
    }

    public function getValorFaltaInjustProventos($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_referencia)
    {
        $valor = 0;

        $cargaHorariaC = $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C');
        $cargaHorariaD = $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'D');

        $sqlTipoIn = "SELECT c.tipo
                    FROM folhapagamento_parametro b
                    LEFT JOIN folhapagamento_faltainjust c
                        ON (b.idFolhaParametro = c.idFolhaParametro)
                    WHERE b.idParametro = $p_idParamFuncaoFunc
                    AND b.idCedente = $p_idCedente";

        $sql = "SELECT case b.formato
                when 1 then SUM(a.valor /22)
                when 2 then SUM(a.valor / " . $cargaHorariaC . " *
                                          " . $cargaHorariaD . ")
                end
                AS p_valor
                FROM provento a 
                LEFT JOIN folhapagamento_faltainjust b ON (
                    a.tipo = b.tipo 
                    and b.idFolhaParametro = (
                                    select c.idFolhaParametro 
                                    from folhapagamento_parametro c
                                    WHERE c.idParametro = $p_idParamFuncaoFunc
                                    AND c.idCedente = $p_idCedente
                    )
                )
                WHERE a.tipo IN (
                    $sqlTipoIn
                )
                AND a.idFuncionario = $p_idFuncionario
                AND a.referencia = $p_referencia";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            $valor += $consulta->row()->p_valor;
        }

        //valores recorrentes
        $sqlRecorrentes = "SELECT `fpr`.*, fpf.formato formato_correto, `fpa`.`idParametro`, `p`.`parametro` as nome_funcao, `p`.`codigoeSocial`
                            FROM (`folhapagamento_provento` as fpr)
                              JOIN `folhapagamento_parametro` as fpa ON `fpa`.`idFolhaParametro`=`fpr`.`idFolhaParametro` AND fpa.idCedente = $p_idCedente
                              JOIN `parametro` as p ON `p`.`idParametro`=`fpr`.`tipo`
                              JOIN `folhapagamento_faltainjust` as fpf ON `fpr`.`idFolhaParametro`=`fpf`.`idFolhaParametro` AND fpr.tipo = fpf.tipo
                            WHERE `fpr`.`tipo` != 203
                                  AND fpr.tipo IN (SELECT c.tipo
                                                   FROM folhapagamento_parametro b
                                                     LEFT JOIN folhapagamento_faltainjust c
                                                       ON (b.idFolhaParametro = c.idFolhaParametro)
                                                   WHERE b.idParametro = $p_idParamFuncaoFunc
                                                         AND b.idCedente = $p_idCedente)
                                  AND `fpa`.`idParametro` =  '$p_idParamFuncaoFunc'";


        $folha_proventos = $this->db->query($sqlRecorrentes)->result();

        $query = $this->db->last_query();

        foreach ($folha_proventos as $proventos) {
            $valor_provento = $proventos->valor;
            $formato = $proventos->formato_correto;

            if ($formato == 1) {
                $valor_provento = $valor_provento /22;
            } elseif ($cargaHorariaC > 0 and $cargaHorariaD > 0) {
                $valor_provento = $valor_provento / $cargaHorariaC * $cargaHorariaD;
            }

            $valor += $valor_provento;
        }

        return $valor;
    }

    public function getValorFaltaInjustSalario($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario)
    {
        $sql = "SELECT case b.formato
                when 1 then a.salario /22
                when 2 then (a.salario / " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') . " *
                                         " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'D') . ")
                end
                AS p_valor
                FROM folhapagamento_parametro a 
                RIGHT JOIN folhapagamento_faltainjust b
                    ON (a.idFolhaParametro = b.idFolhaParametro
                    and b.tipo = 186/*salario*/)
                WHERE a.idParametro = $p_idParamFuncaoFunc
                AND a.idCedente = $p_idCedente";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $consulta->row()->p_valor;
        }
        return 0;
    }

    public function getValorFaltaJustPericulosidade($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario)
    {
        $sql = "SELECT case b.formato
                when 1 then d.valor / 22
                when 2 then d.valor / " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') . " *
                                      " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'D') . ")
                end
                AS p_valor
                FROM folhapagamento_parametro a 
                LEFT JOIN folhapagamento_faltajust b
                    ON (a.idFolhaParametro = b.idFolhaParametro
                    and b.tipo = 203/*periculosidade*/)
                RIGHT JOIN `funcionario_remuneracao` c
                    ON (c.idFuncionario = $p_idFuncionario
                    AND c.periculosidade = 1)/*periculosidade=SIM*/
                RIGHT JOIN `folhapagamento_provento` d
                    ON (d.tipo = 203
                    AND a.idFolhaParametro = d.idFolhaParametro)
                WHERE a.idParametro = $p_idParamFuncaoFunc
                AND a.idCedente = $p_idCedente";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $consulta->row()->p_valor;
        }
        return 0;
    }

    public function getValorFaltaJustProventos($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_referencia)
    {
        $valor = 0;

        $cargaHorariaC = $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C');
        $cargaHorariaD = $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'D');

        $sql = "SELECT case b.formato
                when 1 then SUM(a.valor /22)
                when 2 then SUM(a.valor / " . $cargaHorariaC . " *
                                          " . $cargaHorariaD . ")
                end
                AS p_valor
                FROM provento a 
                LEFT JOIN folhapagamento_faltajust b ON (
                    a.tipo = b.tipo 
                    and b.idFolhaParametro = (
                                    select c.idFolhaParametro 
                                    from folhapagamento_parametro c
                                    WHERE c.idParametro = $p_idParamFuncaoFunc
                                    AND c.idCedente = $p_idCedente
                    )
                )
                WHERE a.tipo IN (
                    SELECT c.tipo
                    FROM folhapagamento_parametro b
                    LEFT JOIN folhapagamento_faltajust c
                        ON (b.idFolhaParametro = c.idFolhaParametro)
                    WHERE b.idParametro = $p_idParamFuncaoFunc
                    AND b.idCedente = $p_idCedente
                )
                AND a.idFuncionario = $p_idFuncionario
                AND a.referencia = $p_referencia";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            $valor += $consulta->row()->p_valor;
        }

        //valores recorrentes
        $sqlRecorrentes = "SELECT `fpr`.*, fpf.formato formato_correto, `fpa`.`idParametro`, `p`.`parametro` as nome_funcao, `p`.`codigoeSocial`
                            FROM (`folhapagamento_provento` as fpr)
                              JOIN `folhapagamento_parametro` as fpa ON `fpa`.`idFolhaParametro`=`fpr`.`idFolhaParametro` AND fpa.idCedente = $p_idCedente
                              JOIN `parametro` as p ON `p`.`idParametro`=`fpr`.`tipo`
                              JOIN `folhapagamento_faltainjust` as fpf ON `fpr`.`idFolhaParametro`=`fpf`.`idFolhaParametro` AND fpr.tipo = fpf.tipo
                            WHERE `fpr`.`tipo` != 203
                                  AND fpr.tipo IN (SELECT c.tipo
                                                   FROM folhapagamento_parametro b
                                                     LEFT JOIN folhapagamento_faltainjust c
                                                       ON (b.idFolhaParametro = c.idFolhaParametro)
                                                   WHERE b.idParametro = $p_idParamFuncaoFunc
                                                         AND b.idCedente = $p_idCedente)
                                  AND `fpa`.`idParametro` =  '$p_idParamFuncaoFunc'";


        $folha_proventos = $this->db->query($sqlRecorrentes)->result();

        $query = $this->db->last_query();

        foreach ($folha_proventos as $proventos) {
            $valor_provento = $proventos->valor;
            $formato = $proventos->formato_correto;

            if ($formato == 1) {
                $valor_provento = $valor_provento /22;
            } else {
                $valor_provento = $valor_provento / $cargaHorariaC * $cargaHorariaD;
            }

            $valor += $valor_provento;
        }

        return $valor;
    }

    public function getValorFaltaJustSalario($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario)
    {
        $valorC = $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C');
        $valorD = $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'D');

        $sql = "SELECT case b.formato
                when 1 then a.salario /22
                when 2 then (a.salario / " . $valorC . " *
                                         " . $valorD . ")
                end
                AS p_valor
                FROM folhapagamento_parametro a 
                RIGHT JOIN folhapagamento_faltajust b
                    ON (a.idFolhaParametro = b.idFolhaParametro
                    and b.tipo = 186/*salario*/)
                WHERE a.idParametro = $p_idParamFuncaoFunc
                AND a.idCedente = $p_idCedente";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $consulta->row()->p_valor;
        }
        return 0;
    }

    public function getValorFaltasAtrasos(
        $p_idTipoFalta,
        $p_idParamFuncaoFunc,
        $p_idCedente,
        $p_idFuncionario,
        $p_referencia,
        $p_hrInicio,
        $p_hrFinal,
        $salario,
        $valorPericulosidade,
        $valorInsalubridade
    ) {
        $valor = 0;

        switch ($p_idTipoFalta) {
            case 897: /*falta justificada*/
                $valor1 = $valor = $this->getValorFaltaJustSalario($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario);
                $valor2 = $this->getValorFaltaJustProventos($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_referencia);
                $valor3 = $this->getValorFaltaJustPericulosidade($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario);
                $valor4 = $this->getValorDescontoPericulosidadeInsalubridade(
                    "folhapagamento_faltajust",
                    $p_idCedente,
                    $p_idParamFuncaoFunc,
                    $p_idFuncionario,
                    $salario,
                    $valorPericulosidade,
                    $valorInsalubridade
                );
                $valor = $valor1 + $valor2 + $valor3 + $valor4;
                return $valor;
                break;

            case 896: /*falta injustificada*/
                $valor1 = $this->getValorFaltaInjustSalario($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario);
                $valor2 = $this->getValorFaltaInjustProventos($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_referencia);
                $valor3 = $this->getValorFaltaInjustPericulosidade($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario);
                $valor4 = $this->getValorDescontoPericulosidadeInsalubridade(
                    "folhapagamento_faltainjust",
                    $p_idCedente,
                    $p_idParamFuncaoFunc,
                    $p_idFuncionario,
                    $salario,
                    $valorPericulosidade,
                    $valorInsalubridade
                );
                $valor = $valor1 + $valor2 + $valor3 + $valor4;
                return $valor;
                break;

            case 899: /*atrazo injustificado*/
                $valor1 = $valor = $this->getValorAtrazoInjustSalario($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_hrInicio, $p_hrFinal);
                $valor2 = $this->getValorAtrazoInjustProventos($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_referencia, $p_hrInicio, $p_hrFinal);
                $valor3 = $this->getValorAtrazoInjustPericulosidade($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_hrInicio, $p_hrFinal);
                $valor4 = $this->getValorDescontoPericulosidadeInsalubridade(
                    "folhapagamento_atrasoinjust",
                    $p_idCedente,
                    $p_idParamFuncaoFunc,
                    $p_idFuncionario,
                    $salario,
                    $valorPericulosidade,
                    $valorInsalubridade,
                    $p_hrInicio,
                    $p_hrFinal
                );
                $valor = $valor1 + $valor2 + $valor3 + $valor4;
                return $valor;
                break;

            case 898: /*atrazo justificado*/
                $valor1 = $this->getValorAtrazoJustSalario($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_hrInicio, $p_hrFinal);
                $valor2 = $this->getValorAtrazoJustProventos($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_referencia, $p_hrInicio, $p_hrFinal);
                $valor3 = $this->getValorAtrazoJustPericulosidade($p_idParamFuncaoFunc, $p_idCedente, $p_idFuncionario, $p_hrInicio, $p_hrFinal);
                $valor4 = $this->getValorDescontoPericulosidadeInsalubridade(
                    "folhapagamento_atrasojust",
                    $p_idCedente,
                    $p_idParamFuncaoFunc,
                    $p_idFuncionario,
                    $salario,
                    $valorPericulosidade,
                    $valorInsalubridade,
                    $p_hrInicio,
                    $p_hrFinal
                );
                $valor = $valor1 + $valor2 + $valor3 + $valor4;
                return $valor;
                break;

        }

        return $valor;
    }

    public function getValorDescontoPericulosidadeInsalubridade(
        $tabelaJoin,
        $p_idCedente,
        $p_idParamFuncaoFunc,
        $p_idFuncionario,
        $salario,
        $valor_periculosidade,
        $valorInsalubridade,
        $p_hrInicio = null,
        $p_hrFinal = null
    ) {
        $valor = 0;

        if ($valor_periculosidade > 0) {
            $formato = $this->formatoDescontoPericInsal($tabelaJoin, $p_idCedente, $p_idParamFuncaoFunc, 203);//203 Adicional de Insalubridade

            $carcaHorariaC = $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C');
            $carcaHorariaD = $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'D');

            if ($p_hrInicio == null) {
                if ($formato == 1) {
                    $valor += $valor_periculosidade / 22;
                } elseif ($carcaHorariaC > 0 and $carcaHorariaD > 0) {
                    $valor += $valor_periculosidade / $carcaHorariaC * $carcaHorariaD;
                }
            } elseif ($carcaHorariaC > 0) {
                $timeDiff = $this->timeDiff($p_hrInicio, $p_hrFinal);
                $valor += $valor_periculosidade / $carcaHorariaC * $timeDiff;
                /*(a.salario / " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') . ") *
                      ((TIME_TO_SEC(TIMEDIFF('$p_hrFinal', '$p_hrInicio')))/60/60)*/
            }
        }

        if ($valorInsalubridade > 0) {
            $formato = $this->formatoDescontoPericInsal($tabelaJoin, $p_idCedente, $p_idParamFuncaoFunc, 202);//202 Adicional de Insalubridade

            if ($p_hrInicio == null) {
                if ($formato == 1) {
                    $valor += $valorInsalubridade / 22;
                } else {
                    $valor += $valorInsalubridade / $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') *
                            $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'D');
                }
            } else {
                $timeDiff = $this->timeDiff($p_hrInicio, $p_hrFinal);
                $valor += $valorInsalubridade / $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') * $timeDiff;
                /*(a.salario / " . $this->getCargaHorariaFuncionario($p_idFuncionario, $p_idCedente, 'C') . ") *
                      ((TIME_TO_SEC(TIMEDIFF('$p_hrFinal', '$p_hrInicio')))/60/60)*/
            }
        }

        return $valor;
    }

    public function timeDiff($p_hrInicio, $p_hrFinal)
    {
        $time1 = strtotime($p_hrInicio);
        $time2 = strtotime($p_hrFinal);

        $diff = $time2 - $time1;

        return $diff /60/60; //converte em horas
    }

    public function formatoDescontoPericInsal($tabelaJoin, $p_idCedente, $p_idParamFuncaoFunc, $idTipo)
    {
        $sql = "SELECT b.formato
				FROM folhapagamento_parametro a
				JOIN $tabelaJoin b ON (a.idFolhaParametro = b.idFolhaParametro AND b.tipo = $idTipo)
				WHERE a.idCedente = $p_idCedente
				AND	a.idParametro = $p_idParamFuncaoFunc";

        $consulta = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            $consulta->row()->formato;
        }

        return null;
    }
}
