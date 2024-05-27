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
                <?php foreach ($menus as $menu_linlk => $menu_title): ?>
                    <li><a href="<?php echo $menu_linlk; ?>"><?php echo $menu_title; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </header>

    <body>
        <div class="contents">
                <?php display_message($message, $message_list); ?>
