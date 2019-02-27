<?php

require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/Config.php";

/* Create a new Telegram bot */
$bot = new \TelegramBot\Api\Client(BOT_API_KEY);
$bot->run();

/* A sample command */
$bot->command("start", function($message) use ($bot) {
    $answer = "You found the shortest path to my heart. <3";
    file_put_contents("debug.log", print_r($message, true), FILE_APPEND);
    $bot->sendMessage($message->getChat()->getId(), $answer);
});


