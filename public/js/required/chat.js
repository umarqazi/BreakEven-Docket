var audio = new Audio(url+'application/assets/notification/intuition.mp3');
var socket  = io.connect(surl);
var timeout = '';
socket.emit('new user', user);

$(document).ready(function (){
	$('.chat-notification-icon').hide();
});

socket.on('get users',function(data){
    $.ajax({
        data : { ids : data },
        type : 'post',
        dataType : 'json',
        url : url+'chat/getOnlineUsers',
        success : function(response){
            var online  = response.online_users;
            var offline = response.offline_users;
            var html = "";
            for(i=0; i < online.length; i++ ){
                if(online[i]['id'] != user_id){
                    var name = online[i]['first_name']+ ' ' + online[i]['last_name'];
                    html += "<li class='list-group-item online-users' id='"+ online[i]['id'] +"'><span class='label " +
                        "label-success'></span><a " +
                        " onclick = 'getchat(" + online[i]['id'] +",\""+ name + "\")'>" + name +
                        "</a></li>";
                }
            }
            for(i=0; i < offline.length; i++ ){
                var name = offline[i]['first_name']+ ' ' + offline[i]['last_name'];
                html += "<li class='list-group-item offline-users' id='"+ offline[i]['id'] +"'><a " +
                    " onclick = 'getchat(" + offline[i]['id'] +",\""+ name + "\")'>" + name +
                    "</a></li>";

            }
            $('#listaOnline').html(html);
        }
    });


});

function timeoutFunction() {
    typing = false;
    socket.emit("typing", false);
}


$('#text-message').keyup(function() {
    clearTimeout(timeout);
    var room =  $('.chat_window').attr('id');
    typing = true;
    var username = $('#text-username').val();

    socket.emit('typing', username, room);
    timeout = setTimeout(timeoutFunction, 10000);
});

/*$('#text-message').blur(function() {
    clearTimeout(timeout);
	var room =  $('.chat_window').attr('id');
	typing = false;
	var username = $('#text-username').val();

	socket.emit('stop typing', username, room);
    timeout = setTimeout(timeoutFunction, 2000);
});*/

socket.on('server-typing', function(data) {

    if (data !=fname && data) {

        $('#type-message').text(data + " is typing...");
    } else {

        $('#type-message').text(" ");
    }
});
/*socket.on('stop-server-typing', function(data) {
        $('#type-message').text('');
});*/


function emptyForm(event){
    event.preventDefault();
}

function getchat(id, name)
{
    $('.chat_window .title').text(name);
    $('.messages li').remove();
    $('.chat_window').removeAttr('id');
    if(id != user.id){
        $.ajax({
            url 	: url+'chat/getUserConversation',
            data    : {user_id : id},
            type 	: 'POST',
            dataType: 'JSON',
            beforeSend: function()
            {

            },
            success: function(conversation)
            {
                if(conversation.length > 0){
                    $.each( conversation, function( key, value ) {
                        var $message;
                        var message_side = user_id == value.user_id ? 'right' : 'left';
                        var picture = user_id == value.user_id ? avatar : url+'uploads/'+ value.first_name + '_' + value.last_name + '_' + value.user_id + '/' + value.profile_pic;
                        var sender_name = value.first_name + ' ' + value.last_name;
                        $message = $($('.message_template').clone().html());
                        $message.addClass(message_side).find('.text').html(value.content);
                        $message.addClass('appeared');
                        $message.find('.avatar').css('background-image', 'url(' + picture + ')').attr("title",
                            value.first_name);
                        var avatar_name = get_avatar_name(sender_name);
                        $message.find('.avatar').text(avatar_name);
                        $('.messages').append($message);
                    });
                    $('.messages').animate({ scrollTop: $('.messages').prop('scrollHeight') }, 300);
                    $('#send_msg').attr('onsubmit','send_message('+ conversation[0].room_id + ',' + 0 + ',' + id
                        + ', event )');
                    $('.chat_window').attr('id', conversation[0].room_id );
                    if($('#listaOnline #'+ id).find('span.new_message').length !== 0){
                        $('#listaOnline #'+ id + ' span.new_message').remove();
                    }
                }else{
                    var len = 10;
                    var room_id = parseInt((Math.random() * 9 + 1) * Math.pow(10,len-1), 10);
                    $('#send_msg').attr('onsubmit','send_message('+ room_id + ',' + 1 + ',' + id + ', event)');
                    $('.chat_window').attr('id', room_id );
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }else{
        $('#send_msg').removeAttr('onsubmit');
    }
    return false;
}

function send_message(room, is_new , receiver_id, e)
{
    e.preventDefault();
    var name = $('.chat_window .title').text();
    var text = $('.message_input').val();
    if(text.length > 0){
        $.ajax({
            url 	: url+'chat/send',
            data    : {room : room , content : text, is_new : is_new, receiver : receiver_id },
            type 	: 'POST',
            dataType: 'JSON',
            beforeSend: function()
            {

            },
            success: function(message)
            {
                if(message.status)
                {
                    socket.emit('send:message', receiver_id , message);
                    $('.message_input').val('');
                    $('#send_msg').attr('onsubmit','send_message('+ room + ',' + 0  + ','
                        + receiver_id + ', event)');
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
        return false;
    }else{
        $('#empty_message').modal('show');
        setTimeout(function() {
                $('#empty_message').modal('hide');
            }, 1000
        );
    }
}

function selectusers(){
    $('#select_users').modal('show');
}

function getGroupConversation(room_id)
{
    $('.messages li').remove();
    $('.chat_window').removeAttr('id');
    $('#users_input').removeAttr('value');
    $.ajax({
        url 	: url+'chat/getThisRoomConversation',
        data    : {room_id : room_id},
        type 	: 'POST',
        dataType: 'JSON',
        beforeSend: function()
        {

        },
        success: function(response)
        {
            $('.chat_window .title').text(response['room'].room_name);
            if(response['chat'].length > 0){
                $.each( response['chat'] , function( key, value ) {
                    var $message;
                    var message_side = user_id == value.user_id ? 'right' : 'left';
                    var picture = user_id == value.user_id ? avatar : url+'uploads/'+ value.first_name + '_' + value.last_name + '_' + value.user_id + '/' + value.profile_pic;
                    var sender_name = value.first_name+' '+value.last_name;
                    $message = $($('.message_template').clone().html());
                    $message.addClass(message_side).find('.text').html(value.content);
                    $message.addClass('appeared');
                    $message.find('.avatar').css('background-image', 'url(' + picture + ')').attr('title', value.first_name);
                    var avatar_name = get_avatar_name(sender_name);
                    $message.find('.avatar').text(avatar_name);
                    $('.messages').append($message);
                });
                $('.messages').animate({ scrollTop: $('.messages').prop('scrollHeight') }, 300);
            }
            $('#send_msg').attr('onsubmit','sendGroupMessage('+ response['room'].room_id + ',' + 0 + ', event )');
            $('.chat_window').attr('id', response['room'].room_id );
            if($('#group_conversations .'+ response['room'].room_id).find('span.new_message').length !== 0){
                $('#group_conversations .'+ response['room'].room_id + ' span.new_message').remove();
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });
    return false;
}

$('#group_conversations .group_chats').hover(function(){
    $(this).find('ul.list_participents li').remove();
    var html = '';
    var room = $(this).find($('input[name=room_id]')).attr('value');
    $.ajax({
        data : {room_id : room },
        url  : url+'chat/getGroupParticipants',
        type : 'POST',
        dataType : 'JSON',
        success : function(response){
            if(response.length > 0){
                $.each( response, function( key, value ) {
                    var profile_img = url+'uploads/'+value.first_name+'_'+value.last_name+'_'+value.id+'/'+value.profile_pic;
                    html += '<li><div class="avatar" style="background-image: url('+profile_img+');"></div><a " ' +
                        '+"href="#">' + value.first_name + '</a></li>';
                });
                $('#group_conversations .' + room + ' ul.list_participents').html(html);
            }
        }
    })
});

function newGroupConversation(e){
    e.preventDefault();
    $('#select_users').modal('hide');
    var users = $('.select_users').val();
    if(users.length < 2){
        $('#multiple_users').modal('show');
        setTimeout(function() {
                $('#multiple_users').modal('hide');
            }, 2000
        );
        $('.select_users').val('').trigger('chosen:updated');
    }else{
        $('.messages li').remove();
        $.ajax({
            data : { 'users' : users },
            type : 'post',
            url  : url+'chat/checkGroupExists',
            dataType : 'json',
            success : function(conversation){
                if(conversation != null){
                    getGroupConversation(conversation.room_id);
                }else{
                    $('.select_users').attr('value','').trigger("chosen:updated");
                    var group_name = $('input[name="group_name"]').val();
                    $('.new_group_name').val('');
                    $('.chat_window .title').text(group_name);
                    $('.select_users').val('').trigger('chosen:updated');
                    var len = 10;
                    var room_id = parseInt((Math.random() * 9 + 1) * Math.pow(10,len-1), 10);
                    $('.chat_window').removeAttr('id').attr('id', room_id);

                    $.ajax({
                        data: {'users': users, 'room_id': room_id, 'room_name': group_name},
                        type: 'post',
                        url  : url+'chat/createGroup',
                        dataType : 'json',
                        success : function(result){
                            if (result['status']){
                                $('#send_msg').attr('onsubmit','sendGroupMessage('+ room_id + ',' + 0 + ', event)');
                                $('#send_msg #users_input').removeAttr('value').attr('value', users);
                                $('ul#group_conversations').prepend("<li class='list-group-item group_chats "+ room_id + "' " +
                                    "onclick = 'getGroupConversation("+ room_id +")'><input type='hidden' name='room_id' " +
                                    "value='"+ room_id +"'>" +
                                    "<span class='icon icon-chat'></span><div class='group-msg'><p>" + group_name + "<br> " +
                                    "<span class='message'>You started a new conversation</span></p></div><ul class='list_participents'></ul></li>");

                                socket.emit('send:groupCreation', result);
                            }
                        }
                    });
                }
            }
        });
    }
}

function sendGroupMessage(room_id, is_new, e ){
    e.preventDefault();
    var name = $('.chat_window .title').text();
    var text = $('.message_input').val();
    var room_details = {'room_id' : room_id, 'room_name' : name};
    if(is_new === 1){
        var users = $('#send_msg #users_input').val();
        users = JSON.parse('[' + users + ']');
    }else{
        var users = [];
    }
    if(text.length > 0){
        $.ajax({
            url 	: url+'chat/sendGroupMessage',
            data    : {room_details : room_details , content : text, is_new : is_new, users : users },
            type 	: 'POST',
            dataType: 'JSON',
            beforeSend: function()
            {

            },
            success: function(message)
            {
                if(message.status)
                {
                    socket.emit('send:groupmessage', message);
                    $('.message_input').val('');
                    $('#send_msg').attr('onsubmit','sendGroupMessage('+ message.room.room_id + ',' + 0 + ', event)');
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
        return false;
    }else{
        $('#empty_message').modal('show');
        setTimeout(function() {
                $('#empty_message').modal('hide');
            }, 1000
        );
    }
}

socket.on('message:GroupMessage', function(data){
    var room = data.room.room_id;
    var $message;
    if(user.id != parseInt(data.sender)){
        if(parseInt(data.is_new) == 1){
            $('#group_conversations').prepend("<li class='list-group-item group_chats "+ room + "' " +
                "onclick='getGroupConversation("+ room +")'><input type='hidden' name='room_id' value='"+ room +"'>" +
                "<span class='icon icon-chat'></span><div class='group-msg'><p>" + data.room.room_name + "<br> " +
                "<span class='message'>" + data.sender_name + " : " + data.content + "</span></p></div><ul class='list_participents'></ul></li>");
        }
        var message_side = 'left';
        audio.play();

		/* Show New Unread Message */
		$('.chat-notification-icon').show();

		// Display a toastr
		toastr.success(data.content, 'New Chat Message From: '+ data['sender_name'] + ' in Group: ' +data['room']['room_name'])
    }else{
        var message_side = 'right';
    }
    $('#group_conversations .'+ room + ' .message').text(data.sender_name + ' : ' + data.content );
    if($('#' + room).length != 0){
        $message = $($('.message_template').clone().html());
        $message.addClass(message_side).find('.text').html(data.content);
        $message.addClass('appeared');
        $message.find('.avatar').css('background-image', 'url(' + data.avatar + ')').attr('title', data.sender_name);
        var sender_name = data.sender_name+' '+data.last_name;
        var avatar_name = get_avatar_name(sender_name);
        $message.find('.avatar').text(avatar_name);
        $('.messages').append($message);
        $('.messages').animate({ scrollTop: $('.messages').prop('scrollHeight') }, 300);
        $.ajax({
            data : { room : room },
            type : 'POST',
            url  : url+'chat/updateSeenStatus'
        });
    }else{
        if(user.id != parseInt(data.sender)){
            if($('#group_conversations .'+ room).find('span.new_message').length == 0){
                $('#group_conversations .'+ room).append("<span class='badge highlight-color-green " +
                    "new_message'>New</span>");
            }
        }
    }
});

socket.on('message:GroupCreation', function(data){
    var room = data.room_id;
    var $message;
    if(user.id != data.sender_id){
        $('ul#group_conversations').prepend("<li class='list-group-item group_chats "+ data.room_id + "' " +
            "onclick = 'getGroupConversation("+ data.room_id +")'><input type='hidden' name='room_id' " +
            "value='"+ data.room_id +"'>" +
            "<span class='icon icon-chat'></span><div class='group-msg'><p>" + data.room_name + "<br> " +
            "<span class='message'>"+ data.sender_name + "started a new conversation</span></p></div><ul class='list_participents'></ul></li>");
    }
});

socket.on('message', function(data){
    var $message;
    var message_side;
    if(data.receiver == user.id){
        message_side = 'left';
        audio.play();

        /* Show New Unread Message */
		$('.chat-notification-icon').show();

		// Display a toastr
		toastr.success(data.content ,'New Chat Message From: '+ data['sender_name'])
	}else{
        message_side = 'right';
    }
    if($('#' + data.room).length != 0){
        $message = $($('.message_template').clone().html());
        $message.addClass(message_side).find('.text').html(data.content);
        $message.addClass('appeared');
        $message.find('.avatar').css('background-image', 'url(' + data.avatar + ')').attr('title', data.sender_name);
        var sender_name = data.sender_name+' '+data.last_name;
        var avatar_name = get_avatar_name(sender_name);
        $message.find('.avatar').text(avatar_name);
        $('.messages').append($message);
        $('.messages').animate({ scrollTop: $('.messages').prop('scrollHeight') }, 300);
    }else{
        if(data.receiver == user.id){
            if($('#listaOnline #'+ data.sender).find('span.new_message').length == 0){
                $('#listaOnline #'+ data.sender).append("<span class='badge highlight-color-green new_message'>New</span>");
            }
        }
    }

});

function get_avatar_name(name) {
    var matches = name.match(/\b(\w)/g);
    var acronym = matches.join('');
    return acronym;
}

