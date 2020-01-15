@if(get_terms($taxonomy))
<ul class="link-list">
  @foreach(get_terms($taxonomy) as $term)
  <li class="link-list__item">
    <a href="{{ get_term_link($term) }}">{!! $term->name !!}</a>
  </li>
  @endforeach
</ul>
@endif
