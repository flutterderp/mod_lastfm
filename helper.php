<?php
/**
 * LastFM Recent Tracks Module
 *
 * @version 0.1.5
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

class modLastFMHelper
{
	private $app;
	protected $api_key;
	protected $user_name;
	protected $limit;
	protected $extended;

	function __construct(string $apikey, string $username, int $limit = 10)
	{
		$this->app       = Factory::getApplication();
		$this->api_key   = $apikey;
		$this->user_name = $username;
		$this->limit     = (int) $limit; // Maximum 200
		$this->extended  = (int) 1; // Expects either a 0 or a 1
	}

	function getExtended()
	{
		return $this->extended;
	}

	function getUser()
	{
		$query_string             = array();
		$query_string['method']   = 'user.getinfo';
		$query_string['user']     = $this->user_name;
		$query_string['api_key']  = $this->api_key;
		$built_string             = http_build_query($query_string);
		$url                      = 'http://ws.audioscrobbler.com/2.0/?' . $built_string;

		try
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$xml = curl_exec($ch);
			curl_close($ch);

			$user_info         = new SimpleXMLElement($xml, 0, false);
			$user_info->status = $user_info->attributes()->status;
		}
		catch(Exception $e)
		{
			$this->app->enqueueMessage($e->getCode() . ': ' . $e->getMessage(), 'error');

			$user_info = 'Error getting user info.';
		}

		return $user_info;
	}

	function getTracks()
	{
		$query_string             = array();
		$query_string['method']   = 'user.getrecenttracks';
		$query_string['limit']    = $this->limit;
		$query_string['user']     = $this->user_name;
		$query_string['extended'] = $this->extended;
		$query_string['api_key']  = $this->api_key;
		$built_string             = http_build_query($query_string);
		$url                      = 'http://ws.audioscrobbler.com/2.0/?' . $built_string;

		try
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$xml = curl_exec($ch);
			curl_close($ch);

			$recent         = new SimpleXMLElement($xml, 0, false);
			$recent->status = $recent->attributes()->status;
		}
		catch(Exception $e)
		{
			$this->app->enqueueMessage($e->getCode() . ': ' . $e->getMessage(), 'error');

			$recent = 'Error getting recently listened tracks.';
		}

		return $recent;
	}
}
