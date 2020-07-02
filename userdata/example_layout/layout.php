<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $routing_data['title'] ?></title>
    <link type="text/css" rel="stylesheet" href="<?= $sporozoa_settings['app_url']."/".$sporozoa_settings['userdata_directory']."/".$sporozoa_settings['layout_directory'] ?>/css/styles.css">
</head>
<body>
<?php require_once $routing_data['view'] ?>
</body>
</html>