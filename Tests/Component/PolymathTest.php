<?php
	/**
	 * Created by PhpStorm.
	 * User: kris
	 * Date: 02/11/18
	 * Time: 00:41
	 */

	namespace Nomadopolis\PolymathBundle\Tests\Component;

	use Nomadopolis\PolymathBundle\Component\Polymath;
	use PHPUnit\Framework\TestCase;

	class PolymathTest extends TestCase
	{
		/**
		 * @var Polymath
		 */
		protected $polymath_subject;

		protected $expected_query;

		protected $expected_query_with_argument;

		public function setUp()
		{
			parent::setUp();

			$this->polymath_subject = new Polymath('end_point_test_url', __DIR__.'/../Depository');

			$this->expected_query = <<<EOT
{
    test {
        name
        age
        city {
            name
        }
    }
}
EOT;
			$this->expected_query_with_argument = <<<EOT
{
    test(argument_a: "hello") {
        name
        age
        city(argument_b: 123) {
            name
        }
    }
}
EOT;

		}

		public function testSetCustomQuery__shouldOverrideOrSetTheQueryByTheInputedValue()
		{
			$custom_query = <<<EOT
{
	raw {
		query
	}
}
EOT;

			$this->polymath_subject
				->setCustomQuery($custom_query);

			$this->assertEquals($custom_query, $this->polymath_subject->getQuery());
		}

		public function testPrepareQuery__shouldFetchAndSetInternallyTheQueryFromGraphQLFile()
		{
			$query_name = 'test_query.query.graphql';
			$this->polymath_subject
				->prepareQuery($query_name);

			$this->assertEquals($this->expected_query, $this->polymath_subject->getQuery());
		}

		public function testPrepareQuery__usingAShortQueryNameShouldReturnTheSameAsFullName()
		{
			$query_name = 'test_query';
			$this->polymath_subject
				->prepareQuery($query_name);

			$this->assertEquals($this->expected_query, $this->polymath_subject->getQuery());
		}

		public function testPrepareQuery__shouldReturnAnExceptionIfQueryNameCannotBeResolvedToAFile()
		{
			$this->expectException(\InvalidArgumentException::class);

			$query_name = 'fake_query.query.graphql';
			$this->polymath_subject
				->prepareQuery($query_name);
		}

		public function testPrepareQuery__withArgumentShouldMergeArgumentIntoQuery()
		{
			$query_name = 'test_query_with_parameter.query.graphql';
			$array_of_arguments = [
				'arg_a' => "hello",
				'arg_b' => 123
			];

			$this->polymath_subject
				->prepareQuery($query_name, $array_of_arguments);

			$this->assertEquals($this->expected_query_with_argument, $this->polymath_subject->getQuery());
		}

		public function testPrepareQuery__withMissingArgumentShouldThrowAnException()
		{
			$this->expectException(\RuntimeException::class);
			$this->expectExceptionMessageRegExp('/arg_b/');
			$this->expectExceptionMessageRegExp('/arg_a/');

			$query_name = 'test_query_with_parameter.query.graphql';
			$array_of_arguments = [];

			$this->polymath_subject
				->prepareQuery($query_name, $array_of_arguments);
		}
	}
