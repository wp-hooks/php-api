<?php
declare(strict_types=1);

namespace WPHooks;

/**
 * @phpstan-import-type DocArray from Doc
 * @phpstan-type HookArray array{
 *   name: string,
 *   aliases?: array<int, string>,
 *   file: string,
 *   type: string,
 *   doc: DocArray,
 *   args: int,
 * }
 */
class Hook {
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var ?array<int, string>
	 */
	protected $aliases;

	/**
	 * @var string
	 */
	protected $file;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var Doc
	 */
	protected $doc;

	/**
	 * @var int
	 */
	protected $args;

	/**
	 * @phpstan-param HookArray $data
	 */
	public static function fromData( array $data ): self {
		$instance = new self();

		return $instance->setData( $data );
	}

	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return ?array<int, string>
	 */
	public function getAliases(): ?array {
		return $this->aliases;
	}

	public function getFile(): string {
		return $this->file;
	}

	public function getType(): string {
		return $this->type;
	}

	public function getDoc(): Doc {
		return $this->doc;
	}

	public function getArgs(): int {
		return $this->args;
	}

	/**
	 * @phpstan-param HookArray $data
	 */
	protected function setData( array $data ): self {
		$this->name = $data['name'];
		$this->aliases = $data['aliases'] ?? null;
		$this->file = $data['file'];
		$this->type = $data['type'];
		$this->doc = Doc::fromData( $data['doc'] );
		$this->args = $data['args'];

		return $this;
	}
}
