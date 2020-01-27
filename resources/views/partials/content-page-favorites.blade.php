<div id="favorites" class="resource-list">
  @if($favorites->have_posts())
    <ul class="cards">
      @while ($favorites->have_posts()) @php $favorites->the_post() @endphp
        @include('partials.content-'.get_post_type())
      @endwhile
    </ul>
    @endif
</div>
