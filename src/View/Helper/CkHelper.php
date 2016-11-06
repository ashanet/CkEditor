<?php
namespace CkEditor\View\Helper;

use Cake\View\Helper;

class CkHelper extends Helper
{
    public $helpers = ['Html', 'Form'];

    /**
    * Extention of the Form Helper to insert CK Editor for a form input
    *
    * @param string $input The name of the field, can be field_name or Model.field_name
    * @param array $options Options include $options['label'] for a custom label
    * @param array $ckEditorOptions This will pass any options from http://docs.ckeditor.com/#!/guide/dev_configuration to CK Editor
    */
    public function input($input, $options = [], $ckEditorOptions = []) {
        $lines = [];

        $lines[] = $this->Html->script('//cdn.ckeditor.com/4.4.5.1/standard/ckeditor.js');

        if (!empty($options['label'])) {
            $lines[] = $this->Form->label($input, $options['label']);
        } else {
            $lines[] = $this->Form->label($input);
        }

        $defaultOptions = ['type' => 'textarea', 'label' => false, 'error' => false, 'required' => false];

        $options = array_merge($options, $defaultOptions);

        $lines[] = $this->Form->error($input);
        $lines[] = $this->Form->input($input, $options);

        $lines[] = $this->generateScript($input, $ckEditorOptions);

        return implode($lines, PHP_EOL);
    }

    /**
     * Generates the script for CK Editor
     * @param  string $input The name of the field, can be field_name or Model.field_name
     * @param  array  $options Any passed options, from http://docs.ckeditor.com/#!/guide/dev_configuration
     *         These should be passed as an array, e.g. ['fullPage' => true]
     * @return string
     */
    protected function generateScript($input, $options = []) {
        $script = '<script type="text/javascript">';
        $script .= 'CKEDITOR.replace(\'';
        $script .= $input;
        $script .= "'";

        if ($options) {
            $script .= ', {';

            foreach ($options as $key => $value) {
                $script .= "'$key' : '$value',";
            }

            $script .= '}';
        }

        $script .= ');';
        $script .= '</script>';

        return $script;
    }
}