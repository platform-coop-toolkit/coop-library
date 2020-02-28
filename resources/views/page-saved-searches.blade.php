{{--
	Template Name: Saved Searches
--}}
@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
    @include('partials.content-page-saved-searches')
  @endwhile
@endsection
