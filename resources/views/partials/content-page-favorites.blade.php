<div id="favorites" class="resource-list">
  @if($favorites->have_posts())
    <ul class="cards">
      @while ($favorites->have_posts()) @php $favorites->the_post() @endphp
        <li class="card__wrapper">
          @include('partials.content-'.get_post_type())
          <button class="button remove-favorite" data-id="{{ get_the_id() }}" type="button">@svg('delete', 'icon--delete', ['focusable' => 'false', 'aria-hidden' => 'true']) {{ __('Remove', 'coop-library') }} <span class="screen-reader-text">{!! sprintf(__('"%s" from my favorites', 'coop-library'), get_the_title()) !!}</span></button>
        </li>
      @endwhile
    </ul>
    @endif
</div>
