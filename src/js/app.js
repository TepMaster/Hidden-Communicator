$(document).ready(function() {

    // init forms
    $('.ui.form').form({
        fields: {
            user : 'empty',
            pass : ['minLength[6]', 'empty'],
            terms: 'checked'
        }
    });

});

