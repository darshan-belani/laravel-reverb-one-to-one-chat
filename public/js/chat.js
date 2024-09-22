$(document).ready(function () {
    getMessage();
    var page = 1;

    function getMessage(append = false) {
        $.ajax({
            url: '/get-message',
            type: 'POST',
            data: {
                "page": page,
                "_token": $('.token').val()
            },
            success: function (response) {
                if (response.status == 200 && response.data.data.length > 0) {
                    if (!append) {
                        $('.chat').html('');
                    }
                    var data = response.data.data;
                    totalPages = response.totalPages;
                    data.forEach(function (message) {
                        var getMessage = '<li class="' + message.sender_type + '">' +
                            '<div class="msg">' +
                            '<p>' + message.message + '</p>' +
                            '<time class="time_date"> ' + message.created_at + ' </time>' +
                            '</div>' +
                            '</li>';
                        $('.chat').prepend(getMessage);
                    });
                    if (append) {
                        $('.chat').scrollTop($('.chat')[0].scrollHeight / 3);
                    } else {
                        $('.chat').scrollTop($('.chat')[0].scrollHeight);
                    }
                }
                loading = false;
            }
        });
    }

    // Detect scroll to top
    $('.chat').scroll(function () {
        if ($(this).scrollTop() == 0 && !loading) {
            if (parseInt(totalPages) != parseInt(page)) {
                loading = true;
                page++;
                getMessage(true);
            }
        }
    });


    // Send message event
    $(".send-button").click(function () {
        const message = {
            sender_id: $(".sender_id").val(),
            receiver_id: receiver_id,
            message: $(".message-box").val(),
        };
        $.ajax({
            url: '/send-message',
            type: 'post',
            data: message,
            success: function (response) {
                if (response.status == 200)
                    var messageData = '<li class="self">\n' +
                        '              <div class="msg">\n' +
                        '              <p>' + response.data.message + '</p>\n' +
                        '              <time>' + response.data.created_at + '</time>\n' +
                        '               </div>';
                '          </li>';
                $('.message-box').val('')
                $('.chat').append(messageData)
                $('.chat').scrollTop($('.chat')[0].scrollHeight);
            }
        });
    });
})
