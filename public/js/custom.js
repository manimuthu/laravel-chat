var Gobj, Guser;
var alreay_added_chats = new Array()
$(document).ready(function(){
    
    $(".chat_list").each(function(){
        uids = $(this).attr('data-id')
        alreay_added_chats[uids] = uids
    })
})

$(document).on("click", ".msg_send_btn", function(){
    // to_user  = $("#to_id").val();
    text_msg = $(".message").val();
    text_msg = text_msg.trim();
    chat_id = $("#chat_id").val();

    if(text_msg=="") return false;
    $.ajax({
        url: "chats/store",
        type: "post",
        async: false,
        data: {
            to_id: Guser,
            message: text_msg,
            chat_id: chat_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (result) {
            chat_id = result.id
            $(".chat_id").val(chat_id)
            fetchAllChats();
            $(".message").val('');
        },
    });

    $(Gobj).attr('onclick','fetchUserChat(this, '+chat_id+', '+Guser+')')
    
    // console.log("Height: "+$('.message_container').height())
    $('.msg_history').scrollTop( $('.message_container').height() )
})

function fetchAllChats()
{
    chat_id = $("#chat_id").val();
    if(!chat_id)
    {
        chat_id = 0;
    }
    $.ajax({
        url: "chats/fetch-all",
        type: "post",
        async: false,
        data: {
            chat_id: chat_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (result) {
            messages = result.html
            new_user_chats = result.chats
            $(".message_container").html(messages)
            fetchNewUserChat(new_user_chats)
        },
    });

    // $('.msg_history').scrollTop( $('.message_container').height() )
}

function fetchNewUserChat(chats)
{
    
    uids = ""
    for (let key in chats) 
    {
    uids = chats[key].uid
    names = chats[key].name
    chat_id = chats[key].chat_id

        if(!alreay_added_chats[uids])
        {
            alreay_added_chats[uids] = uids;

            html = `<div class="chat_list" data-id=`+uids+`>
                <div class="chat_people">
                <div class="chat_ib">
                    <h5 class='' onclick="fetchUserChat(this,'`+chat_id+`','`+uids+`')">`+names+`</h5>
                </div>
                </div>
            </div> `
            $(".inbox_chat").append(html)
        }
    }
    // if(!alreay_added_chats[uids])
    // if(uids)
    // $('.chat_list[data-id="'+uids+'"] h5').click()
    
}

function fetchUserChat(obj, chat_id='', user_id)
{
    Gobj = obj
    Guser= user_id
    $("#chat_id").val(chat_id)
    fetchAllChats();
    if(!chat_id)
    $(".message_container").html('')
    $(".type_msg").show()
}  

function createGroupChat()
{ 
    $(".chat_list").each(function(){
        uids = $(this).attr('data-id')
        alreay_added_chats[uids] = uids
    })
    uids = ""
    names = ""

    $('#group_users_list :selected').each(function(){

        uids+=$(this).val()+","
        names+=$(this).text()+","

    });
    if(!uids)
    {
        alert("Select Member to chat")
        return 0;
    }

    uids = uids.slice(0, -1)
    names = names.slice(0, -1)

    if(!alreay_added_chats[uids])
    {
    alreay_added_chats[uids] = uids;
    html = `<div class="chat_list" data-id=`+uids+`>
        <div class="chat_people">
        <div class="chat_ib">
            <h5 class='' onclick="fetchUserChat(this,0,'`+uids+`')">`+names+`</h5>
        </div>
        </div>
    </div> `
    $(".inbox_chat").append(html)
    }
    $('.chat_list[data-id="'+uids+'"] h5').click()
    $(".close").click()
}

setInterval(() => {
    fetchAllChats()
}, 3000);
