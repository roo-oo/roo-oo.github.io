<?php

//Connection to DB
include 'include/db.php';
?>

<header>

    <nav id="nav">
        <a id="logo" href="index.php"><img src="image/logo.png"></a>

<!--        <div id="language">-->
<!--            <a class="language" href="#">KK</a>-->
<!--            <a class="language" href="#">RU</a>-->
<!--            <a class="language" href="#">EN</a>-->
<!--        </div>-->


        <div id="top_user">

            <?php if(isset($_SESSION["user"])) : ?>
                <a href="identity.php">
                    <?php echo $_SESSION["first_name"]. " ". $_SESSION["last_name"]. " ". $_SESSION["middle_name"];?></a>
               <br> <a href="logout.php" style="margin-left: 100px">Logout</a>

            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>

        </div>
    </nav>
</header>