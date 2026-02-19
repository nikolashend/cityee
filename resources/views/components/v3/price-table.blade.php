{{-- Price / Commission / Risk table --}}
@props(['v3'])

@if(!empty($v3['table_title']))
<section class="v3-table-section" aria-labelledby="v3-table-title">
    <div class="container">
        <h2 id="v3-table-title" class="v3-section-title">{{ $v3['table_title'] }}</h2>

        <div class="v3-table-wrap" role="region" aria-label="{{ $v3['table_title'] }}" tabindex="0">
            <table class="v3-table">
                @if(!empty($v3['table_headers']))
                <thead>
                    <tr>
                        @foreach($v3['table_headers'] as $th)
                        <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </thead>
                @endif
                <tbody>
                    @foreach($v3['table_rows'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endif
