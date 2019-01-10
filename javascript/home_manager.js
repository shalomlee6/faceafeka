



function load(uid) {
    setUserFriendsList(uid);
    getRecentPosts();
}

function setUserFriendsList(uid) {
    $.post("../php/includes/get_friends_list.php",{uid:uid},function (friends) {
        $("#user_friends_list").html(friends)
    });

}

function showUnfriendBtn() {
    var unfriend_list = new Array();
    $('input[type=checkbox]').on('change', function() {
        if($(this).is(':checked')){
            unfriend_list.push($(this).val());
            console.log(unfriend_list.length);
            $("#unfriend_btn").show();
        }else{
            console.log(unfriend_list.length);
            if(unfriend_list.length <= 0){
                $("#unfriend_btn").hide();
            }

        }
    });
}

function unfriend(uid) {

    var unfriend_list = new Array();
    $("input:checkbox[name=friend_list_check_box]:checked").each(function(){
        unfriend_list.push($(this).val());

    });
    $.post("../php/includes/unfriend.php",{uid:uid,unfriend_list:unfriend_list},function () {
        $("#user_friends_list").html("")
        //refresh friends list
        setUserFriendsList(uid);
    });
}

function getFriends(query) {
    $("#added_friend").html("");
    $.post("../php/includes/get_find_friends_list.php",{query:query},function (data) {
        $("#find_friends_result").html(data);
    });
}

function addFriend(fid,uid) {
    $.post("../php/includes/add_friend.php",{fid:fid,uid:uid},function (data) {
        $("#added_friend").html(data);
        setUserFriendsList(uid);
    });
}

function getRecentPosts() {
    var uid=10;
    $.post("../php/includes/get_recent_posts.php",{uid:uid},function (data) {
        $("#feed").html(data);
    });
}

function uploadPost() {

    var form = document.getElementById("post_form");
    var data = new FormData(form);


    $.ajax( {
        type : "POST",
        url : "../php/includes/upload_post.php",
        //dataType: "json",
        //processData : false,
        contentType : 'multipart/form-data',
        data: data,
        success : function(data) {
            $("#data").html(data);
            getRecentPosts($("#u_idf"));
        },
        error: function (e) {
            console.error(e);
        }
    });
    console.log("send to php func");

}

function php() {
    $.post("../php/includes/bot_post.php",{},function (data) {
        $("#feed").html(data);
    });
}
