<?php
$config = array('clientes' => array(array(
                                	'field'=>'razaosocial',
                                	'label'=>'Razão Social',
                                	'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'parametros' => array(array(
                                    'field'=>'parametro',
                                    'label'=>'parametro',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'documentos' => array(array(
                                    'field'=>'nomearquivo',
                                    'label'=>'nomearquivo',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'funcionario' => array(array(
                                    'field'=>'blocobase_nome',
                                    'label'=>'Nome',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'proventos' => array(array(
                                    'field'=>'idFuncionario',
                                    'label'=>'Funcionário',
                                    'rules'=>'required|trim|xss_clean'
                                )),
				'adicionais' => array(array(
                                    'field'=>'tipoValor',
                                    'label'=>'tipoValor',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'faltas' => array(array(
                                    'field'=>'idTipo',
                                    'label'=>'Tipo',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'atrasos' => array(array(
                                    'field'=>'idFuncionario',
                                    'label'=>'Funcionário',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'descontos' => array(array(
                                    'field'=>'idFuncionario',
                                    'label'=>'Funcionário',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'cidades' => array(array(
                                    'field'=>'idEstado',
                                    'label'=>'Estado',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'idTipo',
                                    'label'=>'Tipo',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'cidade',
                                    'label'=>'Cidade',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'usuarios' => array(array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'rg',
                                    'label'=>'RG',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'cpf',
                                    'label'=>'CPF',
                                    'rules'=>'required|trim|xss_clean|is_unique[usuarios.cpf]'
                                ),
                                array(
                                    'field'=>'rua',
                                    'label'=>'Rua',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'numero',
                                    'label'=>'Numero',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'bairro',
                                    'label'=>'Bairro',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'cidade',
                                    'label'=>'Cidade',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'estado',
                                    'label'=>'Estado',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'email',
                                    'label'=>'Email',
                                    'rules'=>'required|trim|valid_email|xss_clean'
                                ),
                                array(
                                    'field'=>'senha',
                                    'label'=>'Senha',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'telefone',
                                    'label'=>'Telefone',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'situacao',
                                    'label'=>'Situacao',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,      
                'bairros' => array(array(
                                    'field'=>'idCidade',
                                    'label'=>'Cidade',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'bairro',
                                    'label'=>'Bairro',
                                    'rules'=>'required|trim|xss_clean'
                                ))

                  ,
				'tiposUsuario' => array(array(
                                	'field'=>'nomeTipo',
                                	'label'=>'NomeTipo',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'situacao',
                                	'label'=>'Situacao',
                                	'rules'=>'required|trim|xss_clean'
                                ))

                ,
                'cedentes' => array(array(
                                    'field'=>'razaosocial',
                                    'label'=>'Razão Social',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'fornecedores' => array(array(
                                    'field'=>'razaosocial',
                                    'label'=>'Razão Social',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'contratos' => array(array(
                                    'field' => 'idCliente',
                                    'label' => 'Cliente',
                                    'rules' => 'required|trim|xss_clean'
                                ))
				,
                'tabelafretes' => array(array(
                                    'field' => 'idCidade',
                                    'label' => 'Cidade',
                                    'rules' => 'required|trim|xss_clean'
                                ))
				,
                'chamadas' => array(array(
                                    'field' => 'idCliente',
                                    'label' => 'Cliente',
                                    'rules' => 'required|trim|xss_clean'
                                ))
				,
                'substituicoes' => array(array(
                                    'field' => 'idCliente',
                                    'label' => 'Cliente',
                                    'rules' => 'required|trim|xss_clean'
                                ))
                ,
                'administrando_modulos' => array(array(
                                    'field'=>'modulo',
                                    'label'=>'modulo',
                                    'rules'=>'required|trim|xss_clean'
                                ))
		);
			   