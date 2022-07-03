<?php
declare(strict_types=1);

namespace WPHooks;

/**
 * @phpstan-type HookArray array{
 *   name: string,
 *   aliases?: array<int, string>,
 *   file: string,
 *   type: string,
 *   doc: array{
 *     description: string,
 *     long_description: string,
 *     long_description_html: string,
 *     tags: array<int, array{
 *       name: string,
 *       content: string,
 *       types?: array<int, string>,
 *       variable?: string,
 *       link?: string,
 *       refers?: string,
 *       description?: string,
 *     }>,
 *   },
 *   args: int,
 * }
 */
class Hook {
	/**
	 * @var array
	 * @phpstan-var HookArray
	 */
	protected $data;

	/**
	 * @phpstan-param HookArray $data
	 */
	public static function fromData( array $data ): self {
		$instance = new self();

		return $instance->setData( $data );
	}

	/**
	 * @phpstan-param HookArray $data
	 */
	protected function setData( array $data ): self {
		$this->data = $data;

		return $this;
	}
}
