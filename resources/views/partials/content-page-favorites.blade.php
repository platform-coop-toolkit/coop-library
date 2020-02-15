@if($favorites->have_posts())
<div class="align-right"><button id="remove-all" class="button button--borderless button--destructive">@svg('delete', 'icon--delete', ['focusable' => 'false', 'aria-hidden' => 'true']) {{ __('Remove all', 'coop-library') }}<span class="screen-reader-text"> {{ __('favorites', 'coop-library') }}</span></button></div>
<div id="favorites" class="resource-list">
  <ul class="cards">
    @while ($favorites->have_posts()) @php $favorites->the_post() @endphp
      <li class="card__wrapper">
        @include('partials.content-'.get_post_type())
        <div class="align-right"><button class="button button--borderless button--destructive remove-favorite" data-id="{{ get_the_id() }}" type="button">@svg('delete', 'icon--delete', ['focusable' => 'false', 'aria-hidden' => 'true']) {{ __('Remove', 'coop-library') }} <span class="screen-reader-text">{!! sprintf(__('"%s" from my favorites', 'coop-library'), get_the_title()) !!}</span></button></div>
      </li>
    @endwhile
  </ul>
</div>
@endif
