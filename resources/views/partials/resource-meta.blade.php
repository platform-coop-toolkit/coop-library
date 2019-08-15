<p class="publication-data">
@if($resource_publisher)
<span class="byline publisher vcard">
  {{ pll__('By') }} {!! $resource_publisher !!}
</span>
@endif
@if($resource_regions)
  @foreach($resource_regions as $region)
    <a href="{{ $region['url'] }}">{{ $region['name'] }}</a>
  @endforeach
@endif
</p>
