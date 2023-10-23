<?php
class localizacao_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function updateLastRequestDate($idEmpresa){
		$update = "UPDATE app_location_request SET requested_at = NOW() WHERE id_empresa = $idEmpresa";
		$this->db->query($update);

        if ($this->db->affected_rows() == 0) {
            $insert = "INSERT INTO app_location_request (id_empresa, requested_at) 
                       VALUES ($idEmpresa, NOW())";
            $this->db->query($insert);
        }
    }

    function getLocationHistory($idEmpresa, $idProfissional, $dataInicio, $dataFim, $limit, $offset, $selectTotal = false)
    {
        if ($selectTotal) {
            $this->db->select('count(a.id) AS total');
        }
        else {
            $this->db->select('a.*, b.nome, b.login');
        }

        if (null != $idProfissional) {
            $this->db->where('a.idUsuario = ' . $idProfissional);
        }
		$this->db->where("a.updated_at >= '". $dataInicio ."'");
		$this->db->where("a.updated_at <= '". $dataFim ."'");
		$this->db->where('b.idEmpresa', $idEmpresa);
		$this->db->join('sis_usuario b', 'a.idUsuario = b.idUsuario');

        if (! $selectTotal) {
            $this->db->order_by('a.idUsuario, a.updated_at');
            $this->db->limit($limit, $offset);
        }

		$consulta = $this->db->get('app_users_location_log a');

		if ($this->db->affected_rows() >= 0) {
			return $consulta->result();
		}

		return false;
    }

    function getLocations($idEmpresa){
		$this->db->select('a.*, b.nome, b.login');
		#$this->db->where('a.updated_at > (now() - INTERVAL 24 HOUR)');
		$this->db->where('b.idEmpresa', $idEmpresa);
		$this->db->join('sis_usuario b', 'a.idUsuario = b.idUsuario');
		$consulta = $this->db->get('app_users_location a');
		
		if ($this->db->affected_rows() >= 0) {
			return $consulta->result();
		}

		return false;
    }

    function getProfessionals($idEmpresa)
    {
        $this->db->select('a.idUsuario, b.nome');
        $this->db->where('b.idEmpresa', $idEmpresa);
        $this->db->join('sis_usuario b', 'a.idUsuario = b.idUsuario');
        $this->db->order_by('b.nome');
        $this->db->group_by('a.idUsuario, b.nome');

        $consulta = $this->db->get('app_users_location_log a');

        if ($this->db->affected_rows() >= 0) {
            return $consulta->result();
        }

        return false;
    }

}