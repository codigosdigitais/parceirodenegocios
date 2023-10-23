<?php
class Entrega_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function getEmpresaSimulaAcesso($where) {
        $this->db->select('a.idCliente idEmpresa, a.idCliente, a.razaosocial');
        $this->db->where($where);
        $this->db->from('cliente a');
        
        $result = $this->db->get();
        
        if ($this->db->affected_rows() == 1) {
            return $result->result();
        }
         
        return FALSE;
    }

    public function getUsuarioExterno($where) {
        
        $this->db->select('a.idUsuario, a.idEmpresa, a.idEmpresa idCliente, a.idFuncionario, a.nome, a.tipo, a.login');
        $this->db->select('b.razaosocial, b.tipo tipoEmpresa');
        $this->db->select('c.idCliente idAcessoExterno, c.nomefantasia nomeEmpresaVinculo');
        $this->db->where($where);
        $this->db->from('sis_usuario a');
        $this->db->join('cliente b', 'a.idEmpresa = b.idCliente', 'right');
        $this->db->join('cliente c', 'a.idCliente = c.idCliente', 'left');

        //cliente deve ser um parceiro de negócios ativo
        $this->db->where("b.tipo IN ('parceiro', 'SISAdmin')");
        //$this->db->where('b.situacao', 1);

        //Quando usuario é externo, deverá estar vinculado a um cliente ativo = Tipo Externo
        $this->db->where("(a.tipo IN ('SISAdmin', 'Externo')
                          OR
                          (a.idCliente IS NOT NULL AND c.situacao = 1)
                          )");

        $result = $this->db->get();
        
        // echo $this->db->last_query();
        // echo "<hr>";
        // print_r($result->result());
        // die();
        

            /*

            SELECT 
                `a`.`idUsuario`, 
                `a`.`idEmpresa`, 
                `a`.`idEmpresa` idCliente, 
                `a`.`idFuncionario`, 
                `a`.`nome`, 
                `a`.`tipo`, 
                `a`.`login`, 
                `b`.`razaosocial`, 
                `b`.`tipo` tipoEmpresa, 
                `c`.`idCliente` idAcessoExterno, 
                `c`.`nomefantasia` nomeEmpresaVinculo

            FROM (`sis_usuario` a)
                RIGHT JOIN `cliente` b ON `a`.`idEmpresa` = `b`.`idCliente`
                LEFT JOIN `cliente` c ON `a`.`idCliente` = `c`.`idCliente`
                
            WHERE `a`.`login` =  'srandrebaill@gmail.com'
            AND `a`.`idEmpresa` =  '148'
            AND `a`.`senha` =  'e10adc3949ba59abbe56e057f20f883e'
            AND `a`.`situacao` =  5
            AND `b`.`tipo` IN ('parceiro', 'SISAdmin')

            AND (a.tipo IN ('SISAdmin', 'Externo')
            OR (a.idCliente IS NOT NULL AND c.situacao = 1))

            */

        if ($this->db->affected_rows() == 1) {
            return $result->result();
        }
        
        return FALSE;
    }    
    

    # Chamada Externa - Login Atual - 2021 - 04 - 19
    public function getUsuarioChExterna($where) {
        
        $this->db->select('a.idUsuario, a.idEmpresa, a.idEmpresa idCliente, a.idFuncionario, a.nome, a.tipo, a.login');
        $this->db->select('b.razaosocial, b.tipo tipoEmpresa');
        $this->db->select('c.idCliente idAcessoExterno, c.nomefantasia nomeEmpresaVinculo');
        $this->db->where($where);
        $this->db->from('sis_usuario a');
        $this->db->join('cliente b', 'a.idEmpresa = b.idCliente', 'right');
        $this->db->join('cliente c', 'a.idCliente = c.idCliente', 'left');

        //cliente deve ser um parceiro de negócios ativo
        $this->db->where("b.tipo IN ('parceiro', 'SISAdmin')");
        //$this->db->where('b.situacao', 1);

        //Quando usuario é externo, deverá estar vinculado a um cliente ativo = Tipo Externo
        $this->db->where("(a.tipo IN ('Externo')
                          OR
                          (a.idCliente IS NOT NULL AND c.situacao = 1)
                          )");

        $result = $this->db->get();

        if ($this->db->affected_rows() == 1) {
            return $result->result();
        }
        
        return FALSE;
    }  





    public function getUsuario($where) {
        
        $this->db->select('a.idUsuario, a.idEmpresa, a.idEmpresa idCliente, a.idFuncionario, a.nome, a.tipo, a.login');
        $this->db->select('b.razaosocial, b.tipo tipoEmpresa');
        $this->db->select('c.idCliente idAcessoExterno, c.nomefantasia nomeEmpresaVinculo');
        $this->db->where($where);
        $this->db->from('sis_usuario a');
        $this->db->join('cliente b', 'a.idEmpresa = b.idCliente', 'right');
        $this->db->join('cliente c', 'a.idCliente = c.idCliente', 'left');

        //cliente deve ser um parceiro de negócios ativo
        $this->db->where("b.tipo IN ('parceiro', 'SISAdmin')");
        $this->db->where('b.situacao', 1);

        //Quando usuario é externo, deverá estar vinculado a um cliente ativo
        $this->db->where("(a.tipo IN ('SISAdmin', 'Interno')
                          OR
                          (a.idCliente IS NOT NULL AND c.situacao = 1)
                          )");

        $result = $this->db->get();
        /*
        echo $this->db->last_query();
        echo "<hr>";
        var_dump($result->result());
        die();
        */
        if ($this->db->affected_rows() == 1) {
            return $result->result();
        }
        
        return FALSE;
    }

    public function getUsuarioSimulaAcesso($where) {
        
        $this->db->select('a.idUsuario idUsuarioSimulacao, a.nome nomeSimulacao, a.tipo tipoSimulacao, a.login loginSimulacao');
        $this->db->select('a.idEmpresa, a.idEmpresa idCliente, a.idFuncionario');
        $this->db->select('b.razaosocial, b.tipo tipoEmpresa');
        $this->db->select('c.idCliente idAcessoExterno, c.nomefantasia nomeEmpresaVinculo');
        $this->db->where($where);
        $this->db->from('sis_usuario a');
        $this->db->join('cliente b', 'a.idEmpresa = b.idCliente', 'right');
        $this->db->join('cliente c', 'a.idCliente = c.idCliente', 'left');
         
        //cliente deve ser um parceiro de negócios ativo
        $this->db->where("b.tipo IN ('parceiro', 'SISAdmin')");
        $this->db->where('b.situacao', 1);
         
        //Quando usuario é externo, deverá estar vinculado a um cliente ativo
        $this->db->where("(a.tipo IN ('SISAdmin', 'Interno')
                          OR
                          (a.idCliente IS NOT NULL AND c.situacao = 1)
                          )");
         
        $result = $this->db->get();
        /*
         echo $this->db->last_query();
         echo "<hr>";
         var_dump($result->result());
         die();
            */
        if ($this->db->affected_rows() == 1) {
            return $result->result();
        }
         
        return FALSE;
    }

    public function getParceirosParaSelecionar() {
        $this->db->select("a.idCliente, a.tipo, a.nomefantasia, a.situacao");
        $this->db->where("a.tipo IN ('parceiro', 'SISAdmin')");
        $this->db->order_by("a.tipo desc, a.nomefantasia");
        
        $result = $this->db->get('cliente a');

        if ($this->db->affected_rows() > 0) {
            $parceiros = $result->result();
            
            foreach ($parceiros as $value) {
                //busca usuários cadastrados no cliente
                $this->db->select("a.idUsuario, a.nome");
                $this->db->where("a.idEmpresa", $value->idCliente);
                $this->db->where("a.situacao", true);
                $this->db->order_by("a.idUsuario asc");
                 
                $result = $this->db->get('sis_usuario a');
                if ($this->db->affected_rows() > 0) {
                    $value->usuarios = $result->result();
                }
                
                //busca perfis cadastrados no cliente
                $this->db->select("a.idPerfil, a.nome");
                /**
                 | Apenas perfil #Tudo Liberado 
                 */
                //$this->db->where('a.idPerfil', 100);
                $this->db->where("a.idEmpresa = ". $value->idCliente .
                                 " AND a.situacao = 1".
                                 " OR a.idPerfil = 100");
                
                
                $this->db->order_by("a.nome asc");
                
                $result = $this->db->get('sis_perfil a');
                if ($this->db->affected_rows() > 0) {
                    $value->perfis = $result->result();
                }
            }
            
            return $parceiros;
        }
        
        return FALSE;
    }
    
    public function listaModulosBase(){
        $this->db->where('idModuloBase',"0");
        return $this->db->get('modulos')->result(); 
    }

    public function getModulosCategoria(){
        $sql = "SELECT * FROM modulos WHERE idModuloBase = '0' ORDER BY modulo ASC";
        $consulta = $this->db->query($sql)->result();   
        
            foreach($consulta as &$valor){
                $sql_model = "SELECT * FROM modulos WHERE idModuloBase = '{$valor->idModulo}' ORDER BY modulo ASC";
                $valor->subModulo = $this->db->query($sql_model)->result();     
            }
        
        return $consulta;
    }

}