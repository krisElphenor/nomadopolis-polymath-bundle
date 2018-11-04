<?php
	/**
	 * Created by PhpStorm.
	 * User: kris
	 * Date: 01/11/18
	 * Time: 14:03
	 */

	namespace Nomadopolis\PolymathBundle;


	use Nomadopolis\PolymathBundle\DependencyInjection\NomadopolisPolymathExtension;
	use Symfony\Component\HttpKernel\Bundle\Bundle;

	class NomadopolisPolymathBundle extends Bundle
	{
		public function getContainerExtension()
		{
			return new NomadopolisPolymathExtension();
		}
	}