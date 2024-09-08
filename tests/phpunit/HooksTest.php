<?php
declare(strict_types=1);

namespace WPHooks\Tests;

use PHPUnit\Framework\TestCase;
use WPHooks\Hook;
use WPHooks\Hooks;
use WPHooks\Tag;

final class HooksTest extends TestCase {
	/**
	 * @dataProvider dataCoreVendorPaths
	 */
	public function testCanBeCreatedFromVendor( string $directory, string $path ): void {
		self::expectNotToPerformAssertions();
		Hooks::fromVendor( $directory, $path );
	}

	/**
	 * @dataProvider dataCoreFiles
	 */
	public function testCanBeCreatedFromFile( string $file ): void {
		self::expectNotToPerformAssertions();
		Hooks::fromFile( $file );
	}

	public function testErrorThrownWhenFileDoesNotExist(): void {
		self::expectException( \InvalidArgumentException::class );
		Hooks::fromFile( __DIR__ . '/missing.json' );
	}

	public function testCanFindByName(): void {
		$hooks = $this->getFilters();
		$hook = $hooks->find( 'wp_tag_cloud' );
		$includes = $hooks->includes( 'wp_tag_cloud' );

		self::assertTrue( $includes );
		self::assertInstanceOf( Hook::class, $hook );
		self::assertSame( 'wp_tag_cloud', $hook->getName() );
	}

	public function testFindByUnknownNameReturnsNull(): void {
		$hooks = $this->getFilters();
		$hook = $hooks->find( 'this_does_not_exist' );
		$includes = $hooks->includes( 'this_does_not_exist' );

		self::assertFalse( $includes );
		self::assertNull( $hook );
	}

	public function testCanGetReturnTypes(): void {
		$hooks = $this->getFilters();
		$hook = $hooks->find( 'wp_tag_cloud' );

		$returnTypes = $hook->getDoc()->getReturnTypes();
		$expected = [
			'string',
			'string[]',
		];

		self::assertSame( $expected, $returnTypes );
	}

	public function testCanGetReturnTypeString(): void {
		$hooks = $this->getFilters();
		$hook = $hooks->find( 'wp_tag_cloud' );

		$returnType = $hook->getDoc()->getReturnTypeString();

		self::assertSame( 'string|string[]', $returnType );
	}

	public function testCanGetParams(): void {
		$hooks = $this->getFilters();
		$hook = $hooks->find( 'wp_tag_cloud' );

		$params = $hook->getDoc()->getParams();

		self::assertCount( 2, $params );
		self::assertInstanceOf( Tag::class, $params[0] );
		self::assertInstanceOf( Tag::class, $params[1] );
	}

	public function testCanCountParams(): void {
		$hooks = $this->getFilters();
		$hook = $hooks->find( 'wp_tag_cloud' );

		$count = $hook->getDoc()->countParams();

		self::assertSame( 2, $count );
	}

	public function testCanGetSince(): void {
		$hooks = $this->getFilters();
		$hook = $hooks->find( 'wp_tag_cloud' );

		$since = $hook->getDoc()->getSince();

		self::assertSame( '2.3.0', $since );
	}

	/**
	 * @return array<string, array<int, string>>
	 * @phpstan-return array{
	 *   actions: list<string>,
	 *   filters: list<string>,
	 * }
	 */
	public function dataCoreVendorPaths(): array {
		$dir = dirname( __DIR__, 2 );
		$actions = 'wp-hooks/wordpress-core/hooks/actions.json';
		$filters = 'wp-hooks/wordpress-core/hooks/filters.json';

		return [
			'actions' => [
				$dir,
				$actions,
			],
			'filters' => [
				$dir,
				$filters,
			],
		];
	}

	/**
	 * @return array<string, array<int, string>>
	 * @phpstan-return array{
	 *   actions: list<string>,
	 *   filters: list<string>,
	 * }
	 */
	public function dataCoreFiles(): array {
		$dir = dirname( __DIR__, 2 ) . '/vendor/wp-hooks/wordpress-core/hooks';

		return [
			'actions' => [
				"{$dir}/actions.json",
			],
			'filters' => [
				"{$dir}/filters.json",
			],
		];
	}

	private function getFilters(): Hooks {
		return Hooks::fromFile( $this->dataCoreFiles()['filters'][0] );
	}

	private function getActions(): Hooks {
		return Hooks::fromFile( $this->dataCoreFiles()['actions'][0] );
	}
}
