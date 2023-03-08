<?php
declare(strict_types=1);

namespace WPHooks;

use Composer\Autoload\ClassLoader;
use ReflectionClass;

/**
 * @phpstan-import-type HookArray from Hook
 * @phpstan-type HooksArray list<HookArray>
 * @implements \IteratorAggregate<int, Hook>
 */
final class Hooks implements \Countable, \IteratorAggregate {
	/**
	 * @var array
	 * @phpstan-var HooksArray
	 */
	protected $data;

	public static function fromVendor( string $directory, string $file ): self {
		return self::fromKnownFile( self::findFileFromVendor( $directory, $file ) );
	}

	/**
	 * @throws \Exception
	 */
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

	public function count(): int {
		return count( $this->data );
	}

	/**
	 * @return \Generator<int, Hook>
	 */
	public function getIterator(): \Generator {
		foreach ( $this->data as $hook ) {
			yield Hook::fromData( $hook );
		}
	}

	/**
	 * @return array<int, Hook>
	 * @phpstan-return list<Hook>
	 */
	public function all(): array {
		return iterator_to_array( $this );
	}

	/**
	 * @return array<int, Hook>
	 * @phpstan-return list<Hook>
	 */
	public function filter( string $search ): array {
		$hooks = [];

		foreach ( $this->data as $hook ) {
			if ( strpos( $hook['name'], $search ) !== false ) {
				$hooks[] = Hook::fromData( $hook );
			}
		}

		return $hooks;
	}

	/**
	 * @return ?Hook
	 */
	public function find( string $name ): ?Hook {
		foreach ( $this->data as $hook ) {
			if ( $hook['name'] === $name ) {
				return Hook::fromData( $hook );
			}
		}

		return null;
	}

	public function includes( string $name ): bool {
		foreach ( $this->data as $hook ) {
			if ( $hook['name'] === $name ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @throws \Exception
	 */
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

	/**
	 * @throws \Exception
	 */
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
     * @throws \RuntimeException
     */
    public static function getVendorPath(): string {
        static $cache;

        if (is_string($cache)) {
            return $cache;
        }

        $reflector = new ReflectionClass(ClassLoader::class);
        $classLoaderPath = $reflector->getFileName();
        if ($classLoaderPath === false) {
            throw new \RuntimeException('Unable to find Composer ClassLoader file.');
        }

        $vendorPath = dirname($classLoaderPath, 2);
        if (!is_dir($vendorPath)) {
            throw new \RuntimeException('Unable to detect vendor path.');
        }

        return $cache = $vendorPath;
    }

	/**
	 * @phpstan-param HooksArray $data
	 */
	protected function setData( array $data ): self {
		$this->data = $data;

		return $this;
	}
}
