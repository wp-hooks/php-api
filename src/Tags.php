<?php
declare(strict_types=1);

namespace WPHooks;

/**
 * @phpstan-import-type TagArray from Tag
 * @phpstan-type TagsArray array<int, TagArray>
 */
class Tags {
	/**
	 * @var array<int, Tag>
	 */
	protected $tags;

	/**
	 * @phpstan-param TagsArray $data
	 */
	public static function fromData( array $data ): self {
		$instance = new self();

		return $instance->setData( $data );
	}

	/**
	 * @return array<int, Tag>
	 */
	public function all(): array {
		return $this->tags;
	}

	/**
	 * @phpstan-param TagsArray $data
	 */
	protected function setData( array $data ): self {
		$this->tags = array_map( [ '\\WPHooks\\Tag', 'fromData' ], $data );

		return $this;
	}
}
