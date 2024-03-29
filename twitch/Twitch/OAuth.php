<?php
/**
 * @package   AkeebaSocialLogin
 * @copyright Copyright (c)2016-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Akeeba\SocialLogin\Twitch;

use Akeeba\SocialLogin\Library\OAuth\OAuth2Client;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Http\Http;
use Joomla\Input\Input;

// Protect from unauthorized access
defined('_JEXEC') or die();

/**
 * Twitch Account OAuth client.
 */
class OAuth extends OAuth2Client
{
	/**
	 * @var   array  Options for the OAuth object.
	 */
	protected $options;

	/**
	 * Constructor.
	 *
	 * @param   array           $options      OAuth options array.
	 * @param   Http            $client       The HTTP client object.
	 * @param   Input           $input        The input object.
	 * @param   CMSApplication  $application  The application object.
	 */
	public function __construct($options, $client, $input, $application)
	{
		$this->options = $options;

		// Setup the authentication and token urls if not already set.
		if (!isset($this->options['authurl']))
		{
			$this->options['authurl'] = 'https://api.twitch.tv/kraken/oauth2/authorize';
		}

		if (!isset($this->options['tokenurl']))
		{
			$this->options['tokenurl'] = 'https://api.twitch.tv/kraken/oauth2/token';
		}

		if (!isset($this->options['scope']))
		{
			$this->options['scope'] = 'user_read';
		}

		// Call the \Joomla\OAuth2\Client constructor to setup the object.
		parent::__construct($this->options, $client, $input, $application);
	}

	/**
	 * Method used to set permissions.
	 *
	 * @param   string  $scope  Comma separated list of permissions.
	 *
	 * @return  OAuth  This object for method chaining
	 */
	public function setScope($scope)
	{
		$this->setOption('scope', $scope);

		return $this;
	}

	/**
	 * Method to get the current scope
	 *
	 * @return  string Comma separated list of permissions.
	 */
	public function getScope()
	{
		return $this->getOption('scope');
	}

}
