@php
  #$reservations = \App::reservation_status();
@endphp


@if(have_rows('services'))
  @while(have_rows('services')) @php the_row() @endphp
  <section class="services">
    <div class="container">
      <div class="services-header">
        <img src="{{ the_sub_field('image') }}" alt="">
      </div>
      <div class="services-content">
        <h2>{{the_sub_field('title')}}</h2>
        <ul class="home-services-list">
          <li class="services-list-item" style="background-color:#91c8c2">
            <h3>Service name here</h3>
            <span>Last updated: 5 minutes ago</span>
            <ul>
              <li>People in queue: 3</li>
              <li>Estimated waiting time: 5 minutes</li>
            </ul>
          </li>
          <li class="services-list-item" style="background-color:#91c8c2">
            <h3>Service name here</h3>
            <span>Last updated: 5 minutes ago</span>
            <ul>
              <li>People in queue: 3</li>
              <li>Estimated waiting time: 5 minutes</li>
            </ul>
          </li>
          <li class="services-list-item" style="background-color:#91c8c2">
            <h3>Service name here</h3>
            <span>Last updated: 5 minutes ago</span>
            <ul>
              <li>People in queue: 12</li>
              <li>Estimated waiting time: 40 minutes</li>
            </ul>
          </li>
          <li class="services-list-item" style="background-color:#91c8c2">
            <h3>Service name 2</h3>
            <span>Last updated: 5 minutes ago</span>
            <ul>
              <li>People in queue: 3</li>
              <li>Estimated waiting time: 5 minutes</li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </section>
  @endwhile
@endif
