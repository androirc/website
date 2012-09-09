$(document).ready(function() {
    $('#locales select').chosen();

    $('#locales select').change(function() {
        window.location = $(this).val();
    });
});