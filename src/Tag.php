<?php
declare(strict_types=1);

namespace WPHooks;

/**
 * @phpstan-type TagArray array{
 *   name: string,
 *   content: string,
 *   types?: array<int, string>,
 *   variable?: string,
 *   link?: string,
 *   refers?: string,
 *   description?: string,
 * }
 */
class Tag {
	/**
	 * @var array
	 * @phpstan-var TagArray
	 */
	protected $data;

	/**
	 * @phpstan-param TagArray $data
	 */
	public static function fromData( array $data ): self {
		$instance = new self();

		return $instance->setData( $data );
	}

	/**
	 * @phpstan-param TagArray $data
	 */
	protected function setData( array $data ): self {
		$this->data = $data;

		return $this;
	}
}
