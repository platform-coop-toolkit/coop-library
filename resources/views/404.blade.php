@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, but the page you were trying to view does not exist.', 'coop-library') }}
    </div>
    @include('partials.search-form', ['placeholder' => __('Search resource name, publisher, or topic…')])
  @endif
@endsection
