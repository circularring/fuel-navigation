<?php
/**
 * FuelPHP Package for Navigation
 *
 * @version    0.5
 */

namespace Navigation;

class Navigation_Driver_Breadcrumbs
extends
	\Navigation_Driver
{

	/**
	 * Filter Key
	 */
	protected static $filterkey = 'label';

	/**
	 * Breadcrumb Html Template
	 */
	protected static $template = array(
		'wrapper_start'			=> '<ul class="breadcrumb">',
		'wrapper_end'				=> '</ul>',
		'item_start'				=> '<li>',
		'item_start_active'	=> '<li class="active">',
		'item_end'					=> '</li>',
		'divider'						=> '<span class="divider">/</span>',
	);

	/**
	 * Init, config loading.
	 */
	public static function _init()
	{
		parent::initialize();
		self::$filterkey = \Config::get('settings.breadcrumbs.filterkey');
		self::$template  = \Config::get('settings.breadcrumbs.template');
	}

	/**
	 * Navigation Driver Breadcrumbs forge
	 *
	 * @return string
	 */
	public static function forge()
	{
		$filterpages = \Arr::filter_keys(static::$pages, static::$uris);

		$output[] = \Arr::get(self::$template, 'wrapper_start');
		$max   = count($filterpages) - 1;
		$count = 0;
		foreach ($filterpages as $uri => $contents)
		{
			$is_last = ($count++ === $max);

			$output[] = $is_last
				?
				\Arr::get(self::$template, 'item_start_active')
				:
				\Arr::get(self::$template, 'item_start');

			$content = \Arr::get($contents, self::$filterkey);
			$output[] = $is_last
				?
				$content
				:
				str_replace(\Uri::base(), '/', \Html::anchor($uri, $content, array('title' => $content)));

			$output[] = $is_last
				?
				null
				:
				\Arr::get(self::$template, 'divider');

			$output[] = \Arr::get(self::$template, 'item_end');
		}
		$output[]= \Arr::get(self::$template, 'wrapper_end');

		return implode(null, \Arr::filter_recursive($output)).PHP_EOL;
	}


}
