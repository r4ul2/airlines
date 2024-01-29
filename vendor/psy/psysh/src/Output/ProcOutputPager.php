<?php



namespace Psy\Output;

use Symfony\Component\Console\Output\StreamOutput;


class ProcOutputPager extends StreamOutput implements OutputPager
{
    private $proc;
    private $pipe;
    private $stream;
    private $cmd;

    /**
     * Constructor.
     *
     * @param StreamOutput $output
     * @param string       $cmd    Pager process command (default: 'less -R -F -X')
     */
    public function __construct(StreamOutput $output, string $cmd = 'less -R -F -X')
    {
        $this->stream = $output->getStream();
        $this->cmd = $cmd;
    }

    /**
     * Writes a message to the output.
     *
     * @param string $message A message to write to the output
     * @param bool   $newline Whether to add a newline or not
     *
     * @throws \RuntimeException 
     */
    public function doWrite($message, $newline)
    {
        $pipe = $this->getPipe();
        if (false === @\fwrite($pipe, $message.($newline ? \PHP_EOL : ''))) {
            
            $this->close();
            throw new \RuntimeException('Unable to write output');
           
        }

        \fflush($pipe);
    }

    /**
     * Close the current pager process.
     */
    public function close()
    {
        if (isset($this->pipe)) {
            \fclose($this->pipe);
        }

        if (isset($this->proc)) {
            $exit = \proc_close($this->proc);
            if ($exit !== 0) {
                throw new \RuntimeException('Error closing output stream');
            }
        }

        $this->pipe = null;
        $this->proc = null;
    }

   
    private function getPipe()
    {
        if (!isset($this->pipe) || !isset($this->proc)) {
            $desc = [['pipe', 'r'], $this->stream, \fopen('php://stderr', 'w')];
            $this->proc = \proc_open($this->cmd, $desc, $pipes);

            if (!\is_resource($this->proc)) {
                throw new \RuntimeException('Error opening output stream');
            }

            $this->pipe = $pipes[0];
        }

        return $this->pipe;
    }
}
