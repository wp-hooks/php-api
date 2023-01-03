<?php
declare(strict_types=1);

namespace WPHooks;

/**
 * @phpstan-type TagArray array{
 *   name: string,
 *   content: string,
 *   types?: list<string>,
 *   variable?: string,
 *   link?: string,
 *   refers?: string,
 *   description?: string,
 * }
 */
final class Tag {
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
	 * @phpstan-var ?list<string>
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

	public function getName(): string {
		return $this->name;
	}

	public function getContent(): string {
		return $this->content;
	}

	/**
	 * @return ?array<int, string>
	 */
	public function getTypes(): ?array {
		return $this->types;
	}

	/**
	 * @return ?string
	 */
	public function getVariable(): ?string {
		return $this->variable;
	}

	/**
	 * @return ?string
	 */
	public function getLink(): ?string {
		return $this->link;
	}

	/**
	 * @return ?string
	 */
	public function getRefers(): ?string {
		return $this->refers;
	}

	/**
	 * @return ?string
	 */
	public function getDescription(): ?string {
		return $this->description;
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
