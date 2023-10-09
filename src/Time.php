<?php
/*
 * (c) Minh Vuong <vuongxuongminh@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace Hasura\GraphQLScalars;

final class Time extends AbstractDateTime
{
    public string $name = 'time';

    protected function getParseFormat(): string
    {
        return 'H:i:s|';
    }

    protected function getSerializeFormat(): string
    {
        return 'H:i:s';
    }
}
