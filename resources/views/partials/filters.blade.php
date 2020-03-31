<div class="filter-wrapper">
  <button type="button" class="button button--borderless" id="show-filters">@svg('filter', 'icon--filter', ['focusable' => 'false', 'aria-hidden' => 'true']) {{ __('Filter', 'coop-library' ) }}</button>
  <form name="filters" class="filters" action="{{ (isset($_GET['s'])) ? home_url('/') : get_post_type_archive_link('lc_resource') }}">
      <input type="hidden" name="filtered" value="1" />
      @if(isset($_GET['s']))
      <input type="hidden" name="s" value="{{ $_GET['s'] }}" />
      <input type="hidden" name="post_type" value="lc_resource" />
      @endif
      @if(isset($_GET['order_by']))<input type="hidden" name="order_by" value="{{ $_GET['order_by'] }}" />@endif
      <button type="button" class="button button--borderless button--inverse" id="hide-filters">{{ __('Close', 'coop-library' ) }} @svg('close', 'icon--close', ['focusable' => 'false', 'aria-hidden' => 'true'])</button>
      <h2 class="h1 screen-reader-text">{{ __('Filters', 'coop-library' ) }}</h2>
      <div class="accordion accordion--filter-list">
        @foreach([
          'lc_goal' => __('Goals', 'coop-library'),
          'lc_topic' => __('Topics', 'coop-library'),
          'lc_coop_type' => __('Co-op Types', 'coop-library'),
          'lc_sector' => __('Sectors', 'coop-library'),
          'lc_region' => __('Locations', 'coop-library'),
          'lc_format' => __('Formats', 'coop-library'),
        ] as $tax => $label)
        @if(get_terms(['taxonomy' => $tax, 'lang' => '']))
        <div class="accordion__pane @if(isset($_COOKIE['filters-expanded']) && $_COOKIE['filters-expanded'] === "accordion-$tax"){{ ' accordion__pane--expanded' }}@endif" id="accordion-{{ $tax }}">
          <p class="accordion__heading">{{ $label }}</p>
          <div class="accordion__content">
            <button id="deselect-{{ $tax }}" type="button" class="button button--borderless">
              <span class="button__label"><span aria-hidden="true">{{ __('Deselect all', 'coop-library') }}</span><span class="screen-reader-text">{{ sprintf(__('Deselect all %s', 'coop-library'), $label) }}</span></span>
            </button>
            <ul id="{{ $tax }}" class="input-group input-group__parent {{ $tax }}">
              @foreach(get_terms(['taxonomy' => $tax, 'lang' => '', 'orderby' => 'order']) as $term)
                @if(!$term->parent)
                <li>
                  <input id="{{ $tax }}-{{ $term->slug }}" name="{{ $tax }}[]" type="checkbox" value="{{ $term->slug }}" {{
                  checked(
                    (in_array($term->slug, array_keys($queried_resource_terms[$tax]), true)) ? $term->slug : false,
                    $term->slug,
                    false
                  ) }} />
                  <label for="{{ $tax }}-{{ $term->slug }}">{!! $term->name !!}</label>
                  @if(get_term_children($term->term_id, $tax))
                    <span class="supplementary-label" hidden> ({{ sprintf(__('and %d subtopics', 'coop-library'), count(get_term_children($term->term_id, $tax))) }})</span>
                    <span class="filter-disclosure-label" hidden>{{ sprintf(__('show %1$d subtopics for "%2$s"', 'coop-library'), count(get_term_children($term->term_id, $tax)), $term->name) }}</span>
                    <ul class="input-group input-group__descendant">
                      @foreach(get_terms(['taxonomy' => $tax, 'lang' => '', 'parent' => $term->term_id]) as $child_term)
                      <li>
                        <input id="{{ $tax }}-{{ $child_term->slug }}" name="{{ $tax }}[]" type="checkbox" value="{{ $child_term->slug }}" {{
                        checked(
                          (in_array($child_term->slug, array_keys($queried_resource_terms[$tax]), true)) ? $child_term->slug : false,
                          $child_term->slug,
                          false
                        ) }} />
                        <label for="{{ $tax }}-{{ $child_term->slug }}">{!! $child_term->name !!}</label>
                      </li>
                      @endforeach
                    </ul>
                  @endif
                </li>
                @endif
              @endforeach
            </ul>
          </div>
        </div>
        @endif
        @endforeach
        <div class="accordion__pane @if(isset($_COOKIE['filters-expanded']) && $_COOKIE['filters-expanded'] === "accordion-language"){{ ' accordion__pane--expanded' }}@endif" id="accordion-language">
          <p class="accordion__heading">{{ __('Languages', 'coop-library') }}</p>
          <div class="accordion__content">
            <button id="deselect-language" type="button" class="button button--borderless">
              <span class="button__label">{{ __('Deselect all', 'coop-library') }}<span class="screen-reader-text"> {{ __('languages', 'coop-library') }}</span></span>
            </button>
            <ul id="language" class="input-group input-group__parent language">
              @foreach(App::getMetaValues('language', 'lc_resource') as $language)
              <li>
                <input id="language-{{ $language }}" name="language[]" type="checkbox" value="{{ $language }}" {{ checked(in_array($language, array_keys($queried_resource_terms['language']))) }} />
                <label for="language-{{ $language }}">{!! $languages[$language] !!}</label>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      <div class="input-group">
        <button id="apply-filters" class="button" type="submit">{{ __('Apply Filters', 'coop-library') }}</button>
      </div>
  </form>
</div>
