<?php

namespace App\Livewire\Support;

use GuzzleHttp\Client;
use Livewire\Component;

class GeminiAi extends Component
{

    public $message;
    public $response;

    public function sendMessage()
    {
        if (!$this->message) {
            $this->response = "Please enter a question.";
            return;
        }

        $client = new Client();
        $apiKey = env('GEMINI_API_KEY');

        try {
            $response = $client->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                'json' => [
                    'contents' => [
                        ['parts' => [['text' => $this->message]]]
                    ],
                ],
            ]);

            $result = json_decode($response->getBody(), true);
            $this->response = $result['candidates'][0]['content']['parts'][0]['text'] ?? "No response from AI.";
        } catch (\Exception $e) {
            $this->response = "Error: " . $e->getMessage();
        }
    }
    public function render()
    {
        return view('livewire.support.gemini-ai');
    }
}
