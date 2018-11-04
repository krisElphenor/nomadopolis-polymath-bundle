<?php
	/**
	 * Created by PhpStorm.
	 * User: kris
	 * Date: 02/11/18
	 * Time: 23:16
	 */

	namespace Nomadopolis\PolymathBundle\DependencyInjection;


	use Symfony\Component\Config\Definition\Builder\TreeBuilder;
	use Symfony\Component\Config\Definition\ConfigurationInterface;

	class Configuration implements ConfigurationInterface
	{
		public function getConfigTreeBuilder()
		{
			$tree_builder = new TreeBuilder();
			$root_node = $tree_builder->root('nomadopolis_polymath');

			$root_node
				->children()
					->scalarNode('end_point')->end()
					->scalarNode('depository_path')->end()
				->end()
			;

			return $tree_builder;
		}
	}