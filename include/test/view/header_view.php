<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[ECサイト]<?php echo $page_title; ?></title>
    <link rel="stylesheet" href="<?php echo $stylesheet; ?>">
</head>

<body>
    <header>
        <h1>ECサイト</h1>
        <div class="header_menu">
            <h2>Menu</h2>
            <ul>
                <?php foreach ($menus as $menu_link => $menu_title): ?>
                    <li><a href="<?php echo $menu_link; ?>"><?php echo $menu_title; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </header>
    <div class="contents">
        <h1><?php echo $page_title; ?>ページ</h1>
        <?php if ($error_message || $message): ?>
            <div class="message_area">
                <div class="error_message">
                    <?php displayMessage($display_error_message) ?? ""; ?>
                </div>
                <div class="normal_message">
                    <?php displayMessage($display_message) ?? ""; ?>
                </div>
            </div>
        <?php endif; ?>