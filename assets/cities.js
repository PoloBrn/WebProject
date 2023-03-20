$(function () {
    //$('#cookie_input').val(getCookie(username));
    
    $('#postal_code').keyup(function () {
        $('#city').html(getCity($('#postal_code').val()));
    });



})
function startCity(value) {
    $('#city').html(getCity($('#postal_code').val()));
    $('#city').val(value);
}

function getCity(postalCode) {
    let html = '';
    $.ajax({
        async: false,
        type: "get",
        url: "https://apicarto.ign.fr/api/codes-postaux/communes/" + postalCode,
        success: function (response) {
            for (element in response) {
                html += '<option value="' + response[element].nomCommune + '">' + response[element].nomCommune + '</option>'
            }

        },
        error: function () {
            html = '';
        }
    });
    return html;
}