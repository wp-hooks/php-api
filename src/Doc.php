<?php
declare(strict_types=1);

namespace WPHooks;

/**
 * @phpstan-import-type TagsArray from Tags
 * @phpstan-type DocArray array{
 *   description: string,
 *   long_description: string,
 *   long_description_html: string,
 *   tags: TagsArray,
 * }
 */
class Doc {
	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $long_description;

	/**
	 * @var string
	 */
	protected $long_description_html;

	/**
	 * @var Tags
	 */
	protected $tags;

	/**
	 * @phpstan-param DocArray $data
	 */
	public static function fromData( array $data ): self {
		$instance = new self();

		return $instance->setData( $data );
	}

	/**
	 * @phpstan-param DocArray $data
	 */
	protected function setData( array $data ): self {
		$this->description = $data['description'];
		$this->long_description = $data['long_description'];
		$this->long_description_html = $data['long_description_html'];
		$this->tags = Tags::fromData( $data['tags'] );

		return $this;
	}
}
