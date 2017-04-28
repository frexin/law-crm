$(function () {
    var mainCalendar = $('#datetimepicker12');
    var currentDate = mainCalendar.data('date');

    mainCalendar.datetimepicker({
        inline: true,
        sideBySide: true,
        format: 'DD/MM/YYYY',
        defaultDate: new Date(currentDate),
    });

    mainCalendar.on("dp.change", function(e) {
        var timestamp = Math.round(new Date(e.date._d).getTime()/1000);
        window.location.href = "/calendar/" + timestamp;
    });

    $('#schedule_event_form_startDate').datetimepicker({
        format: 'DD-MM-YYYY H:mm'
    });

    // клик по чекбоксу
    $('.iCheck-helper').on('click', function () {
        var input = $($(this).siblings()[0]);
        var url = input.data('url');
        
        $.ajax({
            type: "POST",
            url: url,
            success: function (data) {
                window.location = window.location.href;
            },
        });
    });
});