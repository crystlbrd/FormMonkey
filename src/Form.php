<?php


namespace crystlbrd\FormMonkey;


use crystlbrd\FormMonkey\Exceptions\FormException;

class Form
{
    /**
     * @var array Inputs
     */
    protected $Inputs = [];

    /**
     * @var string form name
     */
    public $Name;

    /**
     * @var string form action link
     */
    public $Action;

    /**
     * @var string form sending method
     */
    public $Method = 'POST';

    /**
     * @var string form encryption type
     */
    public $Enctype = 'application/x-www-form-urlencoded';


    /**
     * Form constructor.
     * @param string $name form name
     */
    public function __construct(string $name)
    {
        $this->Name = $name;
    }

    /**
     * Creates a new input field
     * @param string $name input name
     * @param string $type input type
     * @param array $options additional options
     * @return Input
     * @throws FormException
     */
    public function createInput(string $name, string $type, array $options = []): Input
    {
        $namespace = '\\crystlbrd\\FormMonkey\\Input\\';
        $className = ucfirst($type) . 'Input';

        if (class_exists($namespace . $className)) {
            return new $className($name, $options);
        } else {
            throw new FormException('Invalid input type "' . $type . '"!');
        }
    }

    /**
     * Creates a new input field for the form
     * @param string $name input name
     * @param string $type input type
     * @param array $options additional options
     * @throws FormException
     */
    public function newInput(string $name, string $type, array $options = []): void
    {
        $this->addInput(
            $this->createInput($name, $type, $options)
        );
    }

    /**
     * Adds an input to the form
     * @param Input $input input
     * @throws FormException
     */
    public function addInput(Input $input): void
    {
        $name = $input->getName();
        if (!$this->inputExists($name)) {
            $this->Inputs[$name] = $input;
        } else {
            throw new FormException('Input with name "' . $name . '" already defined!');
        }
    }

    /**
     * Checks, if an input with name is defined
     * @param string $name input name
     * @return bool
     */
    public function inputExists(string $name): bool
    {
        return isset($this->Inputs[$name]);
    }

    /**
     * Gets an input field
     * @param string $name input name
     * @return Input
     * @throws FormException
     */
    public function getInput(string $name): Input
    {
        if ($this->inputExists($name)) {
            return $this->Inputs[$name];
        } else {
            throw new FormException('Input with name "' . $name . '" not defined!');
        }
    }

    /**
     * Generates the HTML form
     * @return string
     */
    public function render(): string
    {
        $arr = $this->toArray();
        $html = $arr['start'];
        $html .= implode('', $arr['input']);
        $html .= '</form>';

        return $html;
    }

    /**
     * Generates the HTML and serves the start tag and inputs separately
     * @return array
     */
    public function toArray(): array
    {
        // start tag
        $arr = [];
        $arr['start'] = '<form name="' . $this->Name . '" method="' . $this->Method . '" enctype="' . $this->Enctype . '"';

        if (is_string($this->Action)) {
            $arr['start'] .= ' action="' . $this->Action . '"';
        }

        $arr['start'] = '>';

        // Inputs
        foreach ($this->Inputs as $input) {
            $arr['input'][$input->getName()] = $input->render();
        }

        return $arr;
    }


    public function __toString(): string
    {
        return $this->render();
    }
}