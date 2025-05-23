<?php

namespace Hiraeth\Velocity;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class ProxyFilter
{
	/**
	 * @param array<string, mixed> $context
	 * @param string $parent
	 * @param string ...$blocks
	 */
	public function __invoke(array &$context, string $target, string ...$blocks): string
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

		$active   = $context['request']->getHeaderLine('HX-Target');
		$do_proxy = in_array($active, $blocks);

		if ($do_proxy) {
			$target = '@layouts/velocity/proxy.html';
		} else {
			$blocks = [];
		}

		$context['_velocity_']['proxy'] = [
			'blocks' => $blocks,
			'active' => $active
		];

		return $target;
	}
}
