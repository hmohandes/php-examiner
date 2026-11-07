<div class="grid grid-cols-4 gap-6">

    <x-card>
        <h2 class="text-gray-500">Students</h2>
        <p class="text-3xl font-bold">{{ $students }}</p>
    </x-card>

    <x-card>
        <h2 class="text-gray-500">Exams</h2>
        <p class="text-3xl font-bold">{{ $exams }}</p>
    </x-card>

    <x-card>
        <h2 class="text-gray-500">Attempts</h2>
        <p class="text-3xl font-bold">{{ $attempts }}</p>
    </x-card>

    <x-card>
        <h2 class="text-gray-500">Average Score</h2>
        <p class="text-3xl font-bold">
            {{ $average }}%
        </p>
    </x-card>

</div>