<?php

namespace Nomadopolis\PolymathBundle\Component;

use GuzzleHttp\Client;
use Symfony\Component\Finder\Finder;

/**
 * Class Polymath
 * @package Nomadopolis\PolymathBundle\Component
 */
class Polymath
{
	protected $end_point;

	protected $http_client;

	protected $depository_path;

	protected $query = "{}";

	protected $variables = [];

	public function __construct(string $end_point_url, string $depository_path = null)
	{
		$this->end_point = $end_point_url;
		$this->depository_path = $depository_path;
		$this->http_client = new Client(['base_uri' => $end_point_url]);
	}

	/**
	 * @param string $depository_query_name
	 * @param array|null $arguments
	 *
	 * @return Polymath
	 */
	public function prepareQuery(string $depository_query_name, array $arguments = null): self
	{
		$finder = new Finder();
		$depository_query_name = explode('.', $depository_query_name)[0];

		try
		{
			$finder
				->files()
				->name("$depository_query_name.query.graphql")
				->in($this->depository_path);
		}
		catch (\Exception $exception)
		{
			throw new \InvalidArgumentException("Aucun fichier correspondant. Vérifier le nom $depository_query_name");
		}

		foreach ( $finder as $file )
		{
			$query = $file->getContents();
			preg_match_all('/\$\w*/', $query, $argument_placeholders);

			if( !empty($argument_placeholders) )
			{
				$argument_placeholders = array_map(
					function($argument){
						return str_replace('$', '', $argument);
					},
					$argument_placeholders[0]);
				$missing_arguments = array_diff($argument_placeholders, array_keys($arguments ?? []));

				if( !empty($missing_arguments) )
					throw new \RuntimeException( sprintf("Les arguments suivants sont requis: %s", join(', ', array_unique($missing_arguments))) );
			}

			$this->query = $query;

			if( !empty($arguments) )
				$this->variables = $arguments;

			return $this;
		}

		throw new \InvalidArgumentException("Aucun fichier correspondant. Vérifier le nom");
	}

	/**
	 * @param string $custom_query
	 *
	 * @return Polymath
	 */
	public function setCustomQuery(string $custom_query): self
	{
		$this->query = $custom_query;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getQuery(): string
	{
		return $this->query;
	}

	/**
	 * @return object
	 */
	public function execute(): object
	{
		$data = ['json' => ['query' => $this->query]];

		if( !empty($this->variables) )
			$data['json']['variables'] = $this->variables;

		$response = $this->http_client
			->post($this->end_point, $data);

		return json_decode($response->getBody());
	}
}