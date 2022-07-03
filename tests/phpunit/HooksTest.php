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
}
