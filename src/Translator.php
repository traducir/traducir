<?php

namespace Traducir\Traducir;

use Traducir\Traducir\Contracts\Factory;
use Traducir\Traducir\Providers\GoogleProvider;
use Traducir\Traducir\Providers\YandexProvider;
use Traducir\Traducir\Providers\DeeplProvider;
use Traducir\Traducir\Providers\FrenglyProvider;

class Translator
{

	/**
	 * The Package configuration array
	 *
	 * @var array
	 */
	protected $config;

	/**
	 * The Loaded Drivers.
	 *
	 * @var array
	 */
	protected $drivers;

	/**
	 * the current Driver
	 * @var string
	 */
	// protected $driver;

	/**
	 * __construct constructing class with the config variable
	 *
	 * @param array $config provider config variables
	 */
	public function __construct( array $config )
	{
		$this->config = $config;
	}

	/**
	 * Setting the translation driver
	 *
	 * @param  string $driver
	 * @return class
	 */
	public function driver($driver = null){

		if (is_null($driver)){
				throw new \Exception(sprintf(
						'Unable to resolve NULL driver for [%s].', static::class
				));
		}

		if (! isset($this->drivers[$driver])){
				$this->drivers[$driver] = $this->createDriver($driver);
		}

		return $this->drivers[$driver];
	}


	/**
	 * Create Driver fucntion
	 *
	 * @param  string $driver
	 * @return method
	 */
	protected function createDriver($driver)
	{
			$method = 'create'.ucwords($driver).'Driver';

			if (method_exists($this, $method)) {
					return $this->$method();
			}
			throw new \Exception("Driver [$driver] not supported.");
	}


	/**
	 * Create Driver for Google Translate
	 *
	 * @return Radioactive\Translator\Providers\GoogleProvider
	 */
	public function createGoogleDriver(){

			$config = $this->config['google'];

			return $this->buildProvider(
			    GoogleProvider::class, $config
			);
	}

	/**
	 * Create Driver for Yandex Translate
	 *
	 * @return Radioactive\Translator\Providers\YandexProvider
	 */
	public function createYandexDriver(){

			$config = $this->config['yandex'];

			return $this->buildProvider(
			    YandexProvider::class, $config
			);
	}

	/**
	 * Create Driver for Deepl Translate
	 *
	 * @return Radioactive\Translator\Providers\DeeplProvider
	 */
	public function createDeeplDriver(){

			$config = $this->config['deepl'];

			return $this->buildProvider(
			    DeeplProvider::class, $config
			);
	}

	/**
	 * Building translation provider.
	 *
	 * @param  class $provider
	 * @param  array $config
	 * @return class
	 */
	public function buildProvider($provider, $config){

			return new $provider($config);
	}


}
