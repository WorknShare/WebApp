<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Collective\Html\FormBuilder;
use Collective\Html\HtmlBuilder;
use Collective\Html\FormFacade as Form;

class HtmlMacrosServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFormControl();
        $this->registerFormCheckbox();
    }

    private function registerFormControl()
    {
        FormBuilder::macro('control' , function($type, $name, $errors, $value = '', $placeholder = '', $customAttributes = [], $customClass = '') {
            $attributes = ['class' => 'form-control '.$customClass, 'placeholder' => $placeholder];
            $attributes = array_merge($attributes, $customAttributes);
            return sprintf('
                <div class="form-group has-feedback %s">
                    %s
                    %s
                </div>',
                $errors->has($name) ? 'has-error' : '',
                call_user_func_array(['Form', $type], $type == 'password' ? [$name, $attributes] : [$name, $value, $attributes]),
                $errors->first($name, '<span class="help-block"><strong>:message</strong></span>'));
        });
        FormBuilder::macro('controlWithIcon' , function($type, $name, $errors, $value = '', $placeholder = '', $icon = '', $customAttributes = [], $customClass = '') {
            $attributes = ['class' => 'form-control '.$customClass, 'placeholder' => $placeholder];
            $attributes = array_merge($attributes, $customAttributes);
            return sprintf('
                <div class="form-group has-feedback %s">
                    %s
                    <span class="glyphicon %s form-control-feedback"></span>
                    %s
                </div>',
                $errors->has($name) ? 'has-error' : '',
                call_user_func_array(['Form', $type], $type == 'password' ? [$name, $attributes] : [$name, $value, $attributes]),
                $icon,
                $errors->first($name, '<span class="help-block"><strong>:message</strong></span>'));
        });
    }

    private function registerFormCheckbox()
    {
        FormBuilder::macro('iCheckbox' , function($name, $text, $errors, $checked = false, $customClass = '') {
            $attributes = ['class' => 'form-control '.$customClass];
            return sprintf('
                <div class="form-group has-feedback checkbox icheck %s">
                    <label>
                      <input type="checkbox" name="%s" value="1" %s> %s
                    </label>
                    %s
                </div>',
                $errors->has($name) ? 'has-error' : '',
                $name,
                $checked ? 'checked' : '',
                $text,
                $errors->first($name, '<span class="help-block"><strong>:message</strong></span>'));
        });
    }
}
