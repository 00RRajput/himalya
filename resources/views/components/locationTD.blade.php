<span class="text-capitalize">
        @if(isset($record->fld_village) )
        {{  $record->fld_village }}
        @elseif(isset($record->fld_town))
        {{ $record->fld_town }}
        @endif
</span>
<p class="text-muted mb-0"><a href="http://maps.google.com/?q={{ $record->fld_lat }},{{ $record->fld_long }}"
        target="_blank" class="ri-map-pin-fill"></a> {{ $record->fld_district ?? '' }}</p>
