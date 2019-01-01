<?php

namespace Traducir\Traducir\Proviers;

use GuzzleHttp\Client;

class GoogleProvider extends AbstractProvider
{

	/**
	 * The base URI for the API.
	 *
	 * @var string
	 */
	public $base_uri = "https://translation.googleapis.com";

	/**
	 * The Documentations Link.
	 *
	 * @var string
	 */
	public $docs = "https://cloud.google.com/translate/docs/";

	/**
	 * The translation model of the supported languages.
	 * Can be either base to return languages supported by the Phrase-Based Machine Translation (PBMT) model,
	 * or nmt to return languages supported by the Neural Machine Translation (NMT) model.
	 * If omitted, then all supported languages are returned.
	 *
	 * @var string nmt || base
	 */
	public $model = 'base';

	/**
	 * Returns a list of supported languages for translation.
	 *
	 * @param  string $to    The target language code for the results
	 * @param  string $model The translation model of the supported languages.
	 * @return object        A list of supported language responses.
	 */
	public function languages($to =null, $model= null)
	{

		$this->setProperties(get_defined_vars());

		$request = $this->query([
				'key' => $this->key,
				'model' => $this->model,
				'target' => $this->to,
			]);

		$response = $this->client()->request('GET', '/language/translate/v2/languages', $request);

		return $this->getJsonResponse();
	}

	/**
	 * Detect the text language.
	 *
	 * @param  string $text The text that needs to be detected.
	 * @return string       The ISo code of the detected language.
	 */
	public function detect($text='Hello World!')
	{

		$this->setProperties(get_defined_vars());

		$request = $this->query([
				'key' => $this->key,
				'q' => $this->text,
			]);

		$response = $this->client()->request('GET', '/language/translate/v2/detect', $request);

		return $this->getJsonResponse()->lang;
	}

	/**
	 * Translation function
	 *
	 * @param  string $text       the text string that needs to be translated.
	 * @param  array  $parameters[
	 * 		'to' => 'en',
	 * 		'from' => 'fr',
	 * 		'format' =>'text',
	 * 		'model' => 'base',
	 * ]
	 * @return string             return the translated text string
	 */
	public function translate($text='Hello World!', array $parameters)
	{

		$this->setProperties(get_defined_vars());

		$request = $this->query([
				'key' => $this->key,
				'q' => $this->text,
				'target' => $this->to,
				'source' => $this->from,
				'format' => $this->format,
				'model' => $this->model,

			]);

		$response = $this->client()->request('GET', '/language/translate/v2', $request);

		return $this->getJsonResponse()->text[0];
	}

	/**
	 * Setting The translation model.
	 *
	 * @param  string $model The translation model of the supported languages
	 * @return class
	 */
	public function model($model='base')
	{
		$this->model = $model;
		return $this;
	}

}
