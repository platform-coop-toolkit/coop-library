<div class="notification notification--{{ $type ?? 'info' }}" role="alert">
  <button class="button button--borderless">
    @svg('close', 'icon--close', ['focusable' => 'false', 'aria-hidden' => 'true'])
    <span class="screen-reader-text">{{ __('Close notification', 'coop-library') }}</span>
  </button>
  <p class="notification__title">@svg($type, "icon--$type", ['focusable' => 'false', 'aria-hidden' => 'true']) {{ $title }}</p>
  <div class="notification__content">
    {!! $slot !!}
  </div>
</div>
