@php dynamic_sidebar('sidebar-primary') @endphp

<form action="/">
  {{-- <pre>
  @php
      global $wp_query;
      print_r($queried_resource_terms);
  @endphp
  </pre> --}}
  @foreach([
    'lc_topic' => __('Topics', 'learning-commons'),
    'lc_goal' => __('Goals', 'learning-commons'),
    'lc_format' => __('Formats', 'learning-commons'),
    'lc_sector' => __('Sectors', 'learning-commons'),
    'lc_region' => __('Regions', 'learning-commons'),
  ] as $tax => $label)
  <details>
    <summary>{{ $label }}</summary>
    <ul class="{{ $tax }}">
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
  </details>
  @endforeach
  <input type="submit" value="{{ __('Apply Filters', 'learning-commons') }}" />
</form>
