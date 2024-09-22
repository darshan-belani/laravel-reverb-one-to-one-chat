@extends('layouts.app')

@section('content')
    <div class="container">
        <input type="hidden" value="{{ auth()->user()->id  }}" class="sender_id">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <ol class="chat">
                    </ol>
                    <div class="typezone">
                        <div class="msg-bottom">
                            <div class="input-group">
                                <input type="text" class="form-control message-box" placeholder="Write message...">
                                <div class="input-group-append ">
                                    <button style="border: none;" class="send-button">
                                        <span class="input-group-text send-icon "><i class="bi bi-send "></i> </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>--}}

@endsection
@section('script')
    <script src="{{ asset('js/chat.js') }}"></script>
    <script>
        let receiver_id = "";
        let sender_id = $(".sender_id").val();

        // for realtime message
        document.addEventListener('DOMContentLoaded', function () {
            Echo.private('chat-message')
                .listen('.getChatMessage', (data) => {
                    if (sender_id != data.chat.sender_id) {
                        var messageData = '<li class="other">\n' +
                            '                 <div class="msg">\n' +
                            '                      <p>' + data.chat.message + '</p>\n' +
                            '                      <time>' + data.chat.created_at + '</time>\n' +
                            '                  </div>';
                        '               </li>';
                        $('.chat').append(messageData)
                        $('.chat').scrollTop($('.chat')[0].scrollHeight);
                    }
                })
        })
    </script>
@endsection

