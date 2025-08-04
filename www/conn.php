<?php
try {
    $conn = mysqli_connect("localhost", "root", "", "smwi24");
} catch (\Throwable $th) {
    echo("Unable to connect to database");
    echo("<br> <input type='button' value='Try Again' onclick='refresh()'> <br>");
    echo("
    <script>
    function refresh()
    {
        location.reload();
    }
    </script>");
    echo("<br> <br> <b>Error:</b> " . mysqli_connect_error());
    exit();

}




