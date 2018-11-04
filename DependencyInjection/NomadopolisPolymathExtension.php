<?php
	/**
	 * Created by PhpStorm.
	 * User: kris
	 * Date: 02/11/18
	 * Time: 00:19
	 */

	namespace Nomadopolis\PolymathBundle\DependencyInjection;

	use Symfony\Component\Config\FileLocator;
	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
	use Symfony\Component\HttpKernel\DependencyInjection\Extension;

	class NomadopolisPolymathExtension extends Extension
	{
		public function load(array $configs, ContainerBuilder $container)
		{
			$yaml_loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
			$yaml_loader->load('services.yaml');

			$configuration = new Configuration();
			$configuration_value = $this->processConfiguration($configuration, $configs);

			$polymath_definition = $container->getDefinition('Nomadopolis\PolymathBundle\Component\Polymath');

			if( !empty($configuration_value['end_point']) )
				$polymath_definition->replaceArgument(0, $configuration_value['end_point']);

			if( !empty($configuration_value['depository_path']) )
				$polymath_definition->replaceArgument(1, $configuration_value['depository_path']);
		}
	}