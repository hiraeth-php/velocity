<?php

namespace Hiraeth\Velocity;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class ProxyFilter
{
	/**
	 * @param array<string, mixed> $context
	 * @param string $parent
	 * @param string $block
	 */
	public function __invoke(array &$context, string $parent, string ...$blocks): string
	{
		if (!count($blocks)) {
			throw new InvalidArgumentException(sprintf(
				'Cannot proxy, at least one block must be specified.'
			));
		}

		if (!$context['request'] instanceof ServerRequestInterface) {
			throw new InvalidArgumentException(sprintf(
				'Cannot proxy, context lost the request.'
			));
		}

		if ($context['request']->getHeaderLine('Velocity-Proxy') == 'false') {
			$context['_velocity_']['proxy'] = [];
			return $parent;
		}

		$context['_velocity_']['proxy'] = $blocks;

		return '@layouts/velocity/proxy.html';
	}
}
