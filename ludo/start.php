<?php
    $error = "";
    $version = "v3";
    if (isset($_GET["subscription_id"]) && isset($_GET["token"])) {
        $token           = $_GET["token"];
        $subscription_id = $_GET["subscription_id"];

        $token           = htmlspecialchars($token);
        $subscription_id = htmlspecialchars($subscription_id);
        $compress        = "ai";
        if (isset($_GET["compress"]) && ! empty($_GET["compress"])) {
            $compress = $_GET["compress"];
            if ($compress == "br") {
                $compress = "v1_brotli";
            }

            if ($compress == "gzip") {
                $compress = "v1_gzip";
            }

        }
        $isFullGame = false;
        if (isset($_GET["full_game"]) && ! empty($_GET["full_game"])) {
            $isFullGame                          = $_GET["full_game"];
            $isFullGame == "true" ?: $isFullGame = "false";
        }
        $room_id = "";
        if (isset($_GET["room_id"]) && ! empty($_GET["room_id"])) {
            $room_id = $_GET["room_id"];
        }

        $accept_encoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';

        if (strpos($accept_encoding, 'br') !== false) {
            $version = $version.'_brotli';
        } elseif (strpos($accept_encoding, 'gzip') !== false) {
            $version = $version.'_gzip';
        } else {
            // $version = $version;
        }
        $useVersion = $compress == "ai" ? $version : ($compress=="br" ? $version.'_brotli' : $version.'_gzip');

    } else {
        $error = "Need token and subscription_id as GET Parameters";
    }

    // header("Location: $version/index.html?player_id=$token&subscription_id=$mysubscription_id")

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play Deshi Dice</title>
</head>
<?php
    if (isset($error) && $error != "") {
        echo "<p>" . htmlspecialchars($error) . "</p>";
    }
?>

<body>
    <script>
    <?php if (isset($error) && $error == "") {  ?>
    window.location.href ="<?php if (empty($error)) {echo "$useVersion/index.html?player_id=$token&subscription_id=$subscription_id&full_game=$isFullGame&room_id=$room_id";}?>"
    <?php } ?>
    </script>
</body>

</html>