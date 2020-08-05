<ul class="link-list">
  @foreach(get_children(get_the_ID()) as $child)
  <li class="link-list__item">
    <a href="{{ get_permalink($child) }}">{{ $child->post_title }}</a>
  </li>
  @endforeach
</ul>
