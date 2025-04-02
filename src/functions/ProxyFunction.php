<?php

namespace Hiraeth\Velocity;

class ProxyFunction
{
	/**
	 * @param array<string, mixed> $context
	 */
	public function __invoke(array &$context): bool
	{
		return count($context['_velocity_']['proxy'] ?? []) > 0;
	}
}
