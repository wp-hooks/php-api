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
	private string $name;
	private string $content;

	/**
	 * @var ?array<int, string>
	 * @phpstan-var ?list<string>
	 */
	private ?array $types;

	private ?string $variable;
	private ?string $link;
	private ?string $refers;
	private ?string $description;

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
	 * @phpstan-return ?list<string>
	 */
	public function getTypes(): ?array {
		return $this->types;
	}

	public function getVariable(): ?string {
		return $this->variable;
	}

	public function getLink(): ?string {
		return $this->link;
	}

	public function getRefers(): ?string {
		return $this->refers;
	}

	public function getDescription(): ?string {
		return $this->description;
	}

	/**
	 * @phpstan-param TagArray $data
	 */
	private function setData( array $data ): self {
		$required = [ 'name', 'content' ];
		foreach ( $required as $key ) {
			if ( ! array_key_exists( $key, $data ) ) {
				throw new \InvalidArgumentException(
					sprintf(
						'Missing required key "%s" in data array',
						$key,
					)
				);
			}
		}

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
