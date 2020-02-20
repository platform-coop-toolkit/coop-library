<div class="align-right" hidden><button id="remove-all" class="button button--borderless button--destructive">@svg('delete', 'icon--delete', ['focusable' => 'false', 'aria-hidden' => 'true']) {{ __('Remove all', 'coop-library') }}<span class="screen-reader-text"> {{ __('saved-searches', 'coop-library') }}</span></button></div>
<div id="saved-searches"></div>
<div class="notification notification--info">
  <p class="notification__title">@svg('info', 'icon icon--info', ['aria-hidden' => true, 'focusable' => false]) {{ __('No saved searches', 'coop-library') }}</p>
  <div class="notification__content">{!! __('Looks like you haven&rsquo;t saved any searches yet.', 'coop-library') !!}</div>
</div>
