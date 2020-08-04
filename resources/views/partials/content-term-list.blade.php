@if(get_terms(['taxonomy' => $taxonomy]))
  <ul class="link-list">
  @foreach(get_terms(['taxonomy' => $taxonomy, 'orderby' => 'order']) as $term)
    @if(get_term_children($term->term_id, $taxonomy))
      <li>
        <h2>{!! $term->name !!}</h2>
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
      </li>
    @elseif(!$term->parent)
      <li class="link-list__item">
        <a href="{{ get_term_link($term) }}">{!! $term->name !!}</a>
      </li>
    @endif
  @endforeach
@else
  <p>{{ sprintf(__('No %s found.', 'coop-library'), strtolower(get_the_title())) }}</p>
@endif
