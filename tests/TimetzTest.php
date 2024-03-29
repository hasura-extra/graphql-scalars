<?php
/*
 * (c) Minh Vuong <vuongxuongminh@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace Hasura\GraphQLScalars\Tests;

use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use Hasura\GraphQLScalars\Timetz;

class TimetzTest extends AbstractDateTimeTestCase
{
    public function testName(): void
    {
        $this->assertSame('timetz', $this->makeInstance()->name);
    }

    protected function makeInstance(): ScalarType
    {
        return new Timetz();
    }

    public static function valuesToSerialize(): iterable
    {
        yield 'date' => [
            new \DateTimeImmutable('2022-02-02'),
            '00:00:00+00:00',
        ];
        yield 'datetime' => [
            new \DateTimeImmutable('2022-02-02T02:02:02'),
            '02:02:02+00:00',
        ];
        yield 'time' => [
            new \DateTimeImmutable('01:01:01'),
            '01:01:01+00:00',
        ];
        yield 'time with timezone' => [
            new \DateTimeImmutable('02:02:02+02:02'),
            '02:02:02+02:02',
        ];
    }

    public static function valuesToParse(): iterable
    {
        yield 'immutable instance' => [
            \DateTimeImmutable::createFromFormat('H:i:sP', '01:01:01+00:00'),
            \DateTimeImmutable::createFromFormat('H:i:sP|', '01:01:01+00:00'),
        ];
        yield '01:01:01+01:01' => [
            '01:01:01+01:01',
            \DateTimeImmutable::createFromFormat('H:i:sP|', '01:01:01+01:01'),
        ];
        yield '02:02:02+02:02' => [
            '02:02:02+02:02',
            \DateTimeImmutable::createFromFormat('H:i:sP|', '02:02:02+02:02'),
        ];
    }

    public static function nodesToParseLiteral(): iterable
    {
        yield '01:01:01+01:01' => [
            new StringValueNode([
                'value' => '01:01:01+01:01',
            ]),
            \DateTimeImmutable::createFromFormat('H:i:sP|', '01:01:01+01:01'),
        ];
        yield '02:02:02+02:02' => [
            new StringValueNode([
                'value' => '02:02:02+02:02',
            ]),
            \DateTimeImmutable::createFromFormat('H:i:sP|', '02:02:02+02:02'),
        ];
    }

    public static function invalidValuesToParse(): iterable
    {
        yield from parent::invalidValuesToParse();
        yield 'datetime' => ['2022-02-02T02:02:02'];
        yield 'datetime with timezone' => ['2022-02-02T02:02:02+02:02'];
        yield 'date' => ['2022-02-02'];
        yield 'time' => ['02:02:02'];
    }
}
