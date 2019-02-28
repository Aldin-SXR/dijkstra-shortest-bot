<?php

class QuotePicker {
    private $client;

    /**
     * Class constructor.
     * @param array $credentials Possible MongoDB credentials.
     * @return void
     */
    public function __construct($credentials = [ ]) {
        $this->client = new MongoDB\Client(DB_PATH, $credentials);
    }

    /**
     * Get count.
     * Return the number of quotes.
     * @return int Number of quotes.
     */
    private function get_count() {
        return $this->client->quotes->dijkstra->count();
    }

    /**
     * Get o quote.
     * Get a quote by _id.
     * @param int $_id ID of the quote.
     * @return object MongoDB Document object.
     */
    private function get_one($_id) {
        return $this->client->quotes->dijkstra->findOne([ "_id" => $_id ]);
    }

    /**
     * Fetch a quote.
     * Fetch a random quote.
     * @return string Quote string.
     */
    public function get_quote() {
        $quote_count = $this->get_count();
        do {
            $quote = ((array)$this->get_one(rand(1, $quote_count))["quote"])[0];
        } while (!$quote);
        return $quote;
    }
}