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
	private string $description;
	private string $long_description;
	private string $long_description_html;
	private Tags $tags;

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
	 * @return array<int, Tag>
	 * @phpstan-return list<Tag>
	 */
	public function getTagsByType( string $type ): array {
		return $this->tags->getByType( $type );
	}

	/**
	 * @return array<int, Tag>
	 * @phpstan-return list<Tag>
	 */
	public function getParams(): array {
		return $this->tags->getParams();
	}

	public function getSince(): string {
		return $this->tags->getSince();
	}

	public function getReturnTypeString(): ?string {
		return $this->tags->getReturnTypeString();
	}

	/**
	 * @return ?array<int, string>
	 * @phpstan-return ?list<string>
	 */
	public function getReturnTypes(): ?array {
		return $this->tags->getReturnTypes();
	}

	public function countParams(): int {
		return $this->tags->countParams();
	}

	/**
	 * @phpstan-param DocArray $data
	 */
	private function setData( array $data ): self {
		$required = [ 'description', 'long_description', 'long_description_html', 'tags' ];

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

		$this->description = $data['description'];
		$this->long_description = $data['long_description'];
		$this->long_description_html = $data['long_description_html'];
		$this->tags = Tags::fromData( $data['tags'] );

		return $this;
	}
}
