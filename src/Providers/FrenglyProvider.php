<?php

namespace Traducir\Traducir\Providers;

// use GuzzleHttp\Client;

class FrenglyProvider extends AbstractProvider
{

	/**
	 * The base URI for the API.
	 * @var string
	 */
	public $base_uri = "http://frengly.com";

	/**
	 * The Documentations Link.
	 *
	 * @var string
	 */
	public $docs = "http://www.frengly.com/api";

	/**
	 * frengly account email, entered during registration (for older accounts please use username).
	 *
	 * @var string
	 */
	public $email;

	/**
	 * frengly account password
	 *
	 * @var string
	 */
	public $password;


	/**
	 * Translates text to the specified language.
	 *
	 * @param  string $text       	text to translate
	 * @param  array  $parameters[
	 * 		'to' => 'en',						destination language code* to translate to.
	 * 		'from' => 'fr',					source language code* to translate from.
	 * ]
	 * @return string
	 */
	public function translate(string $text=null, array $parameters)
	{

		$this->setProperties(get_defined_vars());

		$request = $this->query([
				'premiumkey' => $this->key,
				'text' => $this->text,
				'src' => $this->from,
				'dest' => $this->to,
				'email' => $this->email,
				'password' => $this->password,
			]);

		$this->response = $this->client()->request('GET', '/frengly/data/translateREST',$request);

		return $this->getJsonResponse();

	}

	/**
	 * frengly account email, entered during registration (for older accounts please use username).
	 *
	 * @param  string $email 			frengly account email.
	 * @return class
	 */
	public function email($email='base')
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * frengly account password.
	 *
	 * @param  string $password 	frengly account password.
	 * @return class
	 */
	public function password($password='base')
	{
		$this->password = $password;
		return $this;
	}

}
