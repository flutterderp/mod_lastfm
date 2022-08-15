<?php
/**
 * LastFM Recent Tracks Module
 *
 * @version 0.1.6
 */

defined('_JEXEC') or die;

$key = 0; // So we don't create unnecessary error log entries…

if(is_object($user) && $user->status == 'failed') : ?>
	<p><?php echo $user->error; ?></p>
<?php elseif(is_object($user) && $user->status == 'ok') : ?>
	<h2><a href="<?php echo $user->user->url; ?>" target="_blank" rel="noopener noreferrer"><?php echo $user->user->name; ?></a>'s Recently Listened Tracks:</h2>
	<?php /*<p><img src="<?php echo $user->user->image[1]; ?>" /></p>*/ ?>
<?php else : ?>
	<p><?php echo $user; ?></p>
<?php endif; ?>

<?php if(is_object($recent) && $recent->status == 'failed') : ?>
	<p><?php echo $recent->error; ?></p>
<?php elseif(is_object($recent) && $recent->status == 'ok') : ?>
	<?php $tracks = $recent->recenttracks->track; ?>
	<ul class="<?php echo $moduleclass_sfx; ?> lastfm menu vertical">
	<?php foreach($tracks as $track[$key]) :
		$track_artist = $extended == 1 ? $track[$key]->artist->name : $track[$key]->artist;
		$track_image  = !empty($track[$key]->image[0]) ? $track[$key]->image[0] : 'https://via.placeholder.com/34x34/ccc/ccc.png';
		$track_name   = $track[$key]->name;
		$track_url    = $track[$key]->url;
		$heart        = ($extended == 1) && ($track[$key]->loved == 1) ? ' ♥' : '';
		?>
		<li class="lastfm-track">
			<a class="lastfm-link" href="<?php echo $track_url; ?>" target="_blank" rel="noopener noreferrer">
				<span class="lastfm-title"><?php echo $track_artist; ?> &ndash; <?php echo $track_name . $heart; ?></span>
				<span class="lastfm-img">
					<picture>
						<source srcset="<?php echo $track_image; ?>">
						<img src="<?php echo $track_image; ?>" class="right" alt="album art <?php echo $track_artist . ' &ndash; ' . $track_name; ?>" width="34" height="34" loading="lazy">
					</picture>
				</span>
			</a>
		</li>
	<?php endforeach; ?>
	</ul>
<?php else : ?>
	<p><?php echo $tracks; ?></p>
<?php endif; ?>

<p><small>powered by <a href="https://www.last.fm/" target="_blank" rel="noopener noreferrer">last.fm</a></small></p>
