<?php

namespace Craft;

class Hut6CalculationField_CalculationFieldType extends BaseFieldType
{   

    private $options = array();

    public function getName()
    {
        return Craft::t('Calculation');
    }

    public function defineContentAttribute()
    {
        return AttributeType::String;
    }

    protected function defineSettings()
    {
        return array(
            'hut6Calculation' => array(AttributeType::String)
        );
    }

    public function getSettingsHtml()
    {
        return craft()->templates->render('hut6calculationfield/settings', array(
            'settings' => $this->getSettings()
        ));
    }

    public function getInputHtml($name, $value)
    {
        // Get our field settings
        $settings = $this->getSettings();
        
        return craft()->templates->render('hut6calculationfield/input', array(
            'name'  => $name,
            'value' => $value
        ));
    }
    
    public function onAfterElementSave()
    {
        
        $oldTemplatesPath = craft()->path->getTemplatesPath();
        
        craft()->path->setTemplatesPath(craft()->path->getSiteTemplatesPath());
        
        $value = craft()->templates->renderString(
            $this->getSettings()->hut6Calculation,
            array ("object" => $this->element)
        );
        
        craft()->path->setTemplatesPath($oldTemplatesPath);
        
        $this->element->content->setAttribute(
            $this->model->attributes['handle'],
            $value
        );
        
        craft()->content->saveContent($this->element);
    }
}