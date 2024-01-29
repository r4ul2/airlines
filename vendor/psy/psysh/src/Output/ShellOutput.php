<?php


namespace Psy\Output;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\ConsoleOutput;


class ShellOutput extends ConsoleOutput
{
    const NUMBER_LINES = 128;

    private $paging = 0;

    /** @var OutputPager */
    private $pager;

    /** @var Theme */
    private $theme;

   
    public function __construct($verbosity = self::VERBOSITY_NORMAL, $decorated = null, OutputFormatterInterface $formatter = null, $pager = null, $theme = null)
    {
        parent::__construct($verbosity, $decorated, $formatter);

        $this->theme = $theme ?? new Theme('modern');
        $this->initFormatters();

        if ($pager === null) {
            $this->pager = new PassthruPager($this);
        } elseif (\is_string($pager)) {
            $this->pager = new ProcOutputPager($this, $pager);
        } elseif ($pager instanceof OutputPager) {
            $this->pager = $pager;
        } else {
            throw new \InvalidArgumentException('Unexpected pager parameter: '.$pager);
        }
    }

   
    public function page($messages, int $type = 0)
    {
        if (\is_string($messages)) {
            $messages = (array) $messages;
        }

        if (!\is_array($messages) && !\is_callable($messages)) {
            throw new \InvalidArgumentException('Paged output requires a string, array or callback');
        }

        $this->startPaging();

        if (\is_callable($messages)) {
            $messages($this);
        } else {
            $this->write($messages, true, $type);
        }

        $this->stopPaging();
    }

    /**
     * Start sending output to the output pager.
     */
    public function startPaging()
    {
        $this->paging++;
    }

    /**
     * Stop paging output and flush the output pager.
     */
    public function stopPaging()
    {
        $this->paging--;
        $this->closePager();
    }

    
    public function write($messages, $newline = false, $type = 0)
    {
        if ($this->getVerbosity() === self::VERBOSITY_QUIET) {
            return;
        }

        $messages = (array) $messages;

        if ($type & self::NUMBER_LINES) {
            $pad = \strlen((string) \count($messages));
            $template = $this->isDecorated() ? "<aside>%{$pad}s</aside>: %s" : "%{$pad}s: %s";

            if ($type & self::OUTPUT_RAW) {
                $messages = \array_map([OutputFormatter::class, 'escape'], $messages);
            }

            foreach ($messages as $i => $line) {
                $messages[$i] = \sprintf($template, $i, $line);
            }

            // clean this up for super.
            $type = $type & ~self::NUMBER_LINES & ~self::OUTPUT_RAW;
        }

        parent::write($messages, $newline, $type);
    }

   
    public function doWrite($message, $newline)
    {
        if ($this->paging > 0) {
            $this->pager->doWrite($message, $newline);
        } else {
            parent::doWrite($message, $newline);
        }
    }

    /**
     * Set the output Theme.
     */
    public function setTheme(Theme $theme)
    {
        $this->theme = $theme;
        $this->initFormatters();
    }

    /**
     * Flush and close the output pager.
     */
    private function closePager()
    {
        if ($this->paging <= 0) {
            $this->pager->close();
        }
    }

    /**
     * Initialize output formatter styles.
     */
    private function initFormatters()
    {
        $useGrayFallback = !$this->grayExists();
        $this->theme->applyStyles($this->getFormatter(), $useGrayFallback);
        $this->theme->applyErrorStyles($this->getErrorOutput()->getFormatter(), $useGrayFallback);
    }

    /**
     * Checks if the "gray" color exists on the output.
     */
    private function grayExists(): bool
    {
        try {
            $this->write('<fg=gray></>');
        } catch (\InvalidArgumentException $e) {
            return false;
        }

        return true;
    }
}
