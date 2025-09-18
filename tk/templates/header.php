<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Транспортная компания' ?></title>
    <link rel="stylesheet" href="/tk/assets/css/main.css">
    <link rel="stylesheet" href="/tk/assets/css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="layout">
        <?php require 'sidebar.php'; ?>
        <div class="main-content">
            <?php require 'topbar.php'; ?>
            <div class="content-wrapper">