<?php
/**
 * @package   AkeebaSocialLogin
 * @copyright Copyright (c)2016-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Akeeba\SocialLogin\Twitch;

// Protect from unauthorized access
defined('_JEXEC') or die();

use Joomla\CMS\Http\Http;

/**
 * Implements a query to the currently logged in user through Twitch REST API
 */
class UserQuery
{
	/**
	 * The HTTP client object to use in sending HTTP requests.
	 *
	 * @var    Http
	 */
	protected $client;

	/**
	 * The OAuth token
	 *
	 * @var    string
	 */
	protected $token;

	private static $endpoint = 'https://api.twitch.tv/kraken/';

	/**
	 * Constructor.
	 *
	 * @param   Http   $client The HTTP client object.
	 * @param   string $token  The OAuth token.
	 */
	public function __construct($client = null, $token = null)
	{
		$this->client = $client;
		$this->token  = $token;
	}

	/**
	 * Get information about the currently logged in user. The information returned is:
	 * id           The Twitch user ID.
	 * login        The Twitch username.
	 * name         The full, real name of the Twitch user.
	 * email        The Twitch user's email. May be empty.
	 * avatarUrl    The URL to the 256px wide avatar of the user.
	 *
	 * @return  \stdClass  See above.
	 */
	public function getUserInformation()
	{
		$path  = 'user?oauth_token=' . urlencode($this->token);
		$reply = $this->client->get(self::$endpoint . $path, array());

		if ($reply->code > 299)
		{
			throw new \RuntimeException("HTTP {$reply->code}: {$reply->body}");
		}

		$response = json_decode($reply->body);

		return $response;
	}
}
