<?php
declare(strict_types=1);

namespace WPHooks;

/**
 * @template TArray of array
 */
trait ArrayInterchange {

	/**
	 * @phpstan-param TArray $data
	 */
	public static function fromData( array $data ): self {
		$instance = new self();

		return $instance->setData( $data );
	}

	/**
	 * @phpstan-param TArray $data
	 */
	protected function setData( array $data ): self {
		$this->data = $data;

		return $this;
	}

}
