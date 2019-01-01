<?php

namespace Traducir\Traducir\Providers;

use GuzzleHttp\Client;

class DeeplProvider extends AbstractProvider
{

	/**
	 * The base URI for the API.
	 *
	 * @var string
	 */
	public $base_uri = "https://api.deepl.com";

	/**
	 * The Documentations Link.
	 *
	 * @var string
	 */
	public $docs = "https://www.deepl.com/api.html";

	/**
	 * Sets which kind of tags should be handled.
	 * Comma-separated list of one or more of the following values: xml
	 *
	 * @var string
	 */
	public $tag_handling;

	/**
	 * Comma-separated list of XML tags which never split sentences.
	 * See section Tag handling below for more information.
	 *
	 * @var string
	 */
	public $non_splitting_tags;

	/**
	 * Comma-separated list of XML tags whose content is never translated.
	 * See section Tag handling below for more information.
	 *
	 * @var string
	 */
	public $ignore_tags;

	/**
	 * Sets whether the translation engine should first split the input into sentences.
	 * This is enabled by default. Possible values are :
	 * 0
	 * 1 (default)
	 *
	 * @var boolean
	 */
	public $split_sentences;

	/**
	 * Sets whether the translation engine should preserve some aspects of the formatting,
	 * even if it would usually correct some aspects.
	 * Possible values are:
	 * 0 (default)
	 * 1
	 *
	 * @var boolean
	 */
	public $preserve_formatting;


	/**
	 * Translates text to the specified language.
	 *
	 * @param  string $text       	text to translate
	 * @param  array  $parameters[
	 * 		'to' => 'en',
	 * 		'from' => 'fr',
	 * 		'tag_handling' => '',						Sets which kind of tags should be handled.
	 * 		'non_splitting_tags' => '',			Comma-separated list of XML tags which never split sentences.
	 * 		'ignore_tags' => '',						Comma-separated list of XML tags whose content is never translated.
	 * 		'split_sentences' => 1,					Sets whether the translation engine should first split the input into sentences.
	 * 		'preserve_formatting' => 0 ,		Sets whether the translation engine should preserve some aspects of the formatting.
	 * ]
	 * @return string
	 */
	public function translate(string $text=null, array $parameters)
	{

		$this->setProperties(get_defined_vars());

		$request = $this->query([
				'auth_key' => $this->key,
				'text' => $this->text,
				'source_lang' => $this->from,
				'target_lang' => $this->to,
				'tag_handling' => $this->tag_handling,
				'non_splitting_tags' => $this->non_splitting_tags,
				'ignore_tags' => $this->ignore_tags,
				'split_sentences' => $this->split_sentences,
				'preserve_formatting' => $this->preserve_formatting,
			]);

		$this->response = $this->client()->request('GET', '/v2/translate',$request);

		return $this->getJsonResponse()->translations['text'];

	}

}
