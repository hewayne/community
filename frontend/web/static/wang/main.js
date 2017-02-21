var blogBucket = $('#blog-bucket').text();
var blogDomain = $('#blog-domain').text();

/**
 * Created by wayne on 2017/1/8.
 */
// 封装 console.log 函数
function printLog(title, info) {
    window.console && console.log(title, info);
}
// 初始化七牛上传
function uploadInit() {
    var editor = this;
    var btnId = editor.customUploadBtnId;
    var containerId = editor.customUploadContainerId;
    // 创建上传对象
    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',    //上传模式,依次退化
        browse_button: btnId,       //上传选择的点选按钮，**必需**
        uptoken_url: '/index.php?r=club/gettoken&bucket=' + blogBucket,
        //Ajax请求upToken的Url，**强烈建议设置**（服务端提供）
        // uptoken : '<Your upload token>',
        //若未指定uptoken_url,则必须指定 uptoken ,uptoken由其他程序生成
        // unique_names: true,
        // 默认 false，key为文件名。若开启该选项，SDK会为每个文件自动生成key（文件名）
        // save_key: true,
        // 默认 false。若在服务端生成uptoken的上传策略中指定了 `sava_key`，则开启，SDK在前端将不对key进行任何处理
        domain: blogDomain,
        //bucket 域名，下载资源时用到，**必需**
        container: containerId,           //上传区域DOM ID，默认是browser_button的父元素，
        max_file_size: '3mb',           //最大文件体积限制
        flash_swf_url: '../js/plupload/Moxie.swf',  //引入flash,相对路径
        filters: {
            mime_types: [
                //只允许上传图片文件 （注意，extensions中，逗号后面不要加空格）
                { title: "图片文件", extensions: "jpg,gif,png,bmp" }
            ]
        },
        resize: {	//重新设置图片大小
            width: 768,
            height: 768,
            quality: 70
        },
        max_retries: 2,                   //上传失败最大重试次数
        dragdrop: true,                   //开启可拖曳上传
        drop_element: 'editor-container',        //拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
        chunk_size: '4mb',                //分块上传时，每片的体积
        auto_start: true,                 //选择文件后自动上传，若关闭需要自己绑定事件触发上传
        init: {
            'FilesAdded': function(up, files) {
                plupload.each(files, function(file) {
                    // 文件添加进队列后,处理相关的事情
                    printLog('on FilesAdded');
                });
            },
            'BeforeUpload': function(up, file) {
                // 每个文件上传前,处理相关的事情
                printLog('on BeforeUpload');
            },
            'UploadProgress': function(up, file) {
                // 显示进度条
                editor.showUploadProgress(file.percent);
            },
            'FileUploaded': function(up, file, info) {
                // 每个文件上传成功后,处理相关的事情
                // 其中 info 是文件上传成功后，服务端返回的json，形式如
                // {
                //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                //    "key": "gogopher.jpg"
                //  }
                printLog(info);
                // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html

                var domain = up.getOption('domain');
                var res = $.parseJSON(info);
                var sourceLink = domain + res.key; //获取上传成功后的文件的Url
                printLog(sourceLink);
                // 插入图片到editor
                editor.command(null, 'insertHtml', '<img src="' + sourceLink + '" style="max-width:100%;"/>')
            },
            'Error': function(up, err, errTip) {
                //上传出错时,处理相关的事情
                printLog('on Error');
            },
            'UploadComplete': function() {
                //队列文件处理完毕后,处理相关的事情
                printLog('on UploadComplete');
                // 隐藏进度条
                editor.hideUploadProgress();
            }
            // Key 函数如果有需要自行配置，无特殊需要请注释
            //,
            // 'Key': function(up, file) {
            //     // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
            //     // 该配置必须要在 unique_names: false , save_key: false 时才生效
            //     var key = "";
            //     // do something with key here
            //     return key
            // }
        }
    });
    // domain 为七牛空间（bucket)对应的域名，选择某个空间后，可通过"空间设置->基本设置->域名设置"查看获取
    // uploader 为一个plupload对象，继承了所有plupload的方法，参考http://plupload.com/docs

}
// 生成编辑器
var editor = new wangEditor('baikeform-content');
// 普通的自定义菜单
editor.config.menus = [
    'bold',
    'underline',
    'italic',
    'strikethrough',
    'eraser',
    'forecolor',
    'bgcolor',
    '|',
    'quote',
    'fontfamily',
    'fontsize',
    'head',
    'unorderlist',
    'orderlist',
    'alignleft',
    'aligncenter',
    'alignright',
    '|',
    'link',
    'unlink',
    'table',
    'emotion',
    '|',
    'img',
    'location',
    '|',
    'undo',
    'redo',
    'fullscreen'
];

editor.config.customUpload = true;
editor.config.customUploadInit = uploadInit;
editor.create();


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
            tagsDiv.append("<span><span class='glyphicon glyphicon-tag'></span>&nbsp;&nbsp;" + tag + "&nbsp;&nbsp;<span class='glyphicon glyphicon-remove  tag-clear'></span></span>");     //将tag追加到显示给用户看的div中
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