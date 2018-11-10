<?php

namespace Nomadopolis\PolymathBundle;

use Nomadopolis\PolymathBundle\DependencyInjection\NomadopolisPolymathExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class NomadopolisPolymathBundle
 * @package Nomadopolis\PolymathBundle
 */
class NomadopolisPolymathBundle extends Bundle
{
	/**
	 * @return NomadopolisPolymathExtension|null|\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
	 */
	public function getContainerExtension()
	{
		return new NomadopolisPolymathExtension();
	}
}