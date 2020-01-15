@if(get_terms($taxonomy))
  <ul class="link-list">
  @foreach(get_terms($taxonomy) as $term)
    @if(get_term_children($term->term_id, $taxonomy))
      <li>
        <hr class="is-style-thick has-grey-200-background-color" />
        <h2>{{ $term->name }}</h2>
      </li>
      <li>
        <ul class="link-list">
          <li class="link-list__item">
            <a href="{{ get_term_link($term) }}">{!! $term->name !!}</a>
          </li>
          @foreach(get_terms(['taxonomy' => $taxonomy, 'parent' => $term->term_id]) as $child_term)
          <li class="link-list__item">
            <a href="{{ get_term_link($child_term) }}">{!! $child_term->name !!}</a>
          </li>
          @endforeach
        </ul>
        <hr class="is-style-thick has-grey-200-background-color" />
      </li>
    @elseif(!$term->parent)
      <li class="link-list__item">
        <a href="{{ get_term_link($term) }}">{!! $term->name !!}</a>
      </li>
    @endif
  @endforeach
@else
  <p>{{ sprintf(__('No %s found.'), strtolower(get_the_title())) }}</p>
@endif
