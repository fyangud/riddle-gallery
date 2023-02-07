$(document).ready(function () {
    let leftArray = [];
    let topArray = [];
    const DIV_W = $(".riddle_content").val(0).width() / $(window).width() * 100;
    const DIV_H = $(".riddle_content").val(0).height() / $(window).height() * 100;
    const WIN_W = 100;
    const WIN_H = 150;
    let display_mode = "random";

    setGallery(display_mode);

    $("#random").click(function(){
        display_mode = "random";
        console.log(display_mode);
        setGallery(display_mode);
    });

    $("#by_time").click(function(){
        display_mode = "by_time";
        console.log(display_mode);
        setGallery(display_mode);
    });

    function setGallery(display){
        if(display === "random"){

            $(".lantern_fr").each(function(){
                $(this).css({"display":"", "grid-template-columns":"", "margin-left":"", "margin-right":""});
            });

            $(".riddle_content").each(function(){
                $(this).css({"position":"absolute", "margin":""});
                $(this).css({"top":"","left":"", "width":"10%"});
            });

            $(".riddle_content").each(function () {
                let check_count = 0;
                let randomTop = Math.floor(Math.random() * WIN_H);
                let randomLeft = Math.floor(Math.random() * (WIN_W*0.82 - DIV_W) + 0.09*WIN_W);

                while(!avoidCollision(randomTop, randomLeft) && check_count<=500){
                    randomTop = Math.floor(Math.random() * WIN_H);
                    randomLeft = Math.floor(Math.random() * (WIN_W*0.82 - DIV_W) + 0.09*WIN_W);
                    check_count ++;
                };

                leftArray.push(randomLeft);
                topArray.push(randomTop);
                //console.log(leftArray, topArray,check_count);
        
                $(this).css({
                    "top": randomTop + '%',
                    "left": randomLeft + '%'
                });

                /*$(this).hover(function() {
                    $(this).children(".show_riddle").show();
                },
                function(){
                    $(this).children(".show_riddle").hide();
                });

                $(this).click(function(){
                    $('#expand_'+$(this).attr('id')).show();
                });*/
            });
        }else{
            $(".lantern_fr").each(function(){
                $(this).css({"display":"grid", "grid-template-columns":"repeat(4, minmax(0, 1fr))", "margin-left":"5vw", "margin-right":"5vw"});
            });
            $(".riddle_content").each(function(){
                $(this).css({"position":"relative", "margin":"max(40px, 3vw)"});
                $(this).css({"top":"","left":"", "width":"50%"});
            });
        }
    }

    function avoidCollision(top, left){
        if(leftArray.length === 0){
            return true;
        }
        for(var i=0; i<topArray.length; i++){
            for(var j=0; j<leftArray.length; j++){
                if((topArray[i]-DIV_H) < top && top < (topArray[i]+DIV_H) && (leftArray[j]-DIV_W) < left && left < (leftArray[j]+DIV_W)){
                    return false;
                }
                continue;
            }
        }
        return true;
    }
});