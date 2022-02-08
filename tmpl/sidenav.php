<?php
/**
 * LastFM Recent Tracks Module
 *
 * @version 0.1.5
 */

defined('_JEXEC') or die;

$key = 0; // So we don't create unnecessary error log entries…

if(is_object($user) && $user->status == 'failed') : ?>
	<p><?php echo $user->error; ?></p>
<?php elseif(is_object($user) && $user->status == 'ok') : ?>
	<h3><a href="<?php echo $user->user->url; ?>" target="_blank"><?php echo $user->user->name; ?></a>'s Recently Listened Tracks:</h3>
	<?php /*<p><img src="<?php echo $user->user->image[1]; ?>" /></p>*/ ?>
<?php else : ?>
	<p><?php echo $user; ?></p>
<?php endif; ?>

<?php if(is_object($recent) && $recent->status == 'failed') : ?>
	<p><?php echo $recent->error; ?></p>
<?php elseif(is_object($recent) && $recent->status == 'ok') : ?>
	<?php $tracks = $recent->recenttracks->track; ?>
	<ul class="<?php echo $moduleclass_sfx; ?> nav menu side-nav">
	<?php foreach($tracks as $track[$key]) :
		$track_artist = $extended == 1 ? $track[$key]->artist->name : $track[$key]->artist;
		$track_image  = !empty($track[$key]->image[0]) ? $track[$key]->image[0] : 'http://placehold.it/34x34/ccc/ccc';
		$track_name   = $track[$key]->name;
		$track_url    = $track[$key]->url;
		$heart        = ($extended == 1) && ($track[$key]->loved == 1) ? ' <span class="red">♥</span>' : '';
		?>
		<li>
			<a href="<?php echo $track_url; ?>" target="_blank">
				<img src="<?php echo $track_image; ?>" class="right" alt="<?php echo $track_artist . ' &ndash; ' . $track_name; ?>" width="34" height="34" />
				<?php echo $track_artist; ?> &ndash; <?php echo $track_name; ?><?php echo $heart; ?>
				<div class="clearfix"></div>
			</a>
			</li>
	<?php endforeach; ?>
	</ul>
<?php else : ?>
	<p><?php echo $tracks; ?></p>
<?php endif; ?>
