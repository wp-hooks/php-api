<?php
declare(strict_types=1);

namespace WPHooks\Tests;

use PHPUnit\Framework\TestCase;
use WPHooks\Hooks;

final class HooksTest extends TestCase {
	/**
	 * @dataProvider dataCoreTags
	 */
	public function testCanBeCreatedFromVendor( string $directory, string $path ): void {
		$instance = Hooks::fromVendor( $directory, $path );
		self::assertInstanceOf( Hooks::class, $instance );
	}

	/**
	 * @dataProvider dataCoreFiles
	 */
	public function testCanBeCreatedFromFile( string $file ): void {
		$instance = Hooks::fromFile( $file );
		self::assertInstanceOf( Hooks::class, $instance );
	}

	public function testErrorThrownWhenFileDoesNotExist(): void {
		self::expectException( \Exception::class );
		Hooks::fromFile( __DIR__ . '/missing.json' );
	}

	/**
	 * @return array<string, array<int, string>>
	 */
	public function dataCoreTags(): array {
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
