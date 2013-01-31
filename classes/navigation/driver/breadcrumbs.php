<?php

namespace Navigation;

class Navigation_Driver_Breadcrumbs extends \Navigation_Driver
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
	 * Initialize, config loading.
	 */
	protected static function initialize()
	{
		parent::initialize();
		self::$template  = \Config::get('settings.breadcrumbs.template');
		self::$filterkey = \Config::get('settings.breadcrumbs.filterkey');
	}

	/**
	 * Create Breadcrumb Html
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
		$uris = \Arr::filter_keys($uris, static::$uris);

		$output[] = \Arr::get(static::$template, 'wrapper_start');
		$max   = count($uris) - 1;
		$count = 0;
		foreach ($uris as $uri => $content)
		{
			$is_last = ($count++ === $max);

			$output[] = $is_last
				?
				\Arr::get(static::$template, 'item_start_active')
				:
				\Arr::get(static::$template, 'item_start');

			$output[] = $is_last
				?
				$content
				:
				str_replace(\Uri::base(), '/', \Html::anchor($uri, $content, array('title' => $content)));

			$output[] = $is_last
				?
				null
				:
				\Arr::get(static::$template, 'divider');

			$output[] = \Arr::get(static::$template, 'item_end');
		}
		$output[]= \Arr::get(static::$template, 'wrapper_end');

		return implode(null, \Arr::filter_recursive($output)).PHP_EOL;
	}

}
