{{--
	Template Name: Favorites
--}}
@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
    @include('partials.content-page-favorites')
  @endwhile
  {!! App::getPagination([
    'base' => add_query_arg('paged','%#%'),
    'format' => '?paged=%#%',
    'total' => $favorites->max_num_pages
  ]) !!}
@endsection
