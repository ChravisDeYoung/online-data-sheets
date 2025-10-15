@props(['header' => false])

@if($header)
    <th scope="row" {{ $attributes->merge(['class' => 'px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white']) }}>
        {{ $slot }}
    </th>
@else
    <td {{ $attributes->merge(['class' => 'px-4 py-3']) }}>
        {{ $slot }}
    </td>
@endif
