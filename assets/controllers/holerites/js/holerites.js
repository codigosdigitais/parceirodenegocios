/* @ função para confirmar holerite
 * @ dessa forma o holerite seria confirmado e salvo no banco de dados
 * @ para que possa ser consultado posteriormente, uma vez fechado, não é permitido alterar
 * @ qualquer lançamento na base de dados com aquele idFuncionario e Periodo (data inicial e final) definidos
 * @ rota de confirmação: ao clicar em confirmar, salva no banco de dados e retorna para a lista 
 * @ nesta lista, já constará como confirmado (no período confirmado) 
 * @ 21 de junho de 2021 - 09:40
 */


$(document).ready(function() {



    /* executar confirmação do holerite */
    $(function() {

        /* alert para verificar se realmente deseja executar esta acao */
        $("#confirmar-holerite").click(function() {

            /* preparar variaveis para executar */
            var ciclo_1 = $(this).attr('data-ciclo_1');
            var ciclo_2 = $(this).attr('data-ciclo_2');
            var idFuncionario = $(this).attr('data-idFuncionario');
            var vencimentos = $(this).attr('data-vencimentos');
            var descontos = $(this).attr('data-descontos');
            var liquido = $(this).attr('data-liquido');

            Swal.fire({
                title: 'Deseja fechar o ciclo deste funcionário?',
                text: "Se você fechar o ciclo deste funcionário, não poderá reabri-lo, apenas visualizar posteriormente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-check"></i> Confirmar',
                cancelButtonText: '<i class="fa fa-remove"></i> Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: BASE_URL + '/holerites/confirmar_holerite',
                        type: "post",
                        data: {
                            ciclo_1: ciclo_1,
                            ciclo_2: ciclo_2,
                            idFuncionario: idFuncionario,
                            vencimentos: vencimentos,
                            descontos: descontos,
                            liquido: liquido
                        },
                        success: function(response) {
                            console.log("Retorno:", response);

                            Swal.fire(
                                'Confirmado!',
                                'Você fechou o ciclo deste funcionário. Não será possível alterações futuras.',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload(1)
                                }
                            })
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });

                }
            })
        });

    });



    // códigos jQuery a serem executados quando a página carregar



    $('.trocarPeriodo').on('change', function() {
        let ciclo = $(this).val();
        window.location.href = BASE_URL + '/holerites/index/' + ciclo;
    });










});