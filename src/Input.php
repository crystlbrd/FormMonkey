<?php


namespace crystlbrd\FormMonkey;


abstract class Input
{
    /**
     * @var string Input name
     */
    protected $Name;

    /**
     * @var array Additional options
     */
    protected $Options;

    /**
     * Input constructor.
     * @param string $name
     * @param array $options
     */
    public function __construct(string $name, array $options)
    {
        $this->Name = $name;
        $this->Options = $options;
    }

    /**
     * Gets the input name
     * @return string
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * Generates the HTML
     * @return string
     */
    public abstract function render(): string;
}