<?php
declare(strict_types=1);

namespace WPHooks;

/**
 * @phpstan-import-type TagArray from Tag
 * @phpstan-type TagsArray array<int, TagArray>
 * @implements \IteratorAggregate<int, Tag>
 */
final class Tags implements \Countable, \IteratorAggregate {
	/**
	 * @var array<int, Tag>
	 * @phpstan-var list<Tag>
	 */
	protected $tags;

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
		$params = [];

		foreach ( $this as $tag ) {
			if ( $tag->getName() === 'param' ) {
				$params[] = $tag;
			}
		}

		return $params;
	}

	/**
	 * @phpstan-param TagsArray $data
	 */
	protected function setData( array $data ): self {
		$this->tags = array_map( [ '\\WPHooks\\Tag', 'fromData' ], $data );

		return $this;
	}
}
