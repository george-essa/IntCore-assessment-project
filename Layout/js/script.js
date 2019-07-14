$(document).ready(function () {
    // append eye icon on password type input

    $('input').each(function() {
        if($(this).attr('type') === 'password') {
            $(this).after('<i class="fas fa-eye show-password"></i>');
        }
    });
    // show and hide password on click

    $('.show-password').click(function () {
       if($(this).prev('input').attr('type') === 'password'){
           $(this).prev('input[type="password"]').attr('type','text').end()
               .removeClass('fa-eye').addClass('fa-eye-slash');
       } else {
           $(this).prev('input[type="text"]').attr('type','password').end()
               .removeClass('fa-eye-slash').addClass('fa-eye');
       }
    });

});