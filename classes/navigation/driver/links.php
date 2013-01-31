<?php

namespace Navigation;

class Navigation_Driver_Links extends \Navigation_Driver
{

	/**
	 * Filter Key
	 */
	protected static $filterkey = 'label';

	/**
	 * Link Html Template
	 */
	protected static $template = '<link rel="%s" href="%s" title="%s">';

	/**
	 * Initialize, config loading.
	 */
	protected static function initialize()
	{
		parent::initialize();
		self::$filterkey = \Config::get('settings.links.filterkey');
	}

	/**
	 * Create Links Html
	 *
	 * @param		Striung		settings for the config name
	 * @return	html
	 */
	public static function forge($config = 'default')
	{
		static::initialize();
		static::setUris();
		static::setPages($config);

		$flatten = \Arr::flatten(static::$pages, self::GLUE);
		$filter  = \Arr::filter_suffixed($flatten, self::GLUE.static::$filterkey);
		foreach ($filter as $key => $value)
		{
			$key = preg_replace('/^.*'.static::$childnode.self::GLUE.'/i', null, $key);
			$uris[$key] = $value;
		}

		// start
		reset($uris);
		$relation['start'] = array(key($uris) => current($uris));
		$current = end(static::$uris);
		$relation['next'] = static::searchNext($uris, $current);
		$relation['prev'] = static::searchPrev($uris, $current);

		foreach ($relation as $key => $value)
		{
			list($uri, $title) = each($value);
			if ($title)
			{
				$output[] = sprintf(static::$template,
					$key,
					$uri,
					$title
				);
			}
		}

		return implode(PHP_EOL, \Arr::filter_recursive($output)).PHP_EOL;
	}

	/**
	 * Search Next
	 *
	 * @param		Array
	 * @param		Striung
	 * @return	array
	 */
	protected static function searchNext(array $arr, $uri)
	{
		$result = array();
		while (list($key, $value) = each($arr))
		{
			if ($key === $uri)
			{
				list($key, $value) = each($arr);
				$result = array($key => $value);
				break;
			}
		}

		return $result;
	}

	/**
	 * Search Prev
	 *
	 * @param		Array
	 * @param		Striung
	 * @return	array
	 */
	protected static function searchPrev(array $arr, $uri)
	{
		$result = array();
		while (list($key, $value) = each($arr))
		{
			if ($key === $uri)
			{
				break;
			}
			$result = array($key => $value);
		}

		return $result;
	}

}
