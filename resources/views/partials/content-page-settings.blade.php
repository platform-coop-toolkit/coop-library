<ul class="link-list">
  @foreach(get_posts([
    'post_type' => 'page',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'post_parent' => $post->ID
    ]) as $child)
  <li class="link-list__item"><a href="{{ get_permalink($child->ID) }}">{{ $child->post_title }}</a></li>
  @endforeach
</ul>
