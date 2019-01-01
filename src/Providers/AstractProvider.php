<?php

namespace Traducir\Traducir\Providers;

use GuzzleHttp\Client;

class AbstractProvider
{

	/**
	 * Set the base URI for the API.
	 *
	 * @var string
	 */
	public $base_uri = '';

	/**
	 * Set Request timeout with seconds.
	 *
	 * @var int
	 */
	public $timeout = 15;

	/**
	 * Set the API key.
	 *
	 * @var string
	 */
	public $key = '';

	/**
	 * A variable to hold the text we want to translate.
	 *
	 * @var string
	 */
	public $text;

	/**
	 * the text format it could be text ot html.
	 *
	 * @var string
	 */
	public $format = 'html';

	/**
	 * the current text language ISO code.
	 *
	 * @var string
	 */
	public $from = 'fr';

	/**
	 * the required translation languuage ISO code
	 *
	 * @var type
	 */
	public $to = 'en';


	/**
	 * __construct constructing class with the config variable
	 *
	 * @param array $config provider config variables
	 */
	public function __construct( array $config)
	{
		$this->config = $config;

		foreach($config as $key => $value){
			$this->{$key} = $value;
		}

	}

	public function client()
	{
		return new Client([
			'base_uri' => $this->base_uri,
			'timeout' => $this->timeout
		]);
	}

	public function getResponse()
	{
		return
			$this->response;
	}

	public function getResponseBody()
	{
		return
			$this->getResponse()->getBody();
	}

	public function getJsonResponse()
	{
		return json_decode(
			$this->getResponseBody()->getContents()
		);
	}

	public function query(array $query)
	{
		return [
			'query' => array_filter($query)
		];
	}


	public function setProperties($properties)
	{
		foreach($properties as $property => $value)
		{

			if(is_array($properties[$property]))
			{
				foreach($properties[$property] as $k => $v)
				{
					$this->{$k} = $v;
				}
			}
			else
			{
				$this->{$property} = $value;
			}
		}

	}

	/**
	 * Setting the API key.
	 *
	 * @param  string $key API key
	 * @return class
	 */
	public function key($key)
	{
		$this->key = $key;
		return $this;
	}

	/**
	 * Setting the text
	 *
	 * @param  string $text
	 * @return class
	 */
	public function text($text='Hello')
	{
		$this->text = $text;
		return $this;
	}

	/**
	 * Setting the current language ISO code.
	 *
	 * @param  string $language
	 * @return class
	 */
	public function from($language='en')
	{
		$this->from = $language;
		return $this;
	}

	/**
	 * the required text language ISO code.
	 *
	 * @param  string $language
	 * @return class
	 */
	public function to($language='fr')
	{
		$this->to = $language;
		return $this;
	}

	/**
	 * Setting the text format html or text
	 *
	 * @param  string $format
	 * @return class
	 */
	public function format($format='html')
	{
		// text, html
		$this->format = $format;
		return $this;
	}

	/**
	 * getting class variables
	 *
	 * @param  string $name
	 * @return property
	 */
  public function __get($name)
  {
    return $this->$name;
  }

	/**
	 * Setting class variables
	 *
	 * @param string $name
	 * @param mixed $value
	 */
  public function __set($name, $value)
  {
    $this->$name = $value;
  }

}
