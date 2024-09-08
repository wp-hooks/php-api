<?php
declare(strict_types=1);

namespace WPHooks;

/**
 * @phpstan-import-type TagArray from Tag
 * @phpstan-type TagsArray list<TagArray>
 * @implements \IteratorAggregate<int, Tag>
 */
final class Tags implements \Countable, \IteratorAggregate {
	/**
	 * @var array<int, Tag>
	 * @phpstan-var list<Tag>
	 */
	private array $tags;

	/**
	 * @phpstan-param TagsArray $data
	 */
	public static function fromData( array $data ): self {
		$instance = new self();

		return $instance->setData( $data );
	}

	public function count(): int {
		return count( $this->tags );
	}

	public function countParams(): int {
		return count( $this->getParams() );
	}

	/**
	 * @return \Traversable<int, Tag>
	 */
	public function getIterator(): \Traversable {
		return new \ArrayIterator( $this->tags );
	}

	/**
	 * @return array<int, Tag>
	 * @phpstan-return list<Tag>
	 */
	public function all(): array {
		return iterator_to_array( $this );
	}

	/**
	 * @return array<int, Tag>
	 * @phpstan-return list<Tag>
	 */
	public function getParams(): array {
		return $this->getByType( 'param' );
	}

	public function getSince(): string {
		foreach ( $this->tags as $tag ) {
			if ( $tag->getName() === 'since' ) {
				$since = $tag->getContent();

				if ( strpos( $since, 'MU' ) !== false ) {
					$since = '3.0.0';
				}

				return $since;
			}
		}

		return '';
	}

	/**
	 * @return array<int, Tag>
	 * @phpstan-return list<Tag>
	 */
	public function getByType( string $type ): array {
		$tags = [];

		foreach ( $this->tags as $tag ) {
			if ( $tag->getName() === $type ) {
				$tags[] = $tag;
			}
		}

		return $tags;
	}

	/**
	 * @return ?array<int, string>
	 * @phpstan-return ?list<string>
	 */
	public function getReturnTypes(): ?array {
		foreach ( $this->tags as $tag ) {
			if ( $tag->getName() === 'param' ) {
				return $tag->getTypes();
			}
		}

		return null;
	}

	public function getReturnTypeString(): ?string {
		$returnTypes = $this->getReturnTypes();

		if ( $returnTypes === null ) {
			return null;
		}

		return implode( '|', $returnTypes );
	}

	/**
	 * @phpstan-param TagsArray $data
	 */
	private function setData( array $data ): self {
		$this->tags = array_map( [ '\\WPHooks\\Tag', 'fromData' ], $data );

		return $this;
	}
}
