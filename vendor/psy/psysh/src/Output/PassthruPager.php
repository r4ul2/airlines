<?php



namespace Psy\Output;

use Symfony\Component\Console\Output\StreamOutput;


class PassthruPager extends StreamOutput implements OutputPager
{
    /**
     * Constructor.
     *
     * @param StreamOutput $output
     */
    public function __construct(StreamOutput $output)
    {
        parent::__construct($output->getStream());
    }

    /**
     * Close the current pager process.
     */
    public function close()
    {
        
    }
}
