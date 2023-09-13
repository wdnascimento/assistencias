$(function() {
    $('#celular').mask('(00) 00000-0000');
    $('#password_aluno').mask('00000000', {reverse: true});
    $('.numero').mask('00000000', {reverse: true});
    $('.cabine').mask('00', {reverse: true});

    if(! $("#trocar_senha_aluno").is(":checked")){
        $("#update_password_aluno").hide();
        $("#password_aluno").prop('disabled', true);
    }
    if(! $("#send_sms").is(":checked")){
        $("#div_celular").hide();
        $("#celular").prop('disabled', true);
    }


    $("#send_sms").on('click', function () {
        if ($(this).is(":checked")) {
            $("#div_celular").show();
            $("#celular").prop('disabled', false);
        } else {
            $("#div_celular").hide();
            $("#celular").prop('disabled', true);
        }
    });

    $("#trocar_senha_aluno").on('click', function () {
        if ($(this).is(":checked")) {
            $("#update_password_aluno").show();
            $("#password_aluno").prop('disabled', false);
        } else {
            $("#update_password_aluno").hide();
            $("#password_aluno").prop('disabled', true);
        }
    });


});

$(function() {
    $("#finalizar").on('submit',function( event ) {
        event.preventDefault();

        swal({
            title: 'Tem certeza que deseja finalizar seu atendimento',
            text: "Por favor confirme se realmente deseja fazer isso.",
            type: 'warning',
            buttons: true,
            dangerMode: true,


        })
        .then((willDelete) => {
            if (willDelete) {
                $("#finalizar").off( "submit" ).submit();
            }else{
                swal.close();
            }
        });
    });
});
