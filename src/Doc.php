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
	 * @use ArrayInterchange<DocArray>
	 */
	use ArrayInterchange;

	/**
	 * @var array
	 * @phpstan-var DocArray
	 */
	protected $data;

}
