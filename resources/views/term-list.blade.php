{{--
	Template Name: Term List
--}}
@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
    @include('partials.content-term-list')
  @endwhile
@endsection
