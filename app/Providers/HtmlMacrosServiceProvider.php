<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Collective\Html\FormBuilder;
use Collective\Html\HtmlBuilder;
use Illuminate\Support\Facades\Route;
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
        $this->registerNavControl();
        $this->registerBadges();
    }

    private function registerFormControl()
    {
        FormBuilder::macro('control' , function($type, $name, $errors, $value = '', $placeholder = '', $label = '', $customAttributes = [], $customClass = '') {
            $attributes = ['class' => 'form-control '.$customClass, 'placeholder' => $placeholder, 'id' => $name];
            $attributes = array_merge($attributes, $customAttributes);
            return sprintf('
                <div class="form-group %s">
                    %s
                    %s
                    %s
                </div>',
                $errors->has($name) ? 'has-error' : '',
                !empty($label) ? '<label for="'.$name.'">'.$label.'</label>' : '',
                call_user_func_array(['Form', $type], $type == 'password' ? [$name, $attributes] : [$name, $value, $attributes]),
                $errors->first($name, '<span class="help-block"><strong>:message</strong></span>'));
        });
        FormBuilder::macro('controlWithIcon' , function($type, $name, $errors, $value = '', $placeholder = '', $icon = '', $label='', $customAttributes = [], $customClass = '') {
            $attributes = ['class' => 'form-control '.$customClass, 'placeholder' => $placeholder, 'id' => $name];
            $attributes = array_merge($attributes, $customAttributes);
            return sprintf('
                <div class="form-group has-feedback %s">
                    %s
                    %s
                    <span class="glyphicon %s form-control-feedback"></span>
                    %s
                </div>',
                $errors->has($name) ? 'has-error' : '',
                !empty($label) ? '<label for="'.$name.'">'.$label.'</label>' : '',
                call_user_func_array(['Form', $type], $type == 'password' ? [$name, $attributes] : [$name, $value, $attributes]),
                $icon,
                $errors->first($name, '<span class="help-block"><strong>:message</strong></span>'));
        });
        FormBuilder::macro('timePicker' , function($name, $errors, $label) {
            return sprintf('
                    <div class="bootstrap-timepicker">
                        <div class="form-group %s">
                            <label>%s</label>

                            <div class="input-group">
                                <input type="text" class="form-control timepicker" name="%s" id="%s">
                                <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                            %s
                        </div>
                    </div>',
                $errors->has($name) ? 'has-error' : '',
                $label,
                $name, $name,
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

    private function registerNavControl()
    {
        HtmlBuilder::macro('adminNavMenu' , function($route, $prefix, $text, $icon='') {
            return sprintf('<li %s><a href="%s"><i class="fa %s"></i> <span>%s</span></a></li>',
                            strpos(Route::currentRouteName(), $prefix.'.') !== FALSE ? 'class="active"' : '',
                            route($route),
                            $icon,
                            $text);
        });
    }

    private function registerBadges()
    {
        HtmlBuilder::macro('badge' , function($yes=true) {
            return sprintf('<span class="badge %s">%s</span>',
                            $yes ? 'bg-green' : 'bg-red',
                            $yes ? 'Oui' : 'Non');
        });   
    }
}
