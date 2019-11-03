<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class CroakForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('content', Field::TEXTAREA, [
                'content' => 'required'
            ])
            ->add('tags', Field::TEXT, [
                'tags' => 'required'
            ]);
    }
}
