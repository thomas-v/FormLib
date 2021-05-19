<?php

namespace App\FormLib;

class Form{

    use Hydrator;

    private ?string $action = null;
    private ?string $method = null;
    private array $fields = [];
    private bool $stateValidation = false;

    public function __construct(array $options = []){
        if($options){
            $this->hydrate($options);
        }
    }

    public function getAction():?string{
        return $this->action;
    }
    public function getMethod():?string{
        return $this->method;
    }
    public function getFields():array{
        return $this->fields;
    }
    public function getStateValidation():bool{
        return $this->stateValidation;
    }

    public function setAction(string $action = null):void{
        $this->action = $action;
    }
    public function setMethod(string $method = 'POST'):void{
        $this->method = $method;
    }
    public function setStateValidation(bool $stateValidation):void{
        $this->stateValidation = $stateValidation;
    }

    public function addField(Field $field){
        $this->fields[] = $field;
    }

    public function generateFormView():string{
        $form = '<form action="'.$this->getAction().'" method="'.$this->getMethod().'">';
        foreach($this->getFields() as $field){
            $form .= $field->generateView();
        }
        $form .= '</form>';
        return $form;
    }

    public function isValid():bool{
        foreach($this->getFields() as $field){
            if($field->getErrorMessage() !== null){
                return false;
            }
        }
        return true;
    }
}