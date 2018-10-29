<?php namespace Koss\LaravelNovaSelect2;

use Laravel\Nova\Fields\Select;

/**
 * Class Select2
 *
 * @package Koss\Select2
 */
class Select2 extends Select
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'select2';

    /**
     * Set the options for the select menu.
     *
     * @param  array $options
     * @return $this
     */
    public function options($options)
    {
        return $this->withMeta([
            'options' => collect($options ?? [])->map(function ($label, $value) {
                return ['text' => $label, 'id' => $value];
            })->values()->all(),
        ]);
    }

    /**
     * Set the configuration for the select2.
     *
     * @param $config
     * @return $this
     */
    public function configuration($config)
    {
        return $this->withMeta([
            'config' => $config,
        ]);
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function showAsLink($value = true)
    {
        return $this->withMeta([
            'showAsLink' => $value,
        ]);
    }
}
