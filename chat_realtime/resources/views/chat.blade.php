<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card chat-app">
            <div id="plist" class="people-list">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
                <ul class="list-unstyled chat-list mt-2 mb-0">
                        {{-- <li class="clearfix">
                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                            <div class="about">
                                <div class="name">Vincent Porter</div>
                                <div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>                                            
                            </div>
                        </li> --}}
                    <li class="clearfix active">
                        <img src="https://photo2.tinhte.vn/data/attachment-files/2021/02/5330309_8mKz2RnV2.jpg" alt="avatar">
                        <div class="about">
                            <div class="name">Động bàn tơ</div>
                            <div class="status"> <i class="fa fa-circle online"></i> online </div>
                        </div>
                    </li>
                
                </ul>
            </div>
            <div class="chat">
                <div class="chat-header clearfix">
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                <img src="https://photo2.tinhte.vn/data/attachment-files/2021/02/5330309_8mKz2RnV2.jpg" alt="avatar">
                            </a>
                            <div class="chat-about">
                                <h6 class="m-b-0">Động bàn tơ</h6>
                                <small>Last seen: 2 hours ago</small>
                            </div>
                        </div>
                        <div class="col-lg-6 hidden-sm text-right">
                            <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                            <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                            <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
                            <a href="/logout" class="btn btn-outline-danger"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="chat-history" id="content" >
                    <ul class="m-b-0">
                        @if (isset(Auth::user()->id))
                            
                        <input type="hidden" id="name" value="{{ Auth::user()->name }}">
                        <input type="hidden" id="id" value="{{ Auth::user()->id }}">
                            
                        @endif

                        
                    </ul>
                </div>
                <div class="chat-message clearfix">
                    <div class="input-group mb-0">
                        <input id="message" type="text" class="form-control" placeholder="Enter text here...">   
                        <div class="input-group-prepend">
                            <button class="input-group-text"><i class="fa fa-send"></i></button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
@vite('resources/js/app.js')
<script>
    $(function(){
        const Http = window.axios;
        const Echo = window.Echo;
        const name = window.$("#name");
        const id = window.$("#id");
        const message = window.$("#message");
        var today = new Date();
        var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
        var time = today.getHours() + ":" + today.getMinutes();

        $("input").keyup(function(){
            $(this).removeClass('is-invalid');
        });

        $('button').click(function(){
            if(message.val() == ''){
                message.addClass('is-invalid');
            } else {
                Http.post("{{ url('send') }}", {
                    'id': id.val(),
                    'name': name.val(),
                    'message': message.val()
                }).then(() => {
                    message.val('');
                });
            }
        });

        let channel = Echo.channel('channel-chat');
        channel.listen('ChatEvent', function(data){
            $('#content').append(
            data.message.id == id.val() ? `
            <li class="clearfix" style="display: block">
                            <div class="message-data text-right">
                                <span class="name">${data.message.name}</span>
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar"><br>
                                <span class="message-data-time" style="font-size: 13px">${date + ',(' + time + ')'}</span>
                                
                            </div><div style="float:right; background-color: lightblue; padding: 10px 20px; border-radius: 5px; max-width:300px">${data.message.message} </div></div>
                        </li>
                        `
                        :
                        `
                        <li class="clearfix" style="display: inline-block;"
                            <div class="message-data" style="margin-top:10px">
                                <span class="name" >${data.message.name}</span>
                                <img style="float: left;" src="https://bootdey.com/img/Content/avatar/avatar7.png" width="40" alt="avatar"><br>
                                <span class="message-data-time" style="font-size: 13px">${date + ',(' + time + ')'}</span><br>
                            </div>
                        </div><div style="float:left; background-color: lightgray; padding: 10px 20px; border-radius: 5px; max-width:300px; margin-top: 10px">${data.message.message} </div></div>                                    
                        </li>  
                        `)
            })
        
    })
</script>
</body>

</html>
