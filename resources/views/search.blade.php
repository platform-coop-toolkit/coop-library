@extends('layouts.app')

@section('content')
  @include('partials.page-header')
  @if (!have_posts())
  <div class="notification notification--warning">
    <button class="button button--borderless"><svg class="icon icon--close" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path id="close" d="m11.41 10 4.3-4.29a1 1 0 1 0 -1.42-1.42l-4.29 4.3-4.29-4.3a1 1 0 0 0 -1.42 1.42l4.3 4.29-4.3 4.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l4.29-4.3 4.29 4.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z" fill="currentColor"/></svg>
      <span class="screen-reader-text">{{ __('Close notification', 'coop-library') }}</span></button>
      <p class="notification__title"><svg class="icon icon--warning" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><g id="warning" fill="currentColor"><path d="m10 1a9.05 9.05 0 1 0 9.05 9 9.06 9.06 0 0 0 -9.05-9zm0 16.1a7.05 7.05 0 1 1 7.05-7 7.05 7.05 0 0 1 -7.05 6.95z"/><path d="m10.09 5.59a1 1 0 0 0 -1 1v4a1 1 0 0 0 2 0v-4a1 1 0 0 0 -1-1z"/><path d="m10.11 12.6a1 1 0 1 0 1 1 1 1 0 0 0 -1-1z"/></g></svg> {{ __('No results for search', 'coop-library') }}</p>
      <div class="notification__content">{{ __('Sorry, no results were found.', 'coop-library') }}</div>
  </div>
  @endif

  @include('partials.filters')
  @include('partials.sort')
  @if (have_posts())
  @include('partials.save-search')
  @endif
  @include('partials.current-filters')
  <div class="resource-list">
    <ul class="cards">
    @while(have_posts()) @php the_post() @endphp
      @include('partials.content-'.get_post_type())
    @endwhile
    </ul>
  </div>

  {!! App::getPagination([
    'base' => add_query_arg('paged','%#%'),
    'format' => '?paged=%#%',
    'total' => $max_pages
  ]) !!}
@endsection
