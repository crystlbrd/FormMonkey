<?php

namespace crystlbrd\FormMonkey\Test;

use crystlbrd\FormMonkey\Form;
use crystlbrd\FormMonkey\Input;
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    public function testCreateInput()
    {
        $form = new Form('test_form');
        $input = $form->createInput('test_input', 'string');

        self::assertInstanceOf(Input::class, $input);
        self::assertInstanceOf(Input\StringInput::class, $input);
    }
}