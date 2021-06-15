<?php  if (get_field('events_group') && get_field('featured')): ?>
<section class="event container">
  <h2>Upcoming events</h2>

  <div class="events">
    <?php  if ($events_group = get_field('events_group')): ?>
    <div class="event-list">
        <?php 
          foreach($events_group as $event):
        ?>
        <a href="<?=get_permalink($event->ID)?>">
          <div class="event-list-item">
            <div class="event-date">
              <?= date("d.m.Y H:i:s", strtotime(get_field('start_time', $event->ID)));?> - <?= date("d.m.Y H:i:s", strtotime(get_field('end_time', $event->ID)));?>
            </div>
            <div class="event-title">
              <?= $event->post_title;?>
            </div>
          </div>
        </a>
        <?php endforeach;?>
    </div>
    <?php endif;?>
    
    <?php  if ($featured = get_field('featured')): ?>
    <a href="<?=get_permalink($featured->ID)?>">
      <div class="event-featured">
        <div class="event-featured-content">
          <div class="event-date">
            <?= date("d.m.Y H:i:s", strtotime(get_field('start_time', $featured->ID)));?>
          </div>
          <div class="event-title">
            <?= $featured->post_title;?>
          </div>
          <div class="event-description">
              <?= get_field('event_short_description', $featured->ID);?>
          </div>
        </div>
        <div class="event-featured-image" style="background-image: url('<?=get_the_post_thumbnail_url( $featured->ID, 'large' )?>');">
        </div>
      </div>
    </a>

    <div class="clear"></div>
    <?php endif;?>
  </div>
</section>
<?php endif;?>