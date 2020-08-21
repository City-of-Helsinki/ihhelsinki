{{--
  Template Name: FAQ
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
  <article class="content-block container">
    @include('partials.content.header')
    @include('partials.content.page')
  </article>

  @if(have_rows('questions'))
    <section class="faqs container" id="faqs">
      @while(have_rows('questions')) @php the_row(); $id = get_row_index(); @endphp
      <div class="question" id="question_{{$id}}">
        <button class="question-header collapsed"
                data-toggle="collapse"
                data-target="#answer_{{$id}}"
                aria-expanded="false"
                aria-controls="answer_{{$id}}"
                aria-owns="answer_{{$id}}">
          <span>{{the_sub_field('question')}}</span>
        </button>

        <div id="answer_{{$id}}"
             class="collapse question-answer"
             data-parent="#faqs">
          {{the_sub_field('answer')}}
        </div>
      </div>
      @endwhile
    </section>
  @endif
  @endwhile
@endsection
