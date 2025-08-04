
<!-- Random Code Generator -->


<form action="" method="get">

    <button name="randomize">click me</button>

</form>

<?php


// Alphabet list
    $char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    $randomChar = str_shuffle($char);
    $random = substr($randomChar, 0, 6);


    if (isset ($_GET['randomize'])) {
        echo $random;
    }

