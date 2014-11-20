
<html class="blank">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>动态图对比</title>
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
</head>
    <body>
        <h1>动态图对比<span class="tips">提示：可以按住"ctrl"和"+"键放大对比;可以在右边选择背景颜色</h1>
            <div class="container" id="container">
                
            </div>
           
            
            <script id="j-tmpl" type="text/template">         
            
                {{ for(var j=0;j<it[0].data.length;j++) { }}
                    <div class="imgcont clearfix">
                        {{ for(var i=0;i<it.length;i++) { }}
                            <div class="img">
                                <img src="{{=it[i].data[j].src}}"/>
                                <p>{{=it[i].desc}}</p>
                                <p>帧数：<strong>{{=it[i].data[j].num}}</strong>帧</p>
                                <p>大小：<strong>{{=it[i].data[j].size}}</strong>k</p>
                            </div>
                        {{ } }}
                    </div>

                {{ } }}
                
            
            </script>
            
            
            
        </div>
        <div class="color">
            <div class="blank"></div>
            <div class="white"></div>
            <div class="transparent"></div>
            <div class="red"></div>
            <div class="green"></div>
            <div class="blue"></div>
        </div>
        <div class="show">
            <div class="item">
                <input type="checkbox" id="check_gif" name="check_gif" checked="checked" data-to="1"/>
                <label for="check_gif">GIF</label>
            </div>
            <div class="item">
                <input type="checkbox" id="check_apng" name="check_apng" checked="checked" data-to="2"/>
                <label for="check_apng">apng</label>
                
            </div>
            <div class="item">
                <input type="checkbox" id="check_loss" name="check_loss" data-to="3"/>
                <label for="check_loss">apngloss1</label>
                
            </div>
            <div class="item">
                <input type="checkbox" id="check_apngloss" name="check_apngloss" data-to="4"/>
                <label for="check_apngloss">apngloss2</label>
                
            </div>


            
        </div>

        <script type="text/javascript" src="../js/jquery.min.js"></script>
        
        <script type="text/javascript" src="../js/apng-canvas.js"></script>
        <script type="text/javascript" src="../js/doT.js"></script>
        
        <script type="text/javascript">
        function getImageSize(url,callback) { 
            
            var xhr = new XMLHttpRequest();
            xhr.open('HEAD', url, true);
            xhr.onreadystatechange = function(){
              if ( xhr.readyState == 4 ) {
                if ( xhr.status == 200 ) {
                   
                  callback(xhr.getResponseHeader('Content-Length'))
                } 
              }
            };
            xhr.send(null);
        } 
        function showRow(index){
            $(".show .item:nth-child("+(index+1)+")").find("input").attr("checked","true");
            
            $(".imgcont .img:nth-child("+(index+1)+")").show();
            
        }
        function render(){
            APNG.ifNeeded(function() {
                for (var i = 0; i < document.images.length; i++) {
                    var img = document.images[i];

                    if (/\.png$/i.test(img.src)) APNG.animateImage(img);
                }
            });
            if(location.hash.replace("#","")==""){
                location.hash="#1234";
            }
            var hash=location.hash.replace("#","").split("");

            var nowhash=location.hash;
            $(".show input").removeAttr("checked");
            $(".imgcont .img").hide();
           
            for(var i=0;i<hash.length;i++){
                
                showRow(parseInt(hash[i])-1);
            }
            $(".color div").click(function(){
                $("html")[0].className="";
                $("html").addClass($(this)[0].className)
            });

            $(".show input").change(function(e){
                var id=parseInt($(this).attr("data-to"));
                
                if(this.checked){
                    $(".imgcont .img:nth-child("+id+")").show();
                    nowhash=nowhash+id;
                }else{
                    $(".imgcont .img:nth-child("+id+")").hide();
                    nowhash=nowhash.replace(id,"");
                }
                location.hash=nowhash;

            })
        }
        $(function(){
            var namepre1="image/dongtai/";
            var imgLength=10;
            var num=[16,6,30,30,17,12,30,12,30,12,10,10,10,12,18,11,25];
            
            var imgs=[{
                    name:"gif",
                    desc:"GIF",
                    ext:"gif",
                    data:[]
                },
                {
                    name:"apng",
                    desc:"无损APNG",
                    ext:"png",
                    data:[]
                },
                {
                    name:"loss",
                    desc:"有损压缩后合并",
                    ext:"png",
                    data:[]
                },
                {
                    name:"apngloss",
                    desc:"APNG有损压缩算法",
                    ext:"png",
                    data:[]
                }
            ]
            var total=0;
            for(var i=0;i<imgs.length;i++){
                for(var j=0;j<imgLength;j++){

                    imgs[i].data[j]={};
                    imgs[i].data[j].src="image/dongtai/"+imgs[i].name+"/"+(j+1)+"."+imgs[i].ext;
                    imgs[i].data[j].num=num[j];
                    getImageSize(imgs[i].data[j].src,(function(i,j){
                        return function(size){
                            imgs[i].data[j].size=(size/1024).toFixed(2);
                            total++;
                            if(total==imgLength*4){
                                var template=$("#j-tmpl").html();
                                $("#container").html(doT.template(template)(imgs));
                                render();
                            }
                        }

                    })(i,j));
                }
            }
           

        });
        
            
       
        // 模版

        </script>

</body>
</html>