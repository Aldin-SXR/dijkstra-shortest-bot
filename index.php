<?php

require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/config/Config.php";
require_once __DIR__."/src/QuotePicker.php";

/* Turn on error reporting while debugging */
if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/* Create a new Telegram bot */
$bot = new \TelegramBot\Api\Client(BOT_API_KEY);

/* TODO: Keyboard suggestions */
$keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup([ [ "/quote" ] ], true);

/* A sample start command */
$bot->command("start", function($message) use ($bot) {
    $answer = "Welcome to Dijkstra's Shortest Quote. \nI hope that I will soon find the shortest path to your heart. \xF0\x9F\x92\x96";
    $bot->sendMessage($message->getChat()->getId(), $answer, NULL, false, NULL, $keyboard);
});

/* Command to fetch the quote */
$bot->command("quote", function($message) use ($bot) {
    $qp = new QuotePicker();
    $answer = $qp->get_quote();
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

/* Run the bot */
$bot->run();