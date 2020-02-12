@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'coop-library') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  @include('partials.filters')
  @include('partials.sort')
  @include('partials.current-filters')
  <div class="resource-list">
    <ul class="cards">
    @while(have_posts()) @php the_post() @endphp
      @include('partials.content-'.get_post_type())
    @endwhile
    </ul>
  </div>

  {!! str_replace(['page-numbers current', 'page-numbers'], ['page current', 'link link--pagination'], get_the_posts_pagination([
    'prev_text' => sprintf('&lsaquo; <span class="screen-reader-text">%s</span>', __('previous resources', 'coop-library')),
    'next_text' => sprintf(' <span class="screen-reader-text">%s</span> &rsaquo;', __('next resources', 'coop-library'))
  ])) !!}
@endsection
