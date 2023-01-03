<?php
declare(strict_types=1);

namespace WPHooks\Tests;

use PHPUnit\Framework\TestCase;
use WPHooks\Hook;
use WPHooks\Hooks;

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
		self::expectException( \Exception::class );
		Hooks::fromFile( __DIR__ . '/missing.json' );
	}

	public function testCanFindByName(): void {
		$file = $this->dataCoreFiles()['filters'][0];
		$filters = Hooks::fromFile( $file );
		$hook = $filters->find( 'wp_tag_cloud' );
		$includes = $filters->includes( 'wp_tag_cloud' );

		self::assertTrue( $includes );
		self::assertInstanceOf( Hook::class, $hook );
		self::assertSame( 'wp_tag_cloud', $hook->getName() );
	}

	public function testFindByUnknownNameReturnsNull(): void {
		$file = $this->dataCoreFiles()['filters'][0];
		$filters = Hooks::fromFile( $file );
		$hook = $filters->find( 'this_does_not_exist' );
		$includes = $filters->includes( 'this_does_not_exist' );

		self::assertFalse( $includes );
		self::assertNull( $hook );
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
}
