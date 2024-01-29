<?php



declare(strict_types=1);

namespace Ramsey\Uuid\Generator;

use Ramsey\Uuid\Exception\NameException;
use Ramsey\Uuid\UuidInterface;
use ValueError;

use function hash;


class DefaultNameGenerator implements NameGeneratorInterface
{
    /** @psalm-pure */
    public function generate(UuidInterface $ns, string $name, string $hashAlgorithm): string
    {
        try {
            /** @var string|bool $bytes */
            $bytes = @hash($hashAlgorithm, $ns->getBytes() . $name, true);
        } catch (ValueError $e) {
            $bytes = false; // keep same behavior than PHP 7
        }

        if ($bytes === false) {
            throw new NameException(sprintf(
                'Unable to hash namespace and name with algorithm \'%s\'',
                $hashAlgorithm
            ));
        }

        return (string) $bytes;
    }
}
