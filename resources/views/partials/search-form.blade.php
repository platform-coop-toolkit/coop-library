<form role="search" method="get" class="search-form @if($modifier)search-form--{{ $modifier }}@endif" action="{{ home_url() }}">
  <label>
    <span class="screen-reader-text">{{ __('Search for:', 'coop-library') }}</span>
    <input type="search" class="search-field"@if($placeholder) placeholder="{{ $placeholder }}"@endif value="" name="s">
  </label>
  <button type="submit" class="search-submit">
    <span class="screen-reader-text">{{ __('Search', 'coop-library') }}</span>
    @svg('search', 'icon--search', ['focusable' => 'false', 'aria-hidden' => 'true'])
  </button>
</form>