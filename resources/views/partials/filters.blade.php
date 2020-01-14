<div class="filter-wrapper">
  <button type="button" class="button" id="show-filters">@svg('filter', 'icon--filter', ['focusable' => 'false', 'aria-hidden' => 'true']) {{ __('Filter', 'coop-library' ) }}</button>
    <form name="filters" class="filters" action="{{ get_post_type_archive_link('lc_resource') }}">
      <button type="button" class="button" id="hide-filters">{{ __('Close', 'coop-library' ) }} @svg('close', 'icon--close', ['focusable' => 'false', 'aria-hidden' => 'true'])</button>
      <h2 class="h1 screen-reader-text">{{ __('Filters', 'coop-library' ) }}</h2>
      <div class="accordion accordion--filter-list">
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
            <button id="deselect-{{ $tax }}" type="button" class="button">
              <span class="button__label">{{ __('Deselect all', 'coop-library') }}<span class="screen-reader-text"> {{ $label }}</span></span>
            </button>
            <ul class="input-group input-group__parent {{ $tax }}">
              @foreach(get_terms($tax) as $term)
              <li>
                <input id="{{ $tax }}-{{ $term->slug }}" name="{{ $tax }}[]" type="checkbox" value="{{ $term->slug }}" {{
                checked(
                  (in_array($term->slug, array_keys($queried_resource_terms[$tax]), true)) ? $term->slug : false,
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
      <input type="hidden" name="order_by" value="{{ $_GET['order_by'] }}" />
      <div class="input-group">
        <input type="submit" name="applyFilters" value="{{ __('Apply Filters', 'coop-library') }}" />
      </div>
  </form>
</div>
