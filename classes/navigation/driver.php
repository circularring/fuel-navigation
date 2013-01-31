<?php

namespace Navigation;

use \Traversable;
use \RecursiveIteratorIterator;
use \RecursiveArrayIterator;

abstract class Navigation_Driver
{

	/**
	 * Glue
	 */
	const GLUE = ':';

	/**
	 * Uri list
	 */
	protected static $uris = false;

	/**
	 * Page list
	 */
	protected static $pages = false;

	/**
	 * Iterator　Page list
	 */
	protected static $iterator = false;

	/**
	 * Child Node
	 */
	protected static $childnode = 'pages';

	/**
	 * Property list
	 */
	protected static $properties = array(
		'label',
		'title',
		'description',
		'keywords',
		'pages',
	);

	/**
	 * Initialize, config loading.
	 */
	protected static function initialize()
	{
		\Config::load('navigation-settings', 'settings', false, true);
		self::$properties = \Config::get('settings.properties');
		self::$childnode  = \Config::get('settings.childnode');
	}

	/**
	 * Set Uri List
	 */
	protected static function setUris()
	{
		$segments = \Uri::segments();
		$uris[]   = '/';
		$uri      = null;

		foreach ($segments as $segment)
		{
			if (preg_match('/^([0-9])+$/', $segment) > 0 or $segment === 'index')
			{
				continue;
			}

			$uri     = $uri.'/'.$segment;
			$uris[] .= $uri;
		}

		self::$uris = $uris;
	}

	/**
	 * Set Pages
	 *
	 * @param		string	$config	extra config
	 * @return	void
	 */
	protected static function setPages($config)
	{
		\Config::load(sprintf('navigation-%s', $config), 'pages', false, true);
		$pages = \Config::get('pages');
		if ($pages && (!is_array($pages) && !$pages instanceof \Traversable))
		{
			throw new \NavigationException('Invalid argument: $pages must be an array, an instance of Traversable, or null');
		}
		self::$pages = $pages;
	}

	/**
	 * Iterator Pages
	 *
	 * @param		string	$config	extra config
	 * @return	void
	 */
	protected static function setIterator()
	{
		self::$iterator = new \RecursiveIteratorIterator(
			new \RecursiveArrayIterator(self::$pages),
			\RecursiveIteratorIterator::SELF_FIRST
		);
	}

}
