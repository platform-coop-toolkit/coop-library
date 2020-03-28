@if(isset($_GET['s']) || $found_posts < App::totalPosts('lc_resource'))
<div class="current-filters">
  @php
  global $wpdb;
                        $args = [
                            'post_type' => 'lc_resource',
                            'show_date' => false,
                            'days'    => 30,
                        ];
                        $start_date = gmdate('Y-m-d', strtotime("-{$args['days']} days"));
                        $end_date   = gmdate('Y-m-d', strtotime('tomorrow midnight'));
                        $sql        = $wpdb->prepare("SELECT p.id, SUM(visitors) As visitors, SUM(pageviews) AS pageviews FROM {$wpdb->prefix}koko_analytics_post_stats s JOIN {$wpdb->posts} p ON s.id = p.id WHERE s.date >= %s AND s.date <= %s AND p.post_type = %s AND p.post_status = 'publish' GROUP BY s.id ORDER BY pageviews DESC", [$start_date, $end_date, $args['post_type']]); // @codingStandardsIgnoreLine
                        $results    = $wpdb->get_results($sql);
                        $viewed_ids = ( ! empty($results) ) ? wp_list_pluck($results, 'id') : [];
                        $unviewed_ids = get_posts([
                            'orderby' => 'date',
                            'order' => 'desc',
                            'post_type' => 'lc_resource',
                            'post__not_in' => $viewed_ids,
                            'posts_per_page' => -1,
                            'fields' => 'ids'
                        ]);
                        $ids = array_merge($viewed_ids + $unviewed_ids);
                        echo count($viewed_ids);
                        echo count($unviewed_ids);
  @endphp
  <p class="h3">{{ sprintf(__('Showing %1$s of %2$s resources for:', 'coop-library'), $found_posts, App::totalPosts('lc_resource')) }}</p>
  @if(isset($_GET['s']))
  <h2 class="h4">{{ __('Search term', 'coop-library') }}</h2>
  <p>&ldquo;{{ $_GET['s'] }}&rdquo;</p>
  @endif
  @if(!empty(array_filter(array_map('array_filter', $queried_resource_terms))))
    <h2 class="h4">{{ __('Applied filters', 'coop-library') }}</h2>
    <ul class="tags">
      @foreach($queried_resource_terms as $taxonomy => $terms)
        @foreach($terms as $term => $name)
        <li class="tag">
          <button class="button button--tag-button" data-checkbox="{{ $taxonomy }}-{{ $term }}"><span class="screen-reader-text">{{ __('Remove', 'coop-library') }} </span>{!! $name !!}<span class="screen-reader-text"> {{ __('from current filters', 'coop-library') }}</span> @svg('close', 'icon--close', ['focusable' => 'false', 'aria-hidden' => 'true'])</button>
        </li>
        @endforeach
      @endforeach
    </ul>
  <p><a href="{{ get_post_type_archive_link('lc_resource') }}">{{ __('Clear all', 'coop-library') }}</a></p>
  @endif
</div>
@endif
