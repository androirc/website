$(document).ready(function() {
    $('#locales select').change(function() {
        window.location = $(this).val();
    });
});