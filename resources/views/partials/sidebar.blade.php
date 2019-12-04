@php dynamic_sidebar('sidebar-primary') @endphp

{{-- <form action="/"> --}}
  {{--<pre>
  @php
      global $wp_query;
      print_r($queried_resource_terms);
  @endphp
  </pre>--}}
  <div class="accordions">
    @foreach([
      'lc_region' => __('Location of relevance', 'coop-library'),
      'lc_goal' => __('Goals', 'coop-library'),
      'lc_topic' => __('Topics', 'coop-library'),
      'lc_format' => __('Format', 'coop-library'),
      'lc_sector' => __('Sector', 'coop-library'),
    ] as $tax => $label)
    <div class="accordion">
      <p class="accordion__heading">{{ $label }}</p>
      <div class="accordion__content">
        <ul class="input-group {{ $tax }}">
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
    @endforeach
  </div>
  {{-- <input type="submit" value="{{ __('Apply Filters', 'coop-library') }}" /> --}}
{{-- </form> --}}
