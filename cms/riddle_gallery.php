<?php
require_once './includes/database-connection.php';
require_once './includes/functions.php';

//get all riddles in database
$sql = "SELECT r.id, r.riddle, r.answer, r.name, r.lantern_num, r.time,
               l.likes AS likes
        FROM riddles   AS r
   LEFT JOIN reaction  AS l   ON r.id = l.riddle_id";
$riddles  = pdo($pdo, $sql)->fetchAll();

//if click like, update data in database
if (isset($_POST['liked'])) {
    $postid = $_POST['postid'];
    $result = pdo($pdo, "SELECT * FROM reaction WHERE riddle_id = $postid");
    $row = $result->fetch();
    $n = $row['likes'] ?? 0;

    if($n === 0){
        pdo($pdo, "INSERT INTO reaction (riddle_id, likes) VALUES ($postid, 1)");
    }else{
        pdo($pdo, "UPDATE reaction SET likes = $n+1 WHERE riddle_id= $postid");
    }
    echo $n+1;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>First Full Moon Festival</title>
    <link rel="stylesheet" href="../src/style.css">
    <link rel="stylesheet" href="../src/style_gallery.css">
    <link rel="icon" href="../img/logo.svg">

    <!--JQuery-->
    <script type="text/javascript" src="../src/jquery.min.js.download"></script>
    <!--Google Fonts: Montserrat-->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap');
    </style>

    <script type="text/javascript" src="../src/gallery.js"></script>
    <script type="text/javascript" src="../src/like.js"></script>

</head>
<body>
    <div class="container">
        <div>
            <object data="../img/bottom_gallery.svg" class="background"></object>
            <object data="../img/moon_cloud.svg" class="moon"></object>
        </div>
        <div class="back">
            <a href="../index.php"><object data="../img/icons/back.svg" class="back_sign"></object>
            <div class="home underline"><h2>HOME</h2></div></a>
        </div>
        <div class="display_icon">
            <div id="random"><object data="../img/icons/gallery_random.svg" class="icon"></object></div>
            <div id="by_time"><object data="../img/icons/gallery_time.svg" class="icon"></object></div>
        </div>

        <div class="sky">
        <?php $RIDDLE_PER_PAGE = 8;
            while($riddles){ 
                //$RIDDLE_COUNT = count($riddles);
                $riddle_page = [];
                for($i = 0; $i<$RIDDLE_PER_PAGE; $i++){
                    array_push($riddle_page, array_pop($riddles));
                }?>
            <div class="parallax_group">
                <div class="lantern_bg"></div>
                <div class="lantern_bg2"></div>
            </div>
            <div class="lantern_fr">
                <?php foreach ($riddle_page as $row) { ?>
                <div class="riddle_content" id="<?= $row['id'] ?>">
                    <div class="show_lantern"><img src="../img/lanterns/lantern-0<?= $row['lantern_num'] ?>.png"><p class="lantern_name"><?= html_escape($row['name']) ?><p></div>
                    <div class="expand_riddle" id="expand_<?= $row['id'] ?>">
                        <p>
                            <?= html_escape($row['riddle']) ?><br>
                            <!--<?= html_escape($row['answer']) ?>-->
                            <small>--by <?= html_escape($row['name']) ?><br>
                            <?= format_date($row['time']) ?></small>
                        </p>
                        <div class="reaction">
                            <div class="like">
                                <object data="../img/icons/like.svg"></object>
                            </div>
                            <div class="liked" hidden>
                                <object data="../img/icons/liked.svg"></object>
                            </div>
                            <p><?php if($row['likes'] === null){
                                echo '0';
                            }else{
                                echo $row['likes'];
                            } ?></p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        <?php } ?>
        </div>
    </div>

    
</body>
</html>