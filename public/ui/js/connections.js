$(document).ready(function() {

    let info = JSON.parse($('#info').html());
    for ( let item of info) {
        console.log(item);
        $('label:contains('+item[0]+') + .form-control').val(item[1]);
    }
    console.log(info);


})