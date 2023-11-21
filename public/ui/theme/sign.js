window.draw_sign = function() {
    $('.pad').each(function() {
        $(this).signature().signature('draw', $(this).prev('.sign').html()).signature('disable');
    })
}