<?php

namespace App\FormLib;

class Field{
    use Hydrator;

    private ?string $type = null;
    private ?string $name = null;
    private ?string $value = null;
    private ?string $label = null;
    private ?string $placeholder = null;
    private ?string $errorMessage = null;
    private array $options = [];

    public function __construct(array $options = []){
        if(isset($_POST[$options['name']])){
            $options['value'] = $_POST[$options['name']];
        }

        if($options){
            $this->hydrate($options);
        }
        if($this->getValue() !== null && $this->getOptions()['constraints']){
            foreach($this->getOptions()['constraints'] as $constraint){
                $this->checkConstrainst($constraint);
            }
        }
    }

    public function getType():?string{
        return $this->type;
    }
    public function getName():?string{
        return $this->name;
    }
    public function getValue():?string{
        return $this->value;
    }
    public function getLabel():?string{
        return $this->label;
    }
    public function getPlaceholder():?string{
        return $this->placeholder;
    }
    public function getErrorMessage():?string{
        return $this->errorMessage;
    }
    public function getOptions():array{
        return $this->options;
    }

    public function setType(string $type):void{
        $this->type = $type;
    }
    public function setName(string $name):void{
        $this->name = $name;
    }
    public function setValue(string $value):void{
        $this->value = $value;
    }
    public function setLabel(string $label):void{
        $this->label = $label;
    }
    public function setPlaceholder(string $placeholder):void{
        $this->placeholder = $placeholder;
    }
    public function setErrorMessage(string $errorMessage):void{
        $this->errorMessage = $this->getErrorMessage().' '.$errorMessage;
    }
    public function setOptions(array $options):void{
        $this->options = $options;
    }

    public function checkConstrainst($constraint):void{
        if (!preg_match($constraint['regex'], $this->getValue())){
            $this->setErrorMessage('<p>'.$constraint['message'].'</p>');
        }
    }

    public function generateView(){
        $input = null;
            $input .= '<div class="form-group">';
        if($this->getLabel() != null){
            $input .= '<label for="'.$this->getOptions()['id'].'">'.$this->getLabel().'</label>';
        }
        if($this->getErrorMessage() != null){
            $input .= '<span>'.$this->getErrorMessage().'</span>';
        }
        switch($this->getType()){
            case 'text':
            case 'email':
            case 'password':
                $input .= $this->generateInputText();
                break; 
            case 'checkbox':
                $input .= $this->generateInputCheckbox();
                break;
            case 'button':
            case 'submit':
                $input = $this->generateButton();
                break;
            default:
                throw new \RuntimeException('Le type de Field '.$this->getType().' est inconnu');
        }
        $input .= '</div>';
        return $input;
    }

    private function genericsAttributs(){
        $input = '';
        if(isset($this->getOptions()['readonly'])){
            if((bool)$this->getOptions()['readonly'] === true){
                $input .= 'readonly ';
            }
        }
        if(isset($this->getOptions()['required'])){
            if((bool)$this->getOptions()['required'] === true){
                $input .= 'required ';
            }
        }
        if(isset($this->getOptions()['disabled'])){
            if((bool)$this->getOptions()['disabled'] === true){
                $input .= 'disabled ';
            }
        }
        if(isset($this->getOptions()['value'])){
            $input .= 'value="'.$this->getOptions()['value'].'" ';
        }
        if(isset($this->getOptions()['id'])){
            $input .= 'id="'.$this->getOptions()['id'].'" ';
        }
        return $input;
    }

    private function generateInputCheckbox():string{
        $input = '<input type="'.$this->getType().'" name="'.$this->getName().'" ';
        if(isset($this->getOptions()['checked'])){
            if((bool)$this->getOptions()['checked'] === true){
                $input .= 'checked ';
            } 
        }
        $input .= $this->genericsAttributs();
        $input .= '/>';

        return $input;
    }

    private function generateButton():string{
        $input = '<input type="'.$this->getType().'" name="'.$this->getName().'" ';
        $input .= $this->genericsAttributs();
        $input .= '/>';

        return $input;
    }

    private function generateInputText():string{
        $input = '<input type="'.$this->getType().'" name="'.$this->getName().'" class="form-control" ';
        $input .= 'value="'.$this->getValue().'" ';
        $input .= 'placeholder="'.$this->getPlaceholder().'" ';
        if(isset($this->getOptions()['minlength'])){
            if((int)$this->getOptions()['minlength'] > 0){
                $input .= 'minlength="'.$this->getOptions()['minlength'].'" ';
            } else {
                throw new \RuntimeException('Le minlength doit être supérieur à 0');
            }
        }
        if(isset($this->getOptions()['maxlength'])){
            if((int)$this->getOptions()['maxlength'] > 0){
                $input .= 'maxlength="'.$this->getOptions()['maxlength'].'" ';
            } else {
                throw new \RuntimeException('Le maxlength doit être supérieur à 0');
            }
        }
        $input .= $this->genericsAttributs();
        $input .= '/>';

        return $input;
    }
}