{{-- Comparison table (intent page — sell yourself vs strategy partner) --}}
@if(!empty($table))
<div class="comparison-table-wrap">
  <div class="v3-table-wrap" role="region" tabindex="0">
    <table class="v3-table comparison-table">
      <thead>
        <tr>
          @foreach($table['headers'] as $header)
          <th>{{ $header }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach($table['rows'] as $row)
        <tr>
          <td><strong>{{ $row[0] }}</strong></td>
          <td>{{ $row[1] }}</td>
          <td class="comparison-highlight">{{ $row[2] }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif
