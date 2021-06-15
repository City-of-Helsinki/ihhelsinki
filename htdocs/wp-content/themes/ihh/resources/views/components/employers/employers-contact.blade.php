@if(have_rows('contact'))
  @while(have_rows('contact')) @php the_row() @endphp
  <section class="contact-section container-wide has-wave"
           style="background-image: url({{the_sub_field('background')}})">
    <div class="container">
      <div class="content" @if(get_sub_field('color')) style="background-color: {!! get_sub_field('color') !!}" @endif>
        <h2>{{the_sub_field('title')}}</h2>

        <div class="contact-services">
          @if(have_rows('contact_content'))
            @while(have_rows('contact_content')) @php the_row() @endphp
            <div class="contact-employers advisory-service">
              <h3>{{the_sub_field('title')}}</h3>
              {{the_sub_field('body')}}
            </div>
            @endwhile
          @endif
        </div>
        <aside class="contact-services-footer">
          {{the_sub_field('footer')}}
        </aside>
      </div>
    </div>

    @include('components.wave')
  </section>
  @endwhile
@endif
