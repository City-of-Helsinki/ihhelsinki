@php
  $reservations = \App::reservation_status();
@endphp


<section class="">
  <div class="container">
    <h2>Service queue status</h2>
    @if(!$reservations)
      <span>Service status not available</span>
    @else
    <div class="reservation-container">
      <table>
        <thead>
          <tr>
            <td>Service</td>
            <td>Time</td>
            <td>Next number</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            @foreach($reservations as $reservation)
              <td>{{$reservation['name']}}</td>
              <td>{{$reservation['estimatedWait']}}</td>
              <td>{{$reservation['waitingTime']}}</td>
            @endforeach
          </tr>
        </tbody>
      </table>

    </div>
    @endif;
  </div>
</section>

