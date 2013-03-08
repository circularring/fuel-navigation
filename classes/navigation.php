<?php
/**
 * FuelPHP Package for Navigation
 *
 * @version    0.5.2
 */

namespace Navigation;

class BadMethodCallException extends \FuelException {}

class Navigation
extends
	\Navigation_Driver
{

	/**
	 * @var  Navigation	default instance
	 */
	protected static $INSTANCE = null;

	/**
	 * @var  Array  contains references if multiple were loaded
	 */
	protected static $INSTANCES = array();

	/**
	 * Init, settings config loading.
	 */
	public static function _init()
	{
		\Config::load('navigation-settings', 'settings', false, true);
		static::$INSTANCE = new static;
	}

	/**
	 * Navigation forge
	 *
	 * @param		string		$config
	 * @return  instance
	 */
	public static function forge($config = 'default')
	{
		\Config::load(sprintf('navigation-%s', $config), 'pages', false, true);
		return static::$INSTANCE;
	}

	/**
	 * Call rerouting for usage.
	 *
	 * @param		string		$method	method name called
	 * @param		array			$args		supplied arguments
	 * @return	instance
	 */
	public function __call($method, $args = array())
	{
		return static::__callStatic($method, $args);
	}

	/**
	 * Call rerouting for static usage.
	 *
	 * @param		string		$method	method name called
	 * @param		array			$args		supplied arguments
	 * @return	instance
	 */
	public static function __callStatic($method, $args = array())
	{
		$args = array_pad($args, 2, null);
		if (\Config::get('pages') === null)
		{
			static::forge($args[0]);
		}

		if (method_exists(static::$INSTANCE, $method))
		{
			return call_user_func_array(array(static::$INSTANCE, $method), $args);
		}

		if (array_key_exists($method, static::$INSTANCES))
		{
			return call_user_func_array(array(static::$INSTANCES[$method], 'forge'), $args);
		}

		$class = '\Navigation_Driver_'.ucfirst($method);
		if (class_exists($class))
		{
			static::$INSTANCES[$method] = new $class;
			return call_user_func_array(array(static::$INSTANCES[$method], 'forge'), $args);
		}

		throw new \BadMethodCallException('Invalid method: '.$class.'::forge');
	}

}
