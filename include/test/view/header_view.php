<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[ECサイトポートフォリオ]Electronic Commerce Site<?php echo $page_title; ?></title>
    <link rel="stylesheet" href="<?php echo $stylesheet; ?>">
</head>

<body>
    <header>
        <div class="header_menu">
            <div class="title">
                <h1><a href="<?php print TOP_PAGE_URL;?>">Electronic Commerce Site</a></h1>
                <img src="./assets/ec_logo_a.png" alt="logo">
            </div>
            <p><?php echo $user_name ?></p>
        </div>
        <div class="header_menu_under">
            <?php foreach ($menus as $menu_link => $menu_title): ?>
                <div><a href="<?php echo $menu_link; ?>"><?php echo $menu_title; ?></a></div>
            <?php endforeach; ?>
        </div>

        </div>

    </header>
    <main>
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