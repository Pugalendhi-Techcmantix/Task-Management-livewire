<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-xl  font-semibold mb-4">💬 Ask AI</h2>

    <!-- Chat Messages -->
    <div
        class="space-y-3 min-h-[400px] sm:min-h-[500px] md:min-h-[600px] max-h-[600px] overflow-y-auto p-3 bg-gray-50 rounded border">

        @if ($response)
            <!-- User Message -->
            <div class="flex justify-end ">
                <div class="bg-blue-500 text-white p-3 rounded-lg text-right">
                    {{ $message }}
                </div>
            </div>

            <!-- AI Response (Line by Line) -->
            <div class="flex justify-start flex-col space-y-0 bg-gray-900 font-mono ">
                @foreach (explode("\n", $response) as $line)
                    @php
                        // Trim the line to remove leading and trailing spaces
                        $trimmedLine = trim($line);

                        // Skip empty or lines with only spaces
                        if (empty($trimmedLine)) {
                            continue;
                        }

                        // Define colors for each keyword
                        $keywordColors = [
                            'if' => 'text-pink-500',
                            'else' => 'text-pink-500',
                            'for' => 'text-green-500',
                            'while' => 'text-green-500',
                            'return' => 'text-red-500',
                            'function' => 'text-purple-500',
                            'public' => 'text-yellow-500',
                            'view' => 'text-blue-500',
                        ];

                        // Replace multiple spaces inside the line
                        $line = preg_replace('/\s+/', ' ', $line);

                        // Add colors for keywords, numbers, and strings
                        $lineWithColors = preg_replace_callback(
                            '/(".*?"|\b(if|else|for|while|return|function|public|view)\b|\b\d+\b)/',
                            function ($matches) use ($keywordColors) {
                                // Match string literals (e.g., "string" => green)
                                if (preg_match('/^".*?"$/', $matches[0])) {
                                    return '<span class="text-green-300">' . $matches[0] . '</span>';
                                }

                                // Match keywords and apply specific colors
                                if (array_key_exists($matches[0], $keywordColors)) {
                                    return '<span class="' .
                                        $keywordColors[$matches[0]] .
                                        ' font-semibold">' .
                                        $matches[0] .
                                        '</span>';
                                }

                                // Match numbers (e.g., 123 => yellow)
                                if (preg_match('/^\d+$/', $matches[0])) {
                                    return '<span class="text-yellow-400">' . $matches[0] . '</span>';
                                }

                                // Default return (if not a match for string, keyword, or number)
                                return $matches[0];
                            },
                            $line,
                        );
                    @endphp
                    <div class="p-3 rounded-lg text-left bg-gray-800  ">
                        {{-- <span class="text-green-300">🤖 <strong>AI:</strong></span> --}}
                        <span class="text-gray-300">{!! $lineWithColors !!}</span>
                    </div>
                @endforeach

            </div>



        @endif
    </div>

    <!-- Input Area -->
    <div class="mt-4 flex space-x-2">
        <textarea wire:model="message" wire:keydown.enter="sendMessage" class="w-full border p-2 rounded"
            placeholder="Type your question..."></textarea>
        <x-mary-button wire:click="sendMessage"
            class="bg-gradient-to-r from-blue-500 to-purple-600  text-white rounded-lg  transition hover:scale-105"
            spinner>
            Send ➤
        </x-mary-button>
    </div>
</div>
