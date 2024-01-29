<?php



namespace Symfony\Component\Console\Helper;


 
interface HelperInterface
{
    /**
     * Sets the helper set associated with this helper.
     *
     * @return void
     */
    public function setHelperSet(?HelperSet $helperSet);

    /**
     * Gets the helper set associated with this helper.
     */
    public function getHelperSet(): ?HelperSet;

    /**
     * Returns the canonical name of this helper.
     *
     * @return string
     */
    public function getName();
}
