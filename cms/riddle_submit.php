<?php
require_once './includes/database-connection.php';
require_once './includes/functions.php';

$riddle = [
    'riddle' => '',
    'answer' => '',
    'name' => '',
    'lantern_num' => 1,
];
$errors = [
    'warning' => '',
];
$success = $_GET['success'] ?? null; //might not work in php7

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //check if valid
    $invalid = false;
    $riddle['riddle'] = $_POST['riddle'];
    $riddle['answer'] = $_POST['answer'];
    $riddle['name'] = $_POST['name'];
    $riddle['lantern_num'] = intval($_POST['lantern_num']);

    //if valid then update database
    if(false){
        $errors['warning'] = 'Please correct the errors below.';
    }else{
        $arguments = $riddle;
        try{
            $pdo->beginTransaction();
            $sql = "INSERT INTO riddles(riddle, answer, name, lantern_num, time)
                        VALUES (:riddle, :answer, :name, :lantern_num, now())";
            pdo($pdo, $sql, $arguments);
            $pdo->commit();
            redirect('riddle_submit.php', ['success' => 'riddle saved']);
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
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
    <link rel="stylesheet" href="../src/style_riddle_submit.css">
    <link rel="icon" href="../img/logo.svg">

    <!--Google Fonts: Montserrat-->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap');
    </style>

</head>
<body>
    <div class="container">
        <div class="back">
            <a href="../index.php"><object data="../img/icons/back_dark.svg" class="back_sign"></object>
            <div class="home underline"><h2>HOME</h2></div></a>
        </div>
        <form action="riddle_submit.php" method="post" enctype="multipart/form-data" class="form">
            <?php if(!$success){ ?>
            <div class="lantern_slider">
                <label class="lantern_offset" for="lantern_num"><h2>Select A Lantern</h2></label>
                <div class="lantern_offset image_slider">
                    <input type="radio" name="lantern_num" id="lantern_1" value="1" checked="checked"/>
                    <input type="radio" name="lantern_num" id="lantern_2" value="2"/>
                    <input type="radio" name="lantern_num" id="lantern_3" value="3"/>
                    <input type="radio" name="lantern_num" id="lantern_4" value="4"/>
                    <input type="radio" name="lantern_num" id="lantern_5" value="5"/>
                    <input type="radio" name="lantern_num" id="lantern_6" value="6"/>
                    <!--embed images-->
                    <div class="first slide">
                        <img src="../img/lanterns/lantern-01.png">
                        <div class="lantern_explain"><p>An orange lantern with 福 (fú, "good luck" or "blessing")</p></div>
                    </div>
                    <div class="slide">
                        <img src="../img/lanterns/lantern-02.png">
                        <div class="lantern_explain"><p>A blue lantern with 2023</p></div>
                    </div>
                    <div class="slide">
                        <img src="../img/lanterns/lantern-03.png">
                        <div class="lantern_explain"><p>An evil-preventing kite (액막이연, aegmag-iyeon)</p></div>
                    </div>
                    <div class="slide">
                        <img src="../img/lanterns/lantern-04.png">
                        <div class="lantern_explain"><p>A rabbit shaped lantern</p></div>
                    </div>
                    <div class="slide">
                        <img src="../img/lanterns/lantern-05.png">
                        <div class="lantern_explain"><p>A red lantern with 福 (fú, "good luck" or "blessing")</p></div>
                    </div>
                    <div class="slide">
                        <img src="../img/lanterns/lantern-06.png">
                        <div class="lantern_explain"><p>An orange lantern with 2023</p></div>
                    </div>
                </div>
                <!--navigation-->
                <div class="navigation">
                    <label for="lantern_1" class="navigation_btn">
                    </label>
                    <label for="lantern_2" class="navigation_btn">
                    </label>
                    <label for="lantern_3" class="navigation_btn">
                    </label>
                    <label for="lantern_4" class="navigation_btn">
                    </label>
                    <label for="lantern_5" class="navigation_btn">
                    </label>
                    <label for="lantern_6" class="navigation_btn">
                    </label>
                </div>
            </div>

            <div class="form_right">
                <h2>Share Your Riddle</h2>
                <label for="riddle">
                    Riddle:<textarea name="riddle" rows="5" maxlength="400" placeholder="Describe your riddle here with less than 400 characters..." required><?= html_escape($riddle['riddle']) ?></textarea>
                </label>
                <label for="answer">
                    Answer:<textarea name="answer" rows="5" maxlength="200" placeholder="Reveal the answer, it won't show up in the gallery, yet..." required><?= html_escape($riddle['answer']) ?></textarea>
                </label>
                <label for="name">
                    Your Name:<input type="varchar" name="name" maxlength="60" value="<?= html_escape($riddle['name']) ?>" placeholder="Will be displayed with the lantern in the gallery..." required>
                </label>
                <input type="Submit" value="Submit" class="submit_btn">
            </div>
            <?php }else{ ?><!--if(!$success) end, show success submission page-->
            <div  class="form_success">
                <h2>Your riddle is submitted!</h2>
                <p><br><br>You may submit more riddles or view the riddle gallery.<br><br></p>
                <a href="./riddle_submit.php" class="submit_btn">Submit More</a>
                <a href="./riddle_gallery.php" class="submit_btn">View Gallery</a>
            </div>
            <?php } ?><!--else(!$success) end-->
        </form>
    </div>

</body>
</html>