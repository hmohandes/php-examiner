@props([
    'title' => null,
])

<div
    {{ $attributes->merge([
        'class' => 'bg-white rounded-xl shadow border border-gray-200'
    ]) }}
>

    @if($title)

        <div class="border-b px-6 py-4">

            <h2 class="font-semibold text-lg">

                {{ $title }}

            </h2>

        </div>

    @endif

    <div class="p-6">

        {{ $slot }}

    </div>

</div>