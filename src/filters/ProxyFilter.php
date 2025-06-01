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
	public function __invoke(array &$context, string $layout, string ...$blocks): string
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

		$active = $context['request']->getHeaderLine('HX-Request');
		$target = $context['request']->getHeaderLine('HX-Target');

		if ($active && (!$target || in_array($target, $blocks))) {
			$layout = '@layouts/velocity/proxy.html';
		} else {
			$blocks = [];

		}

		$context['_velocity_']['proxy'] = [
			'blocks' => $blocks,
			'target' => $target
		];

		return $layout;
	}
}
