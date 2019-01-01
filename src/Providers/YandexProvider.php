<?php

namespace Traducir\Traducir\Providers;

// use GuzzleHttp\Client;

class YandexProvider extends AbstractProvider
{

	/**
	 * The base URI for the API.
	 *
	 * @var string
	 */
	public $base_uri = "https://translate.yandex.net";

	/**
	 * The Documentations Link.
	 *
	 * @var string
	 */
	public $docs = "https://tech.yandex.com/translate/doc/dg/concepts/About-docpage/";

	/**
	 * The only option available at this time is whether the response should include the automatically detected language of the text being translated.
	 * This corresponds to the value 1 for this parameter.
	 * If the language of the text being translated is defined explicitly,
	 * meaning the lang parameter is set as a pair of codes, the first code defines the source language.
	 * This means that the options parameter does not allow switching to automatic language detection.
	 * However, it does allow you to understand whether the source language was defined correctly in the lang parameter.
	 *
	 * @var mixed
	 */
	public $options = 1;

	/**
	 * The name of the callback function. Use for getting a JSONP response.
	 *
	 * @var string
	 */
	public $callback;

	/**
	 * In the response, supported languages are listed in the langs field with the definitions of the language codes.
	 * Language names are output in the language corresponding to the code in this parameter.
	 *
	 * @var string
	 */
	public $ui = 'fr';

	/**
	 * A list of the most likely languages (they will be given preference when detecting the text language). Use the comma as a separator.
	 *
	 * @var string
	 */
	public $hint = 'fr';



	/**
	 * Gets a list of translation directions supported by the service.
	 *
	 * @param  string $ui       	language code
	 * @param  string $callback 	name of the callback function
	 * @return object
	 */
	public function languages(string $ui=null, string $callback=null)
	{

		$this->setProperties(get_defined_vars());

		$request = $this->query([
				'key' => $this->key,
				'ui' => $this->ui,
				'callback' => $this->callback
			]);

		$response = $this->client()->request('GET', '/api/v1.5/tr.json/getLangs', $request);

		return $this->getJsonResponse();
	}

	/**
	 * Detects the language of the specified text.
	 *
	 * @param  string $text       	The text to detect the language for.
	 * @param  array  $parameters[
	 * 		'hint' => 'en', 					list of probable text languages
	 * 		'callback',								name of the callback function
	 * ]
	 * @return string
	 */
	public function detect(string $text=null, array $parameters=[])
	{

		$this->setProperties(get_defined_vars());

		$request = $this->query([
				'key' => $this->key,
				'text' => $this->text,
				'hint' => $this->hint,
				'callback' => $this->callback
			]);

		$response = $this->client()->request('GET', '/api/v1.5/tr.json/detect', $request);

		return $this->getJsonResponse()->lang;
	}


	/**
	 * Translates text to the specified language.
	 *
	 * @param  string $text       	text to translate
	 * @param  array  $parameters[
	 * 		'to' => 'en',
	 * 		'from' => 'fr',
	 * 		'format' => 'plain',			text format
	 * 		'options' => 1,						translation options
	 * 		'callback' => ,						name of the callback function
	 * ]
	 * @return string
	 */
	public function translate(string $text=null, array $parameters)
	{

		$this->setProperties(get_defined_vars());

		$request = $this->query([
				'key' => $this->key,
				'text' => $this->text,
				'lang' => "{$this->from}-{$this->to}",
				'format' => $this->format,
				'options' => $this->options,
				'callback' => $this->callback
			]);

		$this->response = $this->client()->request('GET', '/api/v1.5/tr.json/translate',$request);

		return $this->getJsonResponse()->text[0];

	}

}
