@props([
    'sortable' => null
])

<th
{{ $attributes->merge(['class' => 'px-6 py-3 bg-gray-50'])->only('class') }}
>
    @unless ($sortable)
        <span class="text-left text-sm leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ $slot }}</span>
    @else
        <button {{ $attribuess->except('class')}} class="flex items-center space-x-1 text-left text-sm leading-4 font-medium " >
            <span> {{$slot}} </span>
        </button>
    @endif
</th>
