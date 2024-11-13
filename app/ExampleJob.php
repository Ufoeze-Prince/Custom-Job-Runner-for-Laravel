<?php

namespace App;

class ExampleJob
{
    /**
     * Simulate a background job method.
     *
     * @param string $message
     * @return void
     */
    public function sendMessage($message)
    {
        // Simulating a time-consuming task
        sleep(5);
        echo "Message sent: {$message}";
    }
}
