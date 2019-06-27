<?php

namespace KossShtukert\LaravelNovaSelect2;

use Illuminate\Support\Str;
use Laravel\Nova\Fields\Select;
use ReflectionClass;

/**
 * Class Select2
 *
 * @package KossShtukert\LaravelNovaSelect2
 */
class Select2 extends Select
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'laravel-nova-select2';

    /**
     * Select2 constructor.
     *
     * @param               $name
     * @param null          $attribute
     * @param callable|null $resolveCallback
     */
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->setDefaultMeta();
    }

    /**
     * Set the options for the select menu.
     *
     * @param array $options
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
     * Display values using their corresponding specified labels.
     *
     * @return $this
     */
    public function displayUsingLabels()
    {
        return $this->displayUsing(function ($value) {
            return $value;
        });
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
     * @param null $resource
     * @return mixed
     * @throws \ReflectionException
     */
    public function showAsLink($resource = null)
    {
        if ($resource) {
            $resource = new ReflectionClass($resource);
            $resource = Str::lower(Str::plural(Str::kebab($resource->getShortName())));
        }

        return $this->withMeta([
            'showAsLink'     => true,
            'linkToResource' => $resource
        ]);
    }

    /**
     * @return void
     */
    private function setDefaultMeta()
    {
        $this->withMeta([
            'options'        => [],
            'config'         => [],
            'showAsLink'     => false,
            'linkToResource' => null
        ]);
    }
}
