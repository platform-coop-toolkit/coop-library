  @if(!empty(array_filter($queried_resource_terms)))
  <div class="current-filters">
    <p class="h3">Showing {{ $found_posts }} of {{ App::totalPosts('lc_resource') }} resources</p>
    <ul class="tag-buttons">
      @foreach($queried_resource_terms as $taxonomy)
        @foreach($taxonomy as $term)
        <li class="tag-button">
          <button class="tag-button__button"><span class="screen-reader-text">{{ __('Remove', 'coop-library') }} </span>{{ $term->name }}<span class="screen-reader-text"> {{ __('from current filters', 'coop-library') }}</span> @svg('close', 'icon--close', ['focusable' => 'false', 'aria-hidden' => 'true'])</button>
        </li>
        @endforeach
      @endforeach
    </ul>
  <p><a href="{{ get_post_type_archive_link('lc_resource') }}">{{ __('Clear all', 'coop-library') }}</a></p>
  </div>
@endif
