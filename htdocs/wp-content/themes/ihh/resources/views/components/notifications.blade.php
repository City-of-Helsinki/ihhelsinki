@php
  $notifications = \App::notifications();
@endphp

@if($notifications->have_posts())
  <div class="alert-area">
    @while($notifications->have_posts()) @php $notifications->the_post() @endphp
    <div class="alert alert-warning alert-dismissible show" role="alert">
      <div class="container">
        <div class="notification-title">
          <span class="notification-icon"></span> <span>{{ the_title() }}</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @if('' !== get_post()->post_content )
          <div class="notification-body">
            {{ the_content() }}
          </div>
        @endif
      </div>
    </div>
    @endwhile
  </div>
@endif
