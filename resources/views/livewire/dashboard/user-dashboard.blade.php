<div class="container mt-3">
    <div class="mb-5 font-bold ">
        <h1>Welcome {{ $username }} <x-mary-loading class="loading-ring text-success" /></h1>
        <div wire:poll.1s="updateTime">
            {{ $currentTime }}
        </div>
    </div>
    <div class="grid gap-5 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <x-mary-card class="border-r-4 border-b-4 border-blue-300 shadow-xl flex items-center justify-center">
            <div class="text-center">

                <div class="bg-blue-100 p-4 rounded-full w-fit mx-auto mb-2">
                    <x-heroicon-o-clipboard-document-list class="w-8 h-8 text-blue-500" />
                </div>

                <h2 class="text-xl font-semibold text-gray-800">My Tasks</h2>

                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $mytaskCount }}</p>
            </div>
        </x-mary-card>
        <x-mary-card class="border-r-4 border-b-4 border-green-300 shadow-xl flex items-center justify-center">
            <div class="text-center">

                <div class="bg-green-100 p-4 rounded-full w-fit mx-auto mb-2">
                    <x-heroicon-o-check-circle class="w-8 h-8 text-green-500" />
                </div>

                <h2 class="text-xl font-semibold text-gray-800">Completed</h2>

                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $completed }}</p>
            </div>
        </x-mary-card>
        <x-mary-card class="border-r-4 border-b-4 border-yellow-300 shadow-xl flex items-center justify-center">
            <div class="text-center">

                <div class="bg-yellow-100 p-4 rounded-full w-fit mx-auto mb-2">
                    <x-heroicon-c-exclamation-circle class="w-8 h-8 text-yellow-500" />
                </div>

                <h2 class="text-xl font-semibold text-gray-800">In Completed</h2>

                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $incompleted }}</p>
            </div>
        </x-mary-card>
    </div>

    <div class="mt-5 gap-5 " wire:ignore>

        <x-mary-card class="" id="calendar"></x-mary-card>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                // Initialize FullCalendar
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 650,
                    events: @json($events), // Pass the events array from Livewire

                    eventContent: function(info) {
                        // Wrap event title text with a container
                        return {
                            html: '<div class="text-wrap font-bold">' + info.event.title + '</div>'
                        };
                    },

                });


                calendar.render();
            });
        </script>
    </div>


</div>
