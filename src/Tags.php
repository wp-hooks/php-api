<?php
declare(strict_types=1);

namespace WPHooks;

/**
 * @phpstan-type TagsArray array<int, array{
 *   name: string,
 *   content: string,
 *   types?: array<int, string>,
 *   variable?: string,
 *   link?: string,
 *   refers?: string,
 *   description?: string,
 * }>
 */
class Tags {
	/**
	 * @var array
	 * @phpstan-var TagsArray
	 */
	protected $data;

	/**
	 * @phpstan-param TagsArray $data
	 */
	public static function fromData( array $data ): self {
		$instance = new self();

		return $instance->setData( $data );
	}

	/**
	 * @phpstan-param TagsArray $data
	 */
	protected function setData( array $data ): self {
		$this->data = $data;

		return $this;
	}
}
