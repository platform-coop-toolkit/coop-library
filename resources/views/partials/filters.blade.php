<div class="filter-sort__filters">
  {{--<pre>
  @php
      global $wp_query;
      print_r($queried_resource_terms);
  @endphp
  </pre>--}}
  <form action="">
    <div class="accordion">
      @foreach([
        'lc_region' => __('Location of relevance', 'coop-library'),
        'lc_goal' => __('Goals', 'coop-library'),
        'lc_topic' => __('Topics', 'coop-library'),
        'lc_format' => __('Format', 'coop-library'),
        'lc_sector' => __('Sector', 'coop-library'),
      ] as $tax => $label)
      @if(get_terms($tax))
      <div class="accordion__pane">
        <p class="accordion__heading">{{ $label }}</p>
        <div class="accordion__content">
          <ul class="input-group input-group__parent {{ $tax }}">
            @foreach(get_terms($tax) as $term)
            <li>
              <input id="{{ $tax }}-{{ $term->slug }}" name="{{ $tax }}[]" type="checkbox" value="{{ $term->slug }}" {{
              checked(
                (in_array($term->slug, $queried_resource_terms[$tax], true)) ? $term->slug : false,
                $term->slug,
                false
              ) }} />
              <label for="{{ $tax }}-{{ $term->slug }}">{!! $term->name !!}</label></li>
            @endforeach
          </ul>
        </div>
      </div>
      @endif
      @endforeach
    </div>
    <input type="submit" value="{{ __('Apply Filters', 'coop-library') }}" />
  </form>
</div>
