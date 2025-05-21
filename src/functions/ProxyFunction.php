<?php

namespace Hiraeth\Velocity;

class ProxyFunction
{
	/**
	 * @param array<string, mixed> $context
	 */
	public function __invoke(array &$context, string ...$blocks): bool
	{
		if (!count($blocks)) {
			return $context['_velocity_']['proxy']['active'];
		}

		return count(array_intersect($blocks, $context['_velocity_']['proxy']['blocks']));
	}
}
