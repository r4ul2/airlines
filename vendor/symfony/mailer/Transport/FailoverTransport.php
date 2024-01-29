<?php



namespace Symfony\Component\Mailer\Transport;


class FailoverTransport extends RoundRobinTransport
{
    private ?TransportInterface $currentTransport = null;

    protected function getNextTransport(): ?TransportInterface
    {
        if (null === $this->currentTransport || $this->isTransportDead($this->currentTransport)) {
            $this->currentTransport = parent::getNextTransport();
        }

        return $this->currentTransport;
    }

    protected function getInitialCursor(): int
    {
        return 0;
    }

    protected function getNameSymbol(): string
    {
        return 'failover';
    }
}
