<?php
$error = '';
$version = 'v1.0.0';
$readParameter = static function (string $name, string $default = ''): ?string {
    $value = $_GET[$name] ?? $default;
    return is_string($value) || is_numeric($value) ? (string) $value : null;
};

$subscriptionId = $readParameter('subscription_id');
$token = $readParameter('token');
$playerId = $readParameter('player_id');

if ($subscriptionId === null || trim($subscriptionId) === '' || $token === null || trim($token) === '') {
    $error = 'Need token and subscription_id as GET parameters.';
} elseif (strlen($subscriptionId) > 255 || strlen($token) > 2048) {
    $error = 'Invalid subscription_id or token.';
} else {
    $playerId = $playerId === null || trim($playerId) === '' ? $token : $playerId;
    if (strlen($playerId) > 255) {
        $error = 'Invalid player_id.';
    }
}

$roomIndex = $readParameter('room_index', '0');
if ($error === '' && ($roomIndex === null || filter_var($roomIndex, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) === false)) {
    $error = 'Room Index must be a non-negative integer.';
}

$transparent = strtolower((string) $readParameter('transparent', 'false'));
if ($error === '' && !in_array($transparent, ['true', 'false'], true) && !empty($transparent)) {
    $error = 'transparent must be true or false.';
}

$compress = strtolower((string) $readParameter('compress', 'ai'));
if ($error === '' && !in_array($compress, ['ai', 'br', 'gzip'], true)) {
    $error = 'compress must be ai, br, or gzip.';
}

if ($error === '') {
    
    if ($compress === 'ai') {
        $acceptEncoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';
        if (strpos($acceptEncoding, 'br') !== false) {
            $version .= '_brotli';
        } elseif (strpos($acceptEncoding, 'gzip') !== false) {
            $version .= '_gzip';
        }
    } elseif ($compress === 'br') {
        $version .= '_brotli';
    } else {
        $version .= '_gzip';
    }


    $redirectUrl = $version.'/index.html?' . http_build_query([
        'player_id' => $playerId,
        'subscription_id' => $subscriptionId,
        'token' => $token,
        'room_index' => (int) $roomIndex,
        'transparent' => $transparent,
    ], '', '&', PHP_QUERY_RFC3986);
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play Deshi Dice</title>
</head>
<body>
<?php if ($error !== ''): ?>
    <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php else: ?>
    <script>
    window.location.replace(<?= json_encode($redirectUrl, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>);
    </script>
<?php endif; ?>
</body>
</html>