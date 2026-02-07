<?php
    $error   = "";
    $version = "v1.0.1"; // also change in download for PWA
    if (isset($_GET["access_token"]) && isset($_GET["refresh_token"]) && isset($_GET["uid"])) {
        $access_token  = $_GET["access_token"];
        $refresh_token = $_GET["refresh_token"];
        $uid           = $_GET["uid"];

        $access_token  = htmlspecialchars($access_token);
        $refresh_token = htmlspecialchars($refresh_token);
        $uid           = htmlspecialchars($uid);

        if (empty($access_token) || empty($refresh_token) || empty($uid)) {
            $error = "Need Token, Auth Token and User ID as GET Parameters";
        }

    }

    $compress = "ai";
    if (isset($_GET["compress"]) && ! empty($_GET["compress"])) {
    $compress = $_GET["compress"];
    if ($compress == "br") {
        $compress = "br";
    } else if ($compress == "gzip") {
        $compress = "gzip";
    }

    }
    $compress = htmlspecialchars($compress);

    $accept_encoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';

    if (strpos($accept_encoding, 'br') !== false) {
        $version = $version . '_brotli';
    } elseif (strpos($accept_encoding, 'gzip') !== false) {
        $version = $version . '_gzip';
    } else {
    // $version = $version;
    }
    $useVersion = $compress == "ai" ? $version : ($compress == "br" ? $version . '_brotli' : $version . '_gzip');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play Earnia</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 40px 30px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-icon {
            font-size: 60px;
            margin-bottom: 20px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .error-message {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.3s ease, transform 0.2s ease;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .button:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .button:active {
            transform: translateY(0);
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px 20px;
            }

            h1 {
                font-size: 20px;
            }

            .error-message {
                font-size: 14px;
            }

            .error-icon {
                font-size: 48px;
            }
        }
    </style>
</head>

<body>
    <?php if (isset($error) && $error != "") {?>
        <div class="container">
            <div class="error-icon">⚠️</div>
            <h1>Oops! Something went wrong</h1>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
            <a href="#" class="button">Go Back</a>
        </div>
    <?php } else if (isset($access_token) && isset($refresh_token) && isset($uid) && isset($useVersion)) {?>
        <script>
            window.location.href = "<?php echo $useVersion; ?>/index.html?access_token=<?php echo urlencode($access_token); ?>&refresh_token=<?php echo urlencode($refresh_token); ?>&uid=<?php echo urlencode($uid); ?>";
        </script>
    <?php } else {?>
        <script>
            window.location.href = "<?php echo $useVersion; ?>/index.html";
        </script>
    <?php }?>
</body>

</html>