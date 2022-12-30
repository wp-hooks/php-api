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
final class Doc {
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

	public function getDescription(): string {
		return $this->description;
	}

	public function getLongDescription(): string {
		return $this->long_description;
	}

	public function getLongDescriptionHTML(): string {
		return $this->long_description_html;
	}

	public function getTags(): Tags {
		return $this->tags;
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
