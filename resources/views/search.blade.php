@extends('layouts.app')

@section('content')
  @include('partials.page-header')
  @if (!have_posts())
  <div class="notification notification--error">
    <button class="button button--borderless"><svg class="icon icon--close" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path id="close" d="m11.41 10 4.3-4.29a1 1 0 1 0 -1.42-1.42l-4.29 4.3-4.29-4.3a1 1 0 0 0 -1.42 1.42l4.3 4.29-4.3 4.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l4.29-4.3 4.29 4.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z" fill="currentColor"/></svg>
      <span class="screen-reader-text">{{ __('Close notification', 'coop-library') }}</span></button>
      <p class="notification__title"><svg class="icon icon--error" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><g id="error" fill="currentColor"><path d="m10.09 1a9 9 0 1 0 9 9 9 9 0 0 0 -9-9zm0 16a7 7 0 1 1 7-7 7 7 0 0 1 -7 7z"/><path d="m12.85 7.18a1 1 0 0 0 -1.41 0l-1.35 1.35-1.35-1.35a1 1 0 0 0 -1.41 0 1 1 0 0 0 0 1.42l1.35 1.4-1.35 1.29a1 1 0 0 0 1.41 1.42l1.35-1.35 1.35 1.35a1 1 0 0 0 1.41-1.42l-1.35-1.29 1.35-1.4a1 1 0 0 0 0-1.42z"/></g></svg> {{ __('No results for search', 'coop-library') }}</p>
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
