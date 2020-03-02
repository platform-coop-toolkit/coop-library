@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'coop-library') }}
    </div>
    @include('partials.search-form', ['placeholder' => __('Search resource name, publisher, or topic…')])
  @endif

  @include('partials.filters')
  @include('partials.sort')
  @include('partials.current-filters')
  <div class="resource-list">
    <ul class="cards">
    @while (have_posts()) @php the_post() @endphp
      <li class="card__wrapper">@include('partials.content-'.get_post_type())</li>
    @endwhile
    </ul>
  </div>

  {!! App::getPagination(['total' => $max_pages]) !!}
@endsection
