@extends('layouts.app')

@section('content')
    <div class="container">
        <input type="hidden" value="{{ auth()->user()->id  }}" class="sender_id">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <ol class="chat">
                        @foreach($messages as $key => $value)
                        <li class ="{{ auth()->user()->id != $value->receiver_id && auth()->user()->id == $value->sender_id ? 'self' : 'other' }}">
                            <div class="msg">
                                <p>{{$value->message}}</p>
                                <time>{{ $value->created_at->format('h:m a') }}</time>
                            </div>
                        </li>
                        @endforeach

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        let receiver_id = "";
        let sender_id = $(".sender_id").val();

        $(document).on('click', '.send-button', function(e) {
            const message = {
                "_token": "{{ csrf_token() }}",
                sender_id: $(".sender_id").val(),
                receiver_id: receiver_id,
                message: $(".message-box").val(),
            };
            $.ajax({
                url: '{{ route('chat.send') }}',
                type: 'post',
                data: message,
                success: function(response){
                    if(response.status == 200)
                    var messageData = '<li class="self">\n' +
                            '              <div class="msg">\n' +
                                '              <p>'+ response.data.message+'</p>\n' +
                                '              <time>'+ response.data.created_at+'</time>\n' +
                            '               </div>';
                            '          </li>';
                    $('.message-box').val('')
                    $('.chat').append(messageData)
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            Echo.private('chat-message')
                .listen('.getChatMessage', (data) => {
                    if (sender_id != data.chat.sender_id)  {
                        var messageData = '<li class="other">\n' +
                            '                 <div class="msg">\n' +
                            '                      <p>'+ data.chat.message+'</p>\n' +
                            '                      <time>'+ data.chat.created_at+'</time>\n' +
                            '                  </div>';
                            '               </li>';
                        $('.chat').append(messageData)
                    }
                })
            })
    </script>
@endsection
