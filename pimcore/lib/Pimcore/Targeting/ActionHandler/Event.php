<?php

declare(strict_types=1);

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

namespace Pimcore\Targeting\ActionHandler;

use Pimcore\Model\Tool\Targeting\Rule;
use Pimcore\Targeting\Model\VisitorInfo;
use Pimcore\Targeting\Storage\TargetingStorageInterface;

class Event implements ActionHandlerInterface
{
    /**
     * @var TargetingStorageInterface
     */
    private $storage;

    public function __construct(TargetingStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @inheritDoc
     */
    public function apply(VisitorInfo $visitorInfo, array $action, Rule $rule = null)
    {
        $key = $action['key'] ?? null;
        if (!$key) {
            return;
        }

        $events = $this->storage->get($visitorInfo, 'events', []);

        $events[] = [
            'key'   => $key,
            'value' => $action['value'] ?? null,
            'date'  => new \DateTimeImmutable()
        ];

        $this->storage->set($visitorInfo, 'events', $events);
    }
}
