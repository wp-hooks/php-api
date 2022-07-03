<?php
declare(strict_types=1);

namespace WPHooks;

/**
 * @phpstan-import-type HookArray from Hook
 * @phpstan-type HooksArray array<int, HookArray>
 */
class Hooks {
	/**
	 * @var array
	 * @phpstan-var HooksArray
	 */
	protected $data;

	public static function fromVendor( string $directory, string $file ): self {
		return self::fromKnownFile( self::findFileFromVendor( $directory, $file ) );
	}

	public static function fromFile( string $file ): self {
		if ( ! file_exists( $file ) ) {
			throw new \Exception( sprintf(
				'File does not exist: %s',
				$file
			) );
		}

		return self::fromKnownFile( $file );
	}

	/**
	 * @phpstan-param HooksArray $data
	 */
	public static function fromData( array $data ): self {
		$instance = new self();

		return $instance->setData( $data );
	}

	/**
	 * @return \Generator<int, Hook>
	 */
	public function all(): \Generator {
		foreach ( $this->data as $hook ) {
			yield Hook::fromData( $hook );
		}
	}

	protected static function fromKnownFile( string $file ): self {
		$contents = file_get_contents( $file );

		if ( $contents === false ) {
			throw new \Exception( sprintf(
				'Could not open hook file: %s',
				$file
			) );
		}

		$decoded = json_decode( $contents, true );

		if ( ! is_array( $decoded ) || ! isset( $decoded['hooks'] ) || ! is_array( $decoded['hooks'] ) ) {
			throw new \Exception( sprintf(
				'Unexpected data format in file: %s',
				$file
			) );
		}

		$hooks = $decoded['hooks'];

		return self::fromData( $hooks );
	}

	protected static function findFileFromVendor( string $directory, string $path ): string {
		$library_dependency = $directory . '/vendor/' . $path;

		if ( file_exists( $library_dependency ) ) {
			return $library_dependency;
		}

		$project_dependency = dirname( $directory, 2 ) . '/vendor/' . $path;

		if ( file_exists( $project_dependency ) ) {
			return $project_dependency;
		}

		throw new \Exception( sprintf(
			'Vendor directory not found for file: %s',
			$path
		) );
	}

	/**
	 * @phpstan-param HooksArray $data
	 */
	protected function setData( array $data ): self {
		$this->data = $data;

		return $this;
	}
}
