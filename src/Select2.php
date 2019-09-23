<?php

namespace KossShtukert\LaravelNovaSelect2;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Field;
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
     * @param array|\Closure $options
     * @return $this
     */
    public function options($options)
    {
        if (is_callable($options)) {
            $options = $options();
        }

        return $this->withMeta([
            'options' => collect($options ?? [])->map(function ($value, $keyOrLabel) {
                if (is_array($value)) {
                    $this->configuration(['optgroup' => true]);

                    return [
                        'text'     => $keyOrLabel,
                        'children' => collect($value ?? [])->map(function ($childLabel, $childValue) {
                            return [
                                'text' => $childLabel,
                                'id'   => $childValue
                            ];
                        })->values()->all()
                    ];
                }

                return [
                    'text' => $value,
                    'id'   => $keyOrLabel
                ];
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
     * @param Closure|bool $callback
     * @return Select2|Select
     */
    public function readonly($callback = true)
    {
        $this->readonlyCallback = $callback;

        return $this->configuration(['disabled' => (bool)$this->readonlyCallback]);
    }

    /**
     * @param null $value
     * @return $this
     */
    public function default($value = null)
    {
        $this->configuration(['defaultValue' => is_array($value) ? $value : [$value]]);

        return $this;
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
            'config' => array_merge(Arr::get($this->meta(), 'config', []), $config),
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
