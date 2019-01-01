<?php

namespace Traducir\Traducir;

use Illuminate\Support\Facades\Facade;
use Traducir\Traducir\Contracts\Factory;

class TranslatorFacade extends Facade
{

	protected static function getFacadeAccessor()
	{
        return Factory::class;
	}
}
