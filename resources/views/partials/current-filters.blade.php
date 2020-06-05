@if(isset($_GET['s']) || $found_posts < App::totalPosts('lc_resource', $current_language))
<div class="current-filters">
  <p class="h3">{{ sprintf(__('%1$s of %2$s resources matched', 'coop-library'), $found_posts, App::totalPosts('lc_resource', $current_language)) }}</p>
  @if(isset($_GET['s']))
  <h2 class="h4">{{ __('Your search term:', 'coop-library') }}</h2>
  <p>&ldquo;{{ $_GET['s'] }}&rdquo;</p>
  @endif
  @if(!empty(array_filter(array_map('array_filter', $queried_resource_terms))))
    <h2 class="h4">{{ __('Your filters:', 'coop-library') }}</h2>
    <ul class="tags">
      @foreach($queried_resource_terms as $taxonomy => $terms)
        @foreach($terms as $term => $name)
        <li class="tag">
          <button class="button button--tag-button" data-checkbox="{{ $taxonomy }}-{{ $term }}">{!! sprintf(__('<span class="screen-reader-text">Remove </span>%s<span class="screen-reader-text"> from current filters</span>', 'coop-library'), $name) !!} @svg('close', 'icon--close', ['focusable' => 'false', 'aria-hidden' => 'true'])</button>
        </li>
        @endforeach
      @endforeach
    </ul>
    @if($found_posts > 0)
    <p><em>{{ __('The resources shown match at least one of these filters.', 'coop-library') }}</em></p>
    @endif
    <p><a href="{{ get_post_type_archive_link('lc_resource') }}">{{ __('Clear all', 'coop-library') }}</a></p>
  @endif
</div>
@endif
