$(document).ready(function(){
    console.log($('.like'));

    $('.like').each(function(){
        $(this).on('click', function(){
            var postid = $(this).closest('.riddle_content').attr('id');
                $post = $(this);

            $.ajax({
                url: './riddle_gallery.php',
                type: 'post',
                data: {
                    'liked': 1,
                    'postid': postid
                },
                success: function(response){
                    $post.hide();
                    $post.next().show();
                    like_num = $post.next().next();
                    like_num.text(parseInt(like_num.text())+1);
                }
            });
        });
    });
});