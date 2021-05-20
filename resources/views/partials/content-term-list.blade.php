@if(App::activeTerms(['taxonomy' => $taxonomy, 'lang' => '']))
  <ul class="link-list">
    @foreach(App::activeTerms(['taxonomy' => $taxonomy, 'orderby' => 'order', 'lang' => '']) as $term)
    @if(get_term_children($term->term_id, $taxonomy))
      <li>
        <h2>{!! $term->name !!}</h2>
      </li>
      <li>
        <ul class="link-list">
          <li class="link-list__item">
            <a href="{{ App::filteredLink($term) }}">{!! $term->name !!}</a>
          </li>
          @foreach(App::activeTerms(['taxonomy' => $taxonomy, 'parent' => $term->term_id, 'hide_empty' => false, 'lang' => '']) as $child_term)
          <li class="link-list__item">
            <a href="{{ App::filteredLink($child_term) }}">{!! $child_term->name !!}</a>
          </li>
          @endforeach
        </ul>
      </li>
    @elseif(!$term->parent)
      <li class="link-list__item">
        <a href="{{ App::filteredLink($term) }}">{!! $term->name !!}</a>
      </li>
    @endif
  @endforeach
@else
  <p>{{ sprintf(__('No %s found.', 'coop-library'), strtolower(get_the_title())) }}</p>
@endif
