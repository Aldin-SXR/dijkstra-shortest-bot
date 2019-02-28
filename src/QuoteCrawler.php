<?php
/**
 * QuoteCrawler file.
 * The file which is used to import a list of Dijkstra's quotes.
 */
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../config/Config.php";
require_once __DIR__."/QuotePicker.php";

$dom = new DOMDocument();

/**
 * Get page.
 * Fetch a page's HTML structure.
 * @param string $url Page url.
 * @return string Returns page HTML.
 */
function get_page($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}

/* BrainyQuotes */
libxml_use_internal_errors(true);

$bq_html = get_page("https://www.brainyquote.com/authors/edsger_dijkstra");
$dom->loadHTML($bq_html);
$quote_list = [ ];

$finder = new DOMXpath($dom);
$quotes = $finder->query("//*[contains(@title, 'view quote')]");

foreach ($quotes as $i => $quote) {
    if ($quote->nodeValue) {
        $quote_list[ ] = [ "_id" => $i,  "quote" => $quote->nodeValue ];
    }
}

(new QuotePicker())->insert_quotes($quote_list);