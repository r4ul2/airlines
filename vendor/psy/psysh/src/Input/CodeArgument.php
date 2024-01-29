<?php



namespace Psy\Input;

use Symfony\Component\Console\Input\InputArgument;

/
class CodeArgument extends InputArgument
{
    /**
     * Constructor.
     *
     * @param string 
     * @param int   
     * @param string 
     * @param mixed  
     *
     * @throws \InvalidArgumentException When argument mode is not valid
     */
    public function __construct(string $name, int $mode = null, string $description = '', $default = null)
    {
        if ($mode & InputArgument::IS_ARRAY) {
            throw new \InvalidArgumentException('Argument mode IS_ARRAY is not valid');
        }

        parent::__construct($name, $mode, $description, $default);
    }
}
