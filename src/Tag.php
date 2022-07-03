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
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $content;

	/**
	 * @var ?array<int, string>
	 */
	protected $types;

	/**
	 * @var ?string
	 */
	protected $variable;

	/**
	 * @var ?string
	 */
	protected $link;

	/**
	 * @var ?string
	 */
	protected $refers;

	/**
	 * @var ?string
	 */
	protected $description;

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
		$this->name = $data['name'];
		$this->content = $data['content'];
		$this->types = $data['types'] ?? null;
		$this->variable = $data['variable'] ?? null;
		$this->link = $data['link'] ?? null;
		$this->refers = $data['refers'] ?? null;
		$this->description = $data['description'] ?? null;

		return $this;
	}
}
