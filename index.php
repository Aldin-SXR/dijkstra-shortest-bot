<?php

require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/Config.php";

/* Turn on error reporting while debugging */
if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/* Create a new Telegram bot */
$bot = new \TelegramBot\Api\Client(BOT_API_KEY);

/* A sample command */
$bot->command("start", function($message) use ($bot) {
    $answer = "You found the shortest path to my heart. \xF0\x9F\x92\x96";
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

/* Run the bot */
$bot->run();
