@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'coop-library') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  <ul class="cards">
  @while (have_posts()) @php the_post() @endphp
    @include('partials.content-'.get_post_type())
  @endwhile
  </ul>

  {!! get_the_posts_navigation() !!}
@endsection
