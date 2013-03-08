<?php
/**
 * FuelPHP Package for Navigation
 *
 * @version    0.5.2
 */

namespace Navigation;

class Navigation_Driver_Links
extends
	\Navigation_Driver
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
	 * Init, config loading.
	 */
	public static function _init()
	{
		parent::initialize();
		self::$filterkey = \Config::get('settings.links.filterkey');
	}

	/**
	 * Navigation Driver Links forge
	 *
	 * @return string
	 */
	public static function forge()
	{
		// start
		$relation['start'] = array(static::findFirstKey() => \Arr::get(static::$pages, static::findFirstKey().'.'.self::$filterkey));

		// prev
		if (count(static::$uris) > 1)
		{
			end(static::$uris);
			prev(static::$uris);
			$prevuri = current(static::$uris);
			$relation['prev'] = array($prevuri => \Arr::get(static::$pages, $prevuri.'.'.self::$filterkey));
		}

		// next
		end(static::$uris);
		$currenturi = current(static::$uris);
		$pageskeys = array_keys(static::$pages);
		while(list(, $val) = each($pageskeys))
		{
			if ($val === $currenturi)
			{
				list(, $nextkey) = each($pageskeys);
				break;
			}
		}

		if ($nextkey)
		{
			$relation['next'] = array($nextkey => \Arr::get(static::$pages, $nextkey.'.'.self::$filterkey));
		}

		foreach ($relation as $key => $value)
		{
			list($uri, $title) = each($value);
			$uri = $uri === static::findFirstKey() ? '/' : $uri;
			$url = \Uri::create(htmlentities($uri));
			$url = str_replace(\Uri::base(), '/', $url);
			$output[] = sprintf(self::$template,
				$key,
				$url,
				$title
			);
		}

		return implode(PHP_EOL, $output).PHP_EOL;
	}

}
