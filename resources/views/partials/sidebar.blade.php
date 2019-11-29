@php dynamic_sidebar('sidebar-primary') @endphp

<form action="/">
  {{--<pre>
  @php
      global $wp_query;
      print_r($queried_resource_terms);
  @endphp
  </pre>--}}
  @foreach([
    'lc_region' => __('Location of relevance', 'learning-commons'),
    'lc_goal' => __('Goals', 'learning-commons'),
    'lc_topic' => __('Topics', 'learning-commons'),
    'lc_format' => __('Format', 'learning-commons'),
    'lc_sector' => __('Sector', 'learning-commons'),
  ] as $tax => $label)
  <div class="accordion">
    <p class="accordion__header">{{ $label }}</p>
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
  <input type="submit" value="{{ __('Apply Filters', 'learning-commons') }}" />
</form>
