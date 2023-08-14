<div class="mb-4 text-md breadcrumbs">
    @php $link = ''; @endphp
    <ul>
        <li>
            <a href="{{ route('dashboard') }}" wire:navigate>Dashboard</a>
        </li>
        @if (Request::isMethod('get'))
            @for ($i = 1; $i <= count(Request::segments()); $i++)
                @if (($i < count(Request::segments())) & ($i > 0))
                    @php $link .= '/' . Request::segment($i); @endphp
                    @if (Request::segment($i == 2))
                        <li>{{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</li>
                    @else
                        <li>
                            <a href="{{ $link }}"
                                wire:navigate>{{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</a>
                        </li>
                    @endif
                @else
                    <li class="font-medium">{{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</li>
                @endif
            @endfor
        @else
            <li class="font-medium">{{ ucwords(str_replace('-', ' ', $defaultSegment)) }}</li>
        @endif
    </ul>
</div>
