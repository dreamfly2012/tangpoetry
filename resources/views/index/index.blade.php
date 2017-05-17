<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <link rel="shortcut icon" href="favicon.ico" />
        <link rel="bookmark" href="favicon.ico" type="image/x-icon"　/>
        <title>唐诗千百首</title>
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/component.css" />
        <link rel="stylesheet" href="css/buttons.css" />
        <style>
            .m-artical-action-mid{
                position: fixed;
                width: 100%;
                height: 40%;
                top: 30%;
                z-index: 9998;
            }
        </style>
    </head>
    <body>
        <!--中间点击层-->
        <div class="m-artical-action">
            <div class="m-artical-action-mid" id="action_mid"></div>
        </div>
        <!--顶部导航-->
        <div class="nav-top" id="nav_top" style="display: none;">
            <div class="nav_container" id="nav_return">
                <div class="nav_return"></div>
                <div class="nav_text">返回</div>
            </div>
        </div>
        <!--主体内容-->
        <div class="container">
            <div class="Content">
                
            </div>
            <div class="page_btn">
                <button class="btn-prev" id="btn_prev">上一页</button>
                <button class="btn-next" id="btn_next">下一页</button>
            </div>
        </div>

        <!--底部导航栏    -->
        <div class="nav-bottom" id="nav_bottom" style="display: none;">
            <div class="btn-search">
                <div class="div_search">
                    <div class="icon_search search"> </div>
                    <div class="text_search search">检索</div>
                </div>
            </div>
            <div class="btn-mulu">
                <div class="mulu">
                    <div class="icon_mulu relation"> </div>
                    <div class="text_mulu relation">类似</div>
                </div>
            </div>
            <div class="btn_Aa">
                <div class="Aa">
                    <div class="icon-Aa icon_Aa"> </div>
                    <div class="text_Aa icon_Aa">字体</div>
                </div>
            </div>
            <div class="btn-yejian">
                <div class="yejian">
                    <div class="icon-yejian icon_yejian"> </div>
                    <div class="text_yejian icon_yejian">夜间</div>
                </div>
            </div>
         </div>   
            <!--字体功能栏-->
        <div class="fontPop" id="font_Pop" style="display: none;">
            <div class="fontSize">
                <span>字号</span>
                <button class="btnBig" id="btn_Big">大</button>
                <button class="btnSmall" id="btn_Small">小</button>
            </div>
            <div class="fontBk">
                <span>背景</span>
                <div class="bkColor">
                    <div class="bk-container" style="background-color: #f7eee5;">
                        <div id="mb"><span >    米白  </span></div>
                    </div>
                    <div class="bk-container" style="background-color: #e9dfc7;">
                        <div id="zz"><span >    纸张  </span></div>
                    </div>
                    <div class="bk-container" style="background-color: #a4a4a4;">
                        <div id="qh"><span >    浅灰  </span></div>
                    </div>
                    <div class="bk-container" style="background-color: #cdefce;">
                        <div id="hy"><span >    护眼  </span></div>
                    </div>
                    <div class="bk-container" style="background-color: #283548;">
                        <div id="hl"><span >    海蓝  </span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu_Pop" id="menu_Pop" style="display:none;">
            <ul id="relate_container">
                <li>诗人其他诗词</li>
            </ul>
        </div>
        <div class="search_Pop" id="search_Pop" style="display:none;">
            <span class="input input--hoshi">
                <input class="input__field input__field--hoshi" type="text" id="keyword" />
                <label class="input__label input__label--hoshi input__label--hoshi-color-1" for="keyword">
                    <span class="input__label-content input__label-content--hoshi">关键词</span>
                </label>
            </span>
            <a href="javascript:;" class="button button-3d button-action button-pill" id="search">检索</a>
            <div class="search_result"></div>
        </div>
       
        
        <script type="text/javascript" src="js/jquery.min.js" ></script>
        <script type="text/javascript" src="js/jquery.jsonp.js" ></script>
        <script type="text/javascript" src="js/jquery.base64.js" ></script>
        <script>
        var Dom={
            font_Pop: $("#font_Pop"),
            nav_top:$("#nav_top"),
            menu_Pop:$('#menu_Pop'),
            search_Pop:$('#search_Pop'),
            nav_bottom:$("#nav_bottom"),
            nav_return:$('#nav_return'),
            body:$("body"),
            win:$(window),
            icon_yejian:$(".icon_yejian"),
            icon_Aa:$(".icon_Aa"),
            btn_Big:$("#btn_Big"),
            btn_Small:$("#btn_Small")
        }
        
        var Util=(function(){//封装的本地存储和json数据解析
            var prefix = 'function_reader_';
            var StorageGetter = function(key){
                return localStorage.getItem(prefix + key);
            }
            var StorageSetter = function(key,val){
                return localStorage.setItem(prefix+key,val);
            }
            return{
                StorageGetter:StorageGetter,
                StorageSetter:StorageSetter
            }
        })();

        var refresh = function(id){
            Util.StorageSetter('current_id',id);
            window.location.reload();
        }

        var RenderRelateContent = function(content,data){
            if(data==''){
                var html="<li>诗人不存在诗词</li>";
                content.html(html);
            }else{
                var html = '';
                for(i=0;i<data.length;i++){
                    html+="<li><a href='javascript:refresh("+data[i].id+")'>"+ data[i].title +"</a></li>";
                }
                content.html(html);
            }
        }

        var RenderContent = function(container,data){
            //渲染诗词内容
            if(data==''){
                var html="<h4>诗词不存在</h4>";
                html+="<p>请重新检索</p>";
                container.html(html);
            }else{
                var html="<h4>" + data[0].title + "</h4>";
                html+="<p>"+data[0].content+"</p>";
                container.html(html);
            }
            
        }

        var getRandomPoetryInfo=function(){
            //获取随机古诗信息
            $.get('api/poetry?id=random',function(data){
                if(data.result==0){
                    Util.StorageSetter('poetid', data.data[0].poet_id);
                    Util.StorageSetter('current_id', data.data[0].id);
                    RenderContent(RootContainer, data.data);
                }else{
                    RenderContent(RootContainer, '');
                }
            },'json');
        };

        var getRelatePoetry = function(poetid) {
            //获取诗人其他诗词
            $.get('api/poetry_relate?poetid='+poetid,function(data){
                if(data.result==0){ 
                    RenderRelateContent(relateContainer, data.data);
                }else{

                }
            },'json');
        }
            
        var getCurPoetryInfo=function(poetry_id){
            //获取当前poetry_id唐诗详细信息
            $.get('api/poetry?id='+poetry_id,function(data){
                if(data.result == 0){
                    Util.StorageSetter('poetid',data.data[0].poet_id);
                    Util.StorageSetter('current_id',data.data[0].id);
                    RenderContent(RootContainer,data.data);
                }else{
                    RenderContent(RootContainer,'');
                }
            },'json');
        };
        
        var prvePoetry=function(){//上一页                
            $poetry_id = parseInt(Util.StorageGetter('current_id'))-1;
            $.get('api/poetry?id=' + $poetry_id, function(data){
                if(data.result==0){
                    Util.StorageSetter('poetid',data.data[0].poet_id);
                    Util.StorageSetter('current_id',data.data[0].id);
                    RenderContent(RootContainer,data.data);
                }else{
                    RenderContent(RootContainer,'');
                }
            },'json');
        };


        var nextPoetry=function(){//下一页
            $poetry_id = parseInt(Util.StorageGetter('current_id'))+1;
            $.get('api/poetry?id=' + $poetry_id, function(data){
                if(data.result==0){
                    Util.StorageSetter('poetid',data.data[0].poet_id);
                    Util.StorageSetter('current_id',data.data[0].id);
                    RenderContent(RootContainer,data.data);
                }
            },'json');
        };
            
        //背景颜色 存储记录
        var bkgroundcolor=Util.StorageGetter("bkgroundcolor");
        var bkCurrColor=Util.StorageGetter("bkgroundcolor");
        Dom.body.css('background-color',bkgroundcolor);
        //字号大小 设置存储记录
        var InitFontSize;
        InitFontSize=Util.StorageGetter("font_size");
        InitFontSize= parseInt(InitFontSize);
        if (!InitFontSize) {
            InitFontSize = 18;
        }
        $("p").css('font-size',InitFontSize);
        
        
        
        //数据层的初始化
        var RootContainer = $('.Content');
        var relateContainer = $('#relate_container'); 
        //渲染数据

        if(Util.StorageGetter('current_id')==null){
            getRandomPoetryInfo();
        }else{
            var current_id = Util.StorageGetter('current_id');
            getCurPoetryInfo(current_id);
        }
        

        //业务事件的初始化
        EventHandler();
        
        function EventHandler(){//业务事件处理层
            //点击主体中间事件
            $("#action_mid").click(function(){
                if(Dom.nav_top.css('display')=="none"){
                    Dom.nav_top.show();
                    Dom.nav_bottom.show();
                }else{
                    Dom.nav_top.hide();
                    Dom.nav_bottom.hide();
                    Dom.font_Pop.hide();
                    Dom.icon_Aa.css('border','');
                    Dom.icon_yejian.css('border','');
                }
            });
            //点击字体事件
            $(".btn_Aa").click(function(){
                if (Dom.font_Pop.css('display') == 'none') {
                    Dom.icon_Aa.css('border','1px solid #FF7800');
                    Dom.font_Pop.show();
                } else{
                    Dom.icon_Aa.css('border','');
                    Dom.font_Pop.hide();
                }
            });
            //点击类似
            $('.relation').click(function(){
                if (Dom.menu_Pop.css('display') == 'none') {
                    var poetid = Util.StorageGetter('poetid');
                    getRelatePoetry(poetid);
                    Dom.menu_Pop.show();
                } else {
                    Dom.menu_Pop.hide();
                }
            });
            //点击检索
            $('.search').click(function(){
                if (Dom.search_Pop.css('display') == 'none') {
                    Dom.search_Pop.show();
                } else {
                    Dom.search_Pop.hide();
                }
            });
            //点击搜索button
            $('#search').click(function(){
                var keyword = $('#keyword').val();
                $.get('api/search?keyword='+keyword,function(data){
                    if(data.result==0){ 
                        if(data.data==''){
                            var html="<li>诗人,诗词不存在</li>";
                            $('.search_result').html(html);
                        }else{
                            var html = '';
                            for(i=0;i<data.data.length;i++){
                                html+="<li><a href='javascript:refresh("+data.data[i].id+")'>"+ data.data[i].title +"</a></li>";
                            }
                            $('.search_result').html(html);
                        }
                    }else{

                    }
                },'json');
            });
            //点击夜间事件
            $(".btn-yejian").click(function(){
                if (Dom.body.css('background-color')!="rgb(40, 53, 72)") {
                    bkCurrColor='#283548';
                    //$(".bkColor").find('.bk-container-current')[0].className='';
                    Dom.body.css('background-color',bkCurrColor);
                    Dom.icon_yejian.css('border','1px #FF7800 solid');
                    Dom.icon_yejian.removeClass('icon-yejian').addClass('icon-baitian');
                    $('.text_yejian').text('白天');
                    $("#hl").addClass('bk-container-current');
                    
                } else{
                    bkCurrColor='#e9dfc7';
                    Dom.body.css('background-color',bkCurrColor);
                    Dom.icon_yejian.css('border','');
                    Dom.icon_yejian.removeClass('icon-baitian').addClass('icon-yejian');
                    $('.text_yejian').text('黑夜');
                    $("#hl").removeClass('bk-container-current');
                    $("#mb").addClass('bk-container-current');
                }
                Util.StorageSetter("bkgroundcolor",bkCurrColor);
            });
            //滚动条事件
            Dom.win.scroll(function(){
                Dom.nav_top.hide();
                Dom.nav_bottom.hide();
                Dom.font_Pop.hide();
                Dom.icon_Aa.css('border','');
                Dom.icon_yejian.css('border','');
            })
            //点击 大、小事件
            Dom.btn_Big.click(function(){
                if(InitFontSize>=20){
                    return;
                }
                InitFontSize+=1;
                console.log(InitFontSize);
                $("p").css('font-size',InitFontSize);
                Util.StorageSetter("font_size",InitFontSize);
            });
            Dom.btn_Small.click(function(){
                if(InitFontSize<=12){
                    return;
                }
                InitFontSize-=1;
                console.log(InitFontSize);
                $("p").css('font-size',InitFontSize);
                Util.StorageSetter("font_size",InitFontSize);
            });
            //返回首页
            $('#nav_return').bind('click',function(){
                window.location.href = '/tangpoetry/public/';
            });

            //点击背景颜色切换
            $(".bk-container").bind('click',function(){
                if ($(".bkColor").find('.bk-container-current').length>0) {
                    $(".bkColor").find('.bk-container-current')[0].className='';
                } else{
                    
                }
                var id= this.firstElementChild.id;
                $("#"+id).addClass('bk-container-current');
                
                switch (id){
                    case 'mb':
                    Dom.body.css('background-color','#f7eee5');
                        break;
                        case 'zz':
                    Dom.body.css('background-color','#e9dfc7');
                        break;
                        case 'qh':
                    Dom.body.css('background-color','#a4a4a4');
                        break;
                        case 'hy':
                    Dom.body.css('background-color','#cdefce');
                        break;
                        case 'hl':
                    Dom.body.css('background-color','#283548');
                        break;
                    default:
                        break;
                }
            Util.StorageSetter("bkgroundcolor",Dom.body.css('background-color'));
            });
            
            $("#btn_prev").click(function(){
                prvePoetry();
            });
            
            $("#btn_next").click(function(){
                nextPoetry();
            });
        }
        </script>
    </body>

</html>