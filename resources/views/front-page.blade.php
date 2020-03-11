@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-banner')
    @include('partials.page-header')
    @include('partials.content-front-page')
  @endwhile
@endsection
