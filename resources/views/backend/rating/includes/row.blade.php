<x-livewire-tables::bs4.table.cell>
    {{$row->captain->name??""}}
</x-livewire-tables::bs4.table.cell>
<x-livewire-tables::bs4.table.cell>
   {{$row->merchant->name??""}}
</x-livewire-tables::bs4.table.cell>
<x-livewire-tables::bs4.table.cell>
{{--    {{$row->rate}}--}}
    @php
        $rate = $row->rate;
        $maxStars = 5;
    @endphp

    @for ($i = 1; $i <= $maxStars; $i++)
        @if ($i <= $rate)
            <i class="fas fa-star text-warning"></i> <!-- Solid star for rated star -->
        @else
            <i class="far fa-star text-warning"></i> <!-- Empty star for unrated star -->
        @endif
    @endfor
</x-livewire-tables::bs4.table.cell>
<x-livewire-tables::bs4.table.cell>
    {{$row->notes}}
</x-livewire-tables::bs4.table.cell>
<x-livewire-tables::bs4.table.cell>
    {{$row->created_at}}
</x-livewire-tables::bs4.table.cell>
