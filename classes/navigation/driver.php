<?php
/**
 * FuelPHP Package for Navigation
 *
 * @version    0.5.2
 */

namespace Navigation;

abstract class Navigation_Driver
{

	/**
	 * Page list
	 */
	protected static $pages = false;

	/**
	 * Uri list
	 */
	protected static $uris = false;

	/**
	 * initialize, config loading.
	 */
	protected static function initialize()
	{
		self::$pages = self::$pages ? self::$pages : \Config::get('pages');
		self::$uris = self::$uris ? self::$uris : self::getUris();
	}

	/**
	 * Find Property
	 *
	 * @param		string	$property
	 * @param		string	$uri			default null
	 * @return	string
	 */
	protected static function find($property, $uri = null)
	{
		self::initialize();
		$uri = is_null($uri) ? \Uri::string()?:self::findFirstKey() : $uri;
		$page = \Arr::get(self::$pages, $uri);
		return $page ? \Arr::get($page, $property) : null;
	}

	/**
	 * Append Properties
	 *
	 * @param	array		$properties
	 * @param	string	$uri
	 */
	protected static function append(array $properties, $uri = null)
	{
		self::initialize();
		$uri = is_null($uri) ? \Uri::string() : $uri;
		self::$pages = \Arr::merge(self::$pages, array($uri => $properties));
	}

	/**
	 * Find First Key
	 *
	 * @return	string
	 */
	protected static function findFirstKey()
	{
		reset(self::$pages);
		return key(self::$pages);
	}

	/**
	 * Get \Uri::string() base List
	 */
	private static function getUris()
	{
		$segments = \Uri::segments();
		$list[]   = array();
		$uris     = array();

		foreach ($segments as $segment)
		{
			$list[] = \Arr::merge(end($list), array($segment));
		}
		$list = \Arr::filter_recursive($list);

		foreach ($list as $uri)
		{
			$uris[] = implode('/', $uri);
		}
		\Arr::insert($uris, self::findFirstKey(), 0);

		return $uris;
	}

}
