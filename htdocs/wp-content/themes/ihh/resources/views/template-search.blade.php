{{--
  Template Name: Search
--}}

@extends('layouts.app')

@section('content')
  <section class="content-block container">
    <div class="content-header">
      <h1>Search</h1>
    </div>
    @while(have_posts()) @php the_post() @endphp
    <section class="content-block container">
      @include('partials.content.page')
      {!! get_search_form(false) !!}
    </section>
  </section>
  @endwhile
@endsection
