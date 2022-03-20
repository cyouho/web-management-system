$(document).ready(function () {
    var token = $('meta[name="csrf-token"]').attr('content');

    $('#userDataSearch').click(function () {
        userEmail = $("#userEmail").val();

        $('#userDataDetail').load('/userDataDetailAjax', {
            'user_email': userEmail, '_token': token,
        });
    });
});