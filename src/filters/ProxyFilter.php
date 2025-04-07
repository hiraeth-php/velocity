<?php

namespace Hiraeth\Velocity;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

class ProxyFilter
{
	/**
	 * @param array<string, mixed> $context
	 * @param string $parent
	 * @param array $blocks
	 * @param bool $always Always proxy if we're using HTMX (only extend for non-HTMX)
	 */
	public function __invoke(array &$context, string $target, array $blocks, bool $always = FALSE): string
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

		$is_htmx  = $context['request']->getHeaderLine('HX-Request') == 'true';
		$do_proxy = $context['request']->getHeaderLine('VF-Proxy') != 'false';

		if ($is_htmx && ($do_proxy || $always)) {
			$target = '@layouts/velocity/proxy.html';
		} else {
			$blocks = [];
		}

		$context['_velocity_']['proxy'] = [
			'blocks' => $blocks,
			'active' => $do_proxy
		];

		return $target;
	}
}
