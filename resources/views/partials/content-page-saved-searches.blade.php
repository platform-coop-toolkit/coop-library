<div class="align-right" hidden>
  <button id="remove-all" class="button button--borderless button--destructive">
    @svg('delete', 'icon--delete', ['focusable' => 'false', 'aria-hidden' => 'true']) <span aria-hidden="true">{{ __('Remove all', 'coop-library') }}</span>​​<span class="screen-reader-text">{{ __('Remove all saved searches', 'coop-library') }}</span>
  </button>
</div>
<div id="saved-searches"></div>
<div class="nothing-saved">
  <p class="h2">{{__('You have no saved searches.', 'coop-library') }}</p>
  <p>{!! sprintf(__('Search or <a href="%s">browse</a> for resources to save your search.', 'coop-library'), get_post_type_archive_link('lc_resource')) !!}</p>
</div>
