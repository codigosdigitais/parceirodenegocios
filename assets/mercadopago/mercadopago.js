// Javascript

/*
 *@autor: André Baill
 *@date: 21/10/2020
 *@base: https://www.mercadopago.com.co/developers/pt/guides/online-payments/checkout-api/receiving-payment-by-card/
 *@description: envio de requisição de pagamento Mercado Pago
 */
function PagamentoViaMercadoPago() {

    // Public Key
    window.Mercadopago.setPublishableKey("TEST-8fe433e0-8924-4a4f-8137-98ccc8bc857e");

    // Tipos de Identificação
    window.Mercadopago.getIdentificationTypes();

    // Checar cartão - número
    // document.getElementById('cardNumber').addEventListener('change', guessPaymentMethod);

    document.getElementById('cardNumber').addEventListener('keyup', guessPaymentMethod);
    document.getElementById('cardNumber').addEventListener('change', guessPaymentMethod);

    // Confiura Mensagem no select de parcelas
    let opt_installments = document.createElement('option');
    opt_installments.text = 'À vista';
    opt_installments.value = '1';
    document.getElementById('installments').appendChild(opt_installments);

    function guessPaymentMethod(event) {
        let cardnumber = document.getElementById("cardNumber").value;
        var cardnumber_search = cardnumber.replace(" ", "");
        // let cardnumber.;
        if (cardnumber_search.length >= 6) {
            let bin = cardnumber_search.substring(0, 6);
            //alert(bin)
            window.Mercadopago.getPaymentMethod({
                "bin": bin
            }, setPaymentMethod);
        }

        if (cardnumber_search.length >= 18) {
            verifyCreditCard();
        }
    };

    function setPaymentMethod(status, response) {

        if (status == 200) {
            let paymentMethod = response[0];

            document.getElementById('paymentMethodId').value = paymentMethod.id;
            document.getElementById('issuer').value = paymentMethod.id.toUpperCase();

            if (paymentMethod.additional_info_needed.includes("issuer_id")) {
                getIssuers(paymentMethod.id);
            } else {
                getInstallments(
                    paymentMethod.id,
                    document.getElementById('transactionAmount').value
                );
            }
        } else {
            alert(`payment method info error: ${response}`);
        }
    }

    function getIssuers(paymentMethodId) {
        window.Mercadopago.getIssuers(
            paymentMethodId,
            setIssuers
        );
    }

    function setIssuers(status, response) {
        if (status == 200) {
            let issuerSelect = document.getElementById('issuer');
            response.forEach(issuer => {
                let opt = document.createElement('option');
                opt.text = issuer.name;
                opt.value = issuer.id;
                issuerSelect.appendChild(opt);
                console.log(opt.text)
            });

            getInstallments(
                document.getElementById('paymentMethodId').value,
                document.getElementById('transactionAmount').value,
                issuerSelect.value
            );
        } else {
            alert(`issuers method info error: ${response}`);
        }
    }

    function getInstallments(paymentMethodId, transactionAmount, issuerId) {
        window.Mercadopago.getInstallments({
            "payment_method_id": paymentMethodId,
            "amount": parseFloat(transactionAmount),
            "issuer_id": issuerId ? parseInt(issuerId) : undefined
        }, setInstallments);
    }

    function setInstallments(status, response) {
        /*if (status == 200) {
            document.getElementById('installments').options.length = 0;
        //response[0].payer_costs.forEach(payerCost => {
                let opt = document.createElement('option');
                opt.text = '1 parcela';
                opt.value = '1';
                document.getElementById('installments').appendChild(opt);
            //});
        } else {
            alert(`installments method info error: ${response}`);
        }*/
    }

    doSubmit = false;
    document.getElementById('paymentForm').addEventListener('submit', getCardToken);

    function getCardToken(event) {

        event.preventDefault();
        verifyCreditCard();
        //return false;

        if (!doSubmit) {
            let $form = document.getElementById('paymentForm');
            window.Mercadopago.createToken($form, setCardTokenAndPay);
            return false;
        }
    };

    function setCardTokenAndPay(status, response) {
        if (status == 200 || status == 201) {
            let form = document.getElementById('paymentForm');
            let card = document.createElement('input');
            card.setAttribute('name', 'token');
            card.setAttribute('type', 'hidden');
            card.setAttribute('value', response.id);
            form.appendChild(card);
            doSubmit = true;
            form.submit();
        } else {
            alert("Verify filled data!\n" + JSON.stringify(response, null, 4));
        }
    };


    function verifyCreditCard() {
        var valid = $.payment.validateCardNumber($('.cc-num').val());
        if (!valid) {
            alert('Your card is not valid!');
            return false;
        }
    }

}

$('.cc-exp').payment('formatCardExpiry');
$('.cc-num').payment('formatCardNumber');

PagamentoViaMercadoPago();