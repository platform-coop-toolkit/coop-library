@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'coop-library') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  <div class="filter-sort">
    @include('partials.filters')
  </div>
  <div class="resource-list">
    <ul class="cards">
    @while (have_posts()) @php the_post() @endphp
      @include('partials.content-'.get_post_type())
    @endwhile
    </ul>
  </div>

  {!! get_the_posts_pagination(['prev_text' => sprintf('&lsaquo; <span class="screen-reader-text">%s</span>', __('previous resources', 'coop-library')), 'next_text' => sprintf(' <span class="screen-reader-text">%s</span> &rsaquo;', __('next resources', 'coop-library'))]) !!}
@endsection
