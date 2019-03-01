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

/* A sample start command */
$bot->command("start", function($message) use ($bot) {
    /* A list of keyboard commands */
    $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup([ [ "/quote" ] ], true, true);
    $answer = "Hi, ".$message->getChat()->getFirstName().". ".
        "Welcome to Dijkstra's Shortest Quote. ".
        "I hope that I will soon find the shortest path to your heart. \xF0\x9F\x92\x96 \n\n". 
        "Type in /quote to see a random quote.";
    $bot->sendMessage($message->getChat()->getId(), $answer, null, false, null, $keyboard);
});

/* Command to fetch a random quote */
$bot->command("quote", function($message) use ($bot) {
    $qp = new QuotePicker();
    $answer = $qp->get_quote();
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

/* TODO: Implement other functionalities for other types of messages. For now, return an "Unrecognized" message. */
/* Reference: https://core.telegram.org/bots/api */
$bot->on(function($update) use ($bot) {
    $message = $update->getMessage();
    $bot->sendMessage($message->getChat()->getId(), "This is an unrecognized command.");
}, function ($message) use ($name) {
    return true;
});

/* Run the bot */
$bot->run();
