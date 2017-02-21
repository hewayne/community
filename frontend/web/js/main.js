/*大屏幕自动展开menu*/
if($(window).width() > 1300){
    var menus = $(".menu-list a");
    var targetUp = 50;
    var speedUp = 50;
    menus.each(function () {
        menuAnimate($(this), 'bottom', '+', targetUp, speedUp);
        targetUp+=50;
        speedUp+=50;
    });
}


//当屏幕大于900时，导航按钮加大
if($(window).width() > 900){
    $('.top-menu').find('a').addClass('button-large');
}


/*menu按钮展示与隐藏*/
$('#menu-all').click(function () {
    var bottomValue = $('#menu-user').css('bottom');
    var menus = $(".menu-list a");

    if (bottomValue == '40px'){
        var targetUp = 50;
        var speedUp = 50;
        menus.each(function () {
            menuAnimate($(this), 'bottom', '+', targetUp, speedUp);
            targetUp+=50;
            speedUp+=50;
        });
        /*$('#menu-baike-dis').animate({right: '+=205px'}, 500);
        $('#menu-club-dis').animate({right: '+=255px'}, 600);
        $('#menu-hosp-dis').animate({right: '+=305px'}, 700);
        $('#menu-shop-dis').animate({right: '+=355px'}, 800);
        $('#menu-home-dis').animate({right: '+=405px'}, 900);*/
    }else {
        /*$('#menu-home-dis').animate({right: '-=405px'}, 500);
        $('#menu-shop-dis').animate({right: '-=355px'}, 600);
        $('#menu-hosp-dis').animate({right: '-=305px'}, 700);
        $('#menu-club-dis').animate({right: '-=255px'}, 800);
        $('#menu-baike-dis').animate({right: '-=205px'}, 900);*/
        var targetDown = 50;
        var speedDown = 0;
        menus.each(function () {
            menuAnimate($(this), 'bottom', '-', targetDown, speedDown);
            targetDown+=50; //此处需要使用+=，而不是-=
        });
    }
});

/*menu按钮展示与隐藏的方法*/
function menuAnimate(dom, attr, direction, target, speed) {
    var param = {};
    param[attr] = direction + '=' + target + 'px';
    $(dom).animate(param, speed);
}


/*添加标签*/
$("#tag-input").keydown(function (event) {
    if (event.which == 32){
        var tag = $.trim($("#tag-input").val());
        var tagsDiv = $(".create-tags");
        var baikeformTags = $("#baikeform-tags");
        if (tag != ''){     //输入的内容不能为空

            //将tag追加到实际发送的input中
            baikeformTags.val(baikeformTags.val() + tag + ',');

            //添加“可视”的标签
            tagsDiv.append("<span><i class='fa fa-tag'></i>&nbsp;&nbsp;" + tag + "&nbsp;&nbsp;<i class='fa fa-times tag-clear'></i></span>");     //将tag追加到显示给用户看的div中
            $(this).val("");        //清空用户输入的input框中的内容
        }
    }
});

/*create标签--->删除标签*/
$(".create-tags").on('click', '.tag-clear', function () {
    var tagText = $.trim($(this).parent().text());      //获取需要删除的span标签的内容
    var baikeformTags = $("#baikeform-tags");       //form表单中的input的元素

    var newBaikeformTags = (baikeformTags.val()).replace(tagText + ',', '');    //将被删除的标签替换为空
    baikeformTags.val(newBaikeformTags);        //将新的值赋给form表单中的input
    $(this).parent().remove();      //删除被点击的"可视"标签
});

/*给百科view中的img（从百度编辑器中获取）添加响应式class:img-responsive*/
$(".baike-content img").addClass('img-responsive');
$(".book-view img").addClass('img-responsive');
$(".book-index img").addClass('img-responsive');
$(".hosp-detail img").addClass('img-responsive');



/**
 * 搜索百科（通过关键字搜索）
 * */
$(".baike-search-btn").click(function () {
    var keyword = $(this).parent().parent().children('input').val();

    $.ajax({
        method: "GET",
        url: "index.php?r=baike/search",
        data: {keyword: keyword},
        dataType: "json",
        success: function (data) {
            var baikeSearchObj = $("#baike-search");
            if (data['err'] == 0){
                $(".no-data").remove();  //先移除已经存在的“没有相关数据”的提醒
                baikeSearchObj.children(".baike-item").remove();  //先移除baike-item
                baikeSearchObj.append('<h3 class="no-data">没有相关数据</h3>');
            }else {
                $(".no-data").remove();  //先移除“没有相关数据”的提醒
                baikeSearchObj.children(".baike-item").remove();  //移除已有的baike-item

                for (var i = 0; i < data.length; i++){
                    if (data[i]['label_img'] == ''){  //如果没有label_img，就使用默认的label_img
                        data[i]['label_img'] = '/image/20161201/1480554795557441.jpg';
                    }

                    baikeSearchObj.append('<div class="baike-item">' +
                        '<a href="index.php?r=baike/view&id='+data[i]['id']+' ">' +
                        '<h4>' + data[i]['title'] + '</h4>' +
                        '<img class="img-rounded" src="'+ data[i]['label_img'] +'" alt="baike-item-img">' +
                        '<div class="baike-summary">' +
                        '<p>' + data[i]['summary'] + '</p>...&nbsp;&nbsp;' +
                        '<span class="show-more">显示全部>>></span>' +
                        '</div><div class="clearfix"></div><hr></a></div>');
                }
            }
        }
    });

});


/**
 * 通过标签搜索（在relation_tags_baike中查询对应的标签数据）*/

$(".view-tag").on('click', 'button', function () {
    var tagId = $.trim($(this).children('.tag-id').text());

    $.ajax({
        method: "GET",
        url: "index.php?r=baike/search-by-tag",
        data: {tagId: tagId},
        dataType: "json",
        success: function (data) {
            var tagSearchObj = $("#tag-search-content");
            if (data['err'] == 0){
                $(".no-data").remove();  //先移除已经存在的“没有相关数据”的提醒
                tagSearchObj.children(".baike-item").remove();  //先移除baike-item
                tagSearchObj.append('<h3 class="no-data">没有相关数据</h3>');
            }else {
                $(".no-data").remove();  //先移除“没有相关数据”的提醒
                tagSearchObj.children(".baike-item").remove();  //移除已有的baike-item

                for (var i = 0; i < data.length; i++){
                    if (data[i]['label_img'] == ''){  //如果没有label_img，就使用默认的label_img
                        data[i]['label_img'] = '/image/20161201/1480554795557441.jpg';
                    }

                    tagSearchObj.append('<div class="baike-item">' +
                        '<a href="index.php?r=baike/view&id='+data[i]['id']+' ">' +
                        '<h4>' + data[i]['title'] + '</h4>' +
                        '<img class="img-rounded" src="'+ data[i]['label_img'] +'" alt="baike-item-img">' +
                        '<div class="baike-summary">' +
                        '<p>' + data[i]['summary'] + '</p>...&nbsp;&nbsp;' +
                        '<span class="show-more">显示全部>>></span>' +
                        '</div><div class="clearfix"></div><hr></a></div>');
                }
            }
        }
    });

});

$('.create-hosp-btn').click(function () {
    if (checkLogin()){
        location.href = 'index.php?r=hosp/edit';
    }
});

/*选择市、区*/
/*获取citys*/
function getCitys() {
    var provinceId = $('#province').val();
    if (provinceId){
        $.ajax({
            method: "GET",
            url: "index.php?r=hosp/get-city",
            data: {provinceId: provinceId},
            dataType: "json",
            success: function (data) {
                var options = '';
                for (var i = 0; i < data['cities'].length; i++){
                    options += '<option value="'+ data['cities'][i]["cityid"] +'">'+ data['cities'][i]["city"] +'</option>';
                }
                $('#city').children().remove();
                $('#city').append(options);
                getAreas();
            }
        });
    }
}

/*获取areas（区）*/
function getAreas() {
    var cityId = $('#city').val();
    if (cityId){
        $.ajax({
            method: "GET",
            url: "index.php?r=hosp/get-area",
            data: {cityId: cityId},
            dataType: "json",
            success: function (data) {
                //alert(data);
                //alert(data['areas'][0]['area']);
                var options = '';
                for (var i = 0; i < data['areas'].length; i++){
                    //alert(data['cities'][i]['city']);
                    options += '<option value="'+ data['areas'][i]["areaid"] +'">'+ data['areas'][i]["area"] +'</option>';
                }
                //alert(options);
                $('#area').children().remove();
                $('#area').append(options);
            }
        });
    }
}

/*搜索hosp*/
$('#search-hosp').click(function () {
    var values = [];
    var selectObjs = document.getElementsByTagName('select');
    for (var i = 0; i < selectObjs.length; i++){
        values[i] = selectObjs[i].value;
    }
    $.ajax({
        method: "GET",
        url: "index.php?r=hosp/search",
        data: {ids: values},
        dataType: "json",
        success: function (data) {
            $('#hosp-items').children().remove();
            if (data['area'] == null  && data['city'] == null){
                $('#hosp-items').append('<h4>没有相关区域的宠物店信息</h4>' +
                    '<span>是宠物店主？</span>' +
                    '<a target="_blank" style="margin: 10px auto;" href="index.php?r=hosp/create">添加宠物店信息</a>');
                return false;
            }

            if (data['area'] != null){
                var areaData = data['area'];
                _appendHosp(areaData);
            }

            if (data['city'] != null){
                var cityData = data['city'];
                _appendHosp(cityData);
            }
        }
    });

});



function _appendHosp(placeData) {
    for (var i=0; i<placeData.length; i++){
        $('#hosp-items').append('<div class="hosp-item">' +
            '<hr class="hr-10">' +
            '<a target="_blank" href="index.php?r=hosp/view&id='+ placeData[i]["id"] +'"><h4 style="font-size: 1.2em"><i class="fa fa-plus-square" style="color: red;"></i>&nbsp;&nbsp;'+ placeData[i]["hosp_name"] +'</h4></a>' +
            '<div class="row">' +
            '<div class="col-lg-5 col-md-5 col-sm-5">' +
            '<a target="_blank" href="index.php?r=hosp/view&id='+ placeData[i]["id"] +'"><img class="img-responsive" src="'+ placeData[i]["label_img"] +'" alt="hosp-img"></a>' +
            '</div>' +
            '<div class="col-lg-6 col-md-5 col-sm-5">' +
            '<p style="margin-top: 10px">' +
            '<span>地址：</span>&nbsp;&nbsp;'+ placeData[i]["addr"] +'&nbsp;&nbsp;' +
            '</p>' +
            '<hr class="hr-10">' +
            '<p><span>电话：</span>&nbsp;&nbsp;'+ placeData[i]['tel'] +'</p>' +
            '<hr class="hr-10">' +
            '<span class="f-left" style="width: 4em;">服务：</span>' +
            '<p class="f-left" style="width: 80%;">' + placeData[i]['server'] +
            '...&nbsp;&nbsp;<a target="_blank" href="index.php?r=hosp/view&id='+ placeData[i]["id"] +'" class="btn btn-default btn-xs">了解详情</a>' +
            '</p><div class="clearfix"></div></div></div>');
    }
}


/*使用eModal显示用户空间*/
$('.user').on('click', function () {
    if (checkLogin()){
        var title = '用户空间';
        return eModal
            .iframe('index.php?r=user/user-info', title)
            .then(function () {});
    }
});


/*------------------------------------打开、编辑、回复帖子（begin）-----------------------------------------------*/

/*打开：帖子编辑页面*/
$('.editer-template').click(function () {
    if (checkLogin()){
        //如果已经登录，就加载编辑页
        var title = '聊吧';
        return eModal
            .iframe('index.php?r=club/edit', title)
            .then(function () {});
    }
});


/*加载更多帖子*/
var page = 10;
$('.add-more-post').click(function () {
    $.ajax({
        url: 'index.php?r=club/get-post',
        method: 'GET',
        dataType: 'json',
        data: {page: page},
        success: function (res) {
            var html = '';
            var posts = res['posts'];

            for (var i = 0; i < posts.length; i++){
                var post = posts[i];
                html += '<div class="item-content">';
                html += '<a href="index.php?r=club/detail&id=' + post.id + '"  target="_blank">';
                html += '<img class="img-circle user-img" src="' + post.avatar + '" alt="avatar">';
                html += '<span><i class="fa fa-user"></i>&nbsp;&nbsp;' + post.username + '&nbsp;&nbsp;&nbsp;&nbsp;' + post.time + '</span>';
                html += '<h4>' + post['title'] + '</h4>';
                html += '<p class="summary-cont"><span class="ellipsis">&nbsp;• • •</span>' + post.content + '</p>';
                html += '<div class="row content-imgs">';
                if (post.pictures){
                    for (var j = 0; j < post.pictures.length; j++){
                        html += '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4"><img class="img-responsive" src="' + post.pictures[j] + '" alt="post-img"></div>';
                    }
                }
                html += '</div><div class="content-footer"><span><i class="fa fa-edit"></i>&nbsp;&nbsp;回复</span>';
                if (post.reply_num > 0){
                    html += '<span><i class="fa fa-commenting-o"></i>&nbsp;&nbsp;' + post.reply_num + '</span>';
                }
                if (post.browser > 0){
                    html += '<span><i class="fa fa-eye"></i>&nbsp;&nbsp;' + post.browser + '</span>';
                }
                html += '<div class="clearfix"></div></div></a></div>';
            }

            $('.club-content').append(html);
            page += 10;
        }


    });
});


//当回复的textarea获取焦点时，先判断是否登录
$('#reply-box').click(function () {
    checkLogin();  //判断是否登录
});

/*发送回复内容*/
$(".send-reply-btn").click(function () {
    if (checkLogin()){  //判断是否登录
        $.ajax({
            url: 'index.php?r=club/reply',
            method: 'post',
            dataType: 'json',
            data: {
                content: $('#reply-box').children('textarea').val(),
                postId: $('.post-id').text(),
                postUsername: $('.post-username').text(),
                postTitle: $('.post-title').text()
            },
            success: function (res) {
                if (res['static'] != 1){
                    alertMessage('发送失败！');
                }else {
                    alertMessage('发送成功！');
                    setTimeout(function () {
                        location.reload(true);
                    }, 2000);
                }
            }
        });
    }
});

/*------------------------------------打开、编辑、回复帖子（end）-----------------------------------------------*/





/*------------------------------------------二级、三级回复的显示、编辑、发送--begin-------------------------------------------*/

var replyItemObj = $('.reply-item');

/*添加二级回复(生成txtearea等信息)*/
$(".re-reply-btn").click(function () {
    if (checkLogin()){
        $(this).parent().parent().after(
            '<textarea class="form-control margin-top-10" rows="2" maxlength="150"></textarea>' +
            '<button class="btn btn-info btn-sm f-right margin-top-10 send-re-reply-btn" type="button"><i class="fa fa-paper-plane-o"></i>&nbsp;发送</button>' +
            '<div class="clearfix"></div>');
        $(this).parent().parent().next().focus();
    }
});

/*添加三级回复(生成txtearea等信息)*/
replyItemObj.on('click', '.rere-reply-btn', function () {
    if (checkLogin()){
        $userName = $(this).parent().find('.username').text();
        $(this).parent().after(
            '<textarea class="form-control margin-top-10" rows="2" maxlength="120"></textarea>' +
            '<button class="btn btn-info btn-sm f-right margin-top-10 send-re-reply-btn" type="button"><i class="fa fa-paper-plane-o"></i>&nbsp;发送</button>' +
            '<div class="clearfix"></div>'
        );
        $(this).parent().next().focus().val('回复 ' + $userName + ': ');
    }
});

//发送二级三级回复内容
replyItemObj.on('click', '.send-re-reply-btn', function () {
    $.ajax({
        url: 'index.php?r=club/re-reply',
        method: 'post',
        dataType: 'json',
        data: {
            replyId: $(this).parent().attr('replyid'),
            content: $(this).prev().val()
        },
        success: function (res) {
            if (res['static'] < 1){
                alertMessage('保存失败！');
            }else {
                alertMessage('发送成功！');
                setTimeout(function () {
                    location.reload(true);
                }, 2000);
            }
        }
    });
});


//获取二级三级回复内容
replyItemObj.on('click', '.re_reply_num', function () {
    var re_reply_numObj = $(this);
    $.ajax({
        url: 'index.php?r=club/get-re-reply',
        method: 'get',
        dataType: 'json',
        data: {replyId: re_reply_numObj.parent().parent().attr('replyid')},
        success: function (res) {
            var reReply = res['reReply'];
            var html = '';
            for (var i = 0; i < reReply.length; i++){
                var reply = reReply[i];
                html += '<div class="re-reply f-right">' +
                    '<a userid="'+ reply.user_id +'" username="' + reply.username + '" class="a-decoration to-userpage-btn">' +
                    '<img class="img-circle user-img" src="'+ reply.avatar +'" alt="avatar">' +
                    '<span class="margin-h-10 username">'+ reply.username +'</span></a>' +
                    '<span class="margin-h-10">'+ reply.ftime +'</span>' +
                    '<button class="btn btn-default btn-xs rere-reply-btn margin-h-10">回复</button>' +
                    '<p>'+ reply.content +'</p></div><div class="clearfix"></div>';
            }
            re_reply_numObj.parent().after(html);
        }
    });
});


/*------------------------------------------二级、三级回复的显示、编辑、发送--end-------------------------------------------*/



/*---------------------------用户信息begin----------------------------------*/

//点击club/index中的【消息】按钮，打开消息页 (使用eModal)
$('.message-btn').click(function () {
    var messageNumObj = $(this).children('span');
    if (messageNumObj.text() > 0){
        //如果有消息，就加载消息页
        var title = '消息';
        return eModal
            .iframe('index.php?r=user/message', title)
            .then(function () {
                messageNumObj.text(0);  //查看后将‘消息数量’该为0
            });
    }
});


//点击用户图像或用户名时，使用eModal弹出【用户主页】
$('.to-userpage-btn').click(function () {
    var userId = $(this).attr('userid');
    userpageEModal(userId);
});

replyItemObj.on('click', '.to-userpage-btn', function () {
    var userId = $(this).attr('userid');
    userpageEModal(userId);
});

function userpageEModal(userId) {
    var title = '用户主页';
    return eModal
        .iframe('index.php?r=user/userpage&userid=' + userId, title)
        .then(function () {});
}

/*---------------------------用户信息end----------------------------------*/


/*--------------------------------公共方法(begin)-----------------------------------*/

//获取指定的cookie的值
function getCookie(c_name)
{
    if (document.cookie.length>0)
    {
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1)
        {
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return ""
}

//判断是否登录,如果未登录则弹出提示框，否则返回true
function checkLogin() {
    if (!getCookie('isLogin')){
        alertLoginModal();
    }else {
        return true;
    }
}

//显示未登录的提示框
function alertLoginModal() {
    var alertOptions = {
        message: '<h3>你还未登录•••</h3><br>' +
        '<div class="f-right"><a class="btn btn-info btn-sm" href="index.php?r=site/login">登录</a>' +
        '&nbsp;&nbsp;&nbsp;&nbsp;或&nbsp;&nbsp;&nbsp;&nbsp;' +
        '<a class="btn btn-info btn-sm" href="index.php?r=site/signup">注册</a></div>',
        title: '提示信息：',
        size: 'lg',
        useBin: false
    };

    eModal.alert(alertOptions);
}

//使用eModal显示提示信息
function alertMessage(mes) {
    var alertOptions = {
        message: '<h3>' + mes + '</h3>',
        title: '提示信息：',
        size: 'lg',
        useBin: false
    };
    eModal.alert(alertOptions);
}

/*--------------------------------公共方法(end)-----------------------------------*/

















