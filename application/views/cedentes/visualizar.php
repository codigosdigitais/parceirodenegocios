<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Dados do Cedente</li></ol>
    <ol class="breadcrumb"> 
    <?php if($this->permission->canInsert()){ ?>
        <a href="<?php echo base_url();?>cedentes/adicionar" class="btn btn-primary"><i class="icon-plus icon-white"></i> Adicionar Cedente</a>
    <?php } ?>
    <?php 
        if($this->permission->canUpdate())
        {
         echo '<a title="Editar Registro" class="btn btn-danger" href="'.base_url().'cedentes/editar/'.$result[0]->idCedente.'"><i class="icon-pencil icon-white"></i> Editar este Registro</a>'; 
        } 
    ?> 
    </ol>
</nav>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th scope="col" width="30%">Razão Social</th>
            <th scope="col" width="20%">CNPJ</th>
            <th scope="col" width="30%">Endereço</th>
            <th scope="col">Cidade</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><b><?php echo $result[0]->razaosocial; ?></b></td>
            <td><?php echo $result[0]->cnpj; ?></td>
            <td><?php echo $result[0]->endereco.", ".$result[0]->endereco_numero." - ".$result[0]->endereco_bairro; ?></td>
            <td><?php echo $result[0]->endereco_cidade." - ".$result[0]->estado; ?></td>
        </tr>
    </tbody>
</table>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th scope="col" width="30%">Responsável</th>
            <th scope="col" width="20%">E-mail</th>
            <th scope="col" width="30%">Telefone</th>
            <th scope="col">Celular</th>
        </tr>        
    </thead>
    <tbody>
        <tr>
            <td><?php echo $result[0]->responsavel; ?></td>
            <td><?php echo $result[0]->email; ?></td>
            <td><?php echo $result[0]->responsavel_telefone; ?></td>
            <td><?php echo $result[0]->responsavel_celular; ?></td>
        </tr>        
    </tbody>
</table>

<table class="table table-bordered">
    <tbody>
        <?
        if(count($result[0]->documentacao)>0){ 
            foreach($result[0]->documentacao as $documento){
        ?>
        <tr>
            <td style="text-align: right; width: 30%"><strong><? echo $documento->nomearquivo;?></strong></td>
            <td><? echo '<a href="'.base_url().'documentos/download/'.$documento->idDocumento.'" style="margin-right: 1%" class="btn " title="Download do Arquivo"><i class="icon-download-alt"></i></a>'; ?></td>
        </tr>
        <? 
            } 
        } else { 
        
        ?>
        <tr>
            <td>
                Este cliente não possui nenhum documento arquivado até o momento.
            </td>
        </tr>
        <? } ?>
    </tbody>
</table>