$(document).ready(function(){
    // Отправка комментариев приватных
    $('#private-comment-submit').on('click', function () {
        var text = $('#private-comment-message').val();
        var userId = $('#private-comment-user-id').val();
        var orderId = $('#private-comment-order-id').val();

        $.ajax({
            url: '/private-message/add',
            method: 'post',
            data: {
                'message': text,
                'order-id': orderId,
                'user-id': userId
            },
        }).done(function() {
            $('#myModal').modal('hide');
            location.reload();
        });
    });
});