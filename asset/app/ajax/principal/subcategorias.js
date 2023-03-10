$(document).ready(function() {

    $(".subcategoriasVer").on("click", function() {
        var categoria = $(this).data('product_code');
        var nombrecate = $(this).data('product_code1');

        $("#formulario" + categoria).submit();

    });


});