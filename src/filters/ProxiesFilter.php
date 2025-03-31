<?php

namespace Hiraeth\Velocity;

use Hiraeth\Application;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class ProxiesFilter
{
	/**
	 * @param array<string, mixed> $context
	 * @param string $parent
	 * @param string $block
	 */
	public function __invoke(array &$context, string $parent, string $block): string
	{
		if (!$context['request'] instanceof ServerRequestInterface) {
			throw new InvalidArgumentException('Invalid request');
		}

		if (!$context['app'] instanceof Application) {
			throw new InvalidArgumentException('Invalid app');
		}

		if ($context['request']->getHeaderLine('Velocity-Proxy') == 'false') {
			return $parent;
		}

		$context['__velocity__']['proxy'] = $block;

		return '@layouts/velocity/proxy.html';
	}
}
