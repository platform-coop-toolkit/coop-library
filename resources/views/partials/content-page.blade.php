@php the_content() @endphp
{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . pll__('Pages:'), 'after' => '</p></nav>']) !!}
