<?php

namespace Navigation;

class Navigation_Driver_Sitemap extends \Navigation_Driver
{

	/**
	 * Namespace for the <urlset> tag
	 *
	 * @var string
	 */
	const SITEMAP_NS = 'http://www.sitemaps.org/schemas/sitemap/0.9';

	/**
	 * Schema URL
	 *
	 * @var string
	 */
	const SITEMAP_XSD = 'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd';

	/**
	 * Create Sitemap Xml
	 *
	 * @param		Striung		settings for the config name
	 * @return	html
	 */
	public static function forge($config = 'default')
	{
		static::initialize();
		static::setPages($config);
		static::setIterator();
		foreach (static::$iterator as $key => $value)
		{
			$pages[$key] = $key;
		}
		$uris = \Arr::filter_keys($pages, static::$properties, true);

		// create document
		$dom = new \DOMDocument('1.0', 'UTF-8');
		$dom->formatOutput = true;

		// ...and urlset (root) element
		$urlSet = $dom->createElementNS(self::SITEMAP_NS, 'urlset');
		$dom->appendChild($urlSet);

		foreach ($uris as $uri)
		{
			$url = \Uri::create(htmlentities($uri));

			// create url node for this page
			$urlNode = $dom->createElementNS(self::SITEMAP_NS, 'url');
			$urlSet->appendChild($urlNode);

			// put url in 'loc' element
			$urlNode->appendChild($dom->createElementNS(self::SITEMAP_NS, 'loc', $url));
		}

		$xml = $dom->saveXML();
		return rtrim($xml, PHP_EOL);
	}

}
