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
			return (bool) count($context['_velocity_']['proxy']['blocks']);
		}

		if (array_intersect($blocks, $context['_velocity_']['proxy']['blocks'])) {
			return in_array($context['_velocity_']['proxy']['active'], $blocks);
		} else {
			return TRUE;
		}
	}
}
