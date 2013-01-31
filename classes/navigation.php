<?php

namespace Navigation;

class NavigationException extends \FuelException {}

class Navigation extends \Navigation_Driver
{

	/**
	 * Get Key
	 *
	 * @return  string
	 */
	public static function get($uri, $property, $config = 'default')
	{
		static::initialize();
		static::setPages($config);

		$flatten = \Arr::flatten(static::$pages, self::GLUE);
		$filter  = \Arr::filter_suffixed($flatten, self::GLUE.$property);
		foreach ($filter as $key => $value)
		{
			$key = preg_replace('/^.*'.static::$childnode.self::GLUE.'/i', null, $key);
			$uris[$key] = $value;
		}
		$uris = \Arr::filter_keys($uris, array($uri));

		return current($uris);
	}

	/**
	 * Breadcrumb
	 *
	 * @return  string
	 */
	public static function breadcrumbs($config = 'default')
	{
		return \Navigation_Driver_Breadcrumbs::forge($config);
	}

	/**
	 * Links
	 *
	 * @return  string
	 */
	public static function links($config = 'default')
	{
		return \Navigation_Driver_Links::forge($config);
	}

	/**
	 * Sitemap
	 *
	 * @return  string
	 */
	public static function sitemap($config = 'default')
	{
		return \Navigation_Driver_Sitemap::forge($config);
	}

}
