<?php

declare(strict_types=1);

namespace Vietstars\DevDebugger;

use Illuminate\Contracts\View\Engine;

class DebuggerViewEngine implements Engine
{
    /**
     * @var Engine
     */
    protected $engine;

    /**
     * @var DevDebugger
     */
    protected $devDebugger;

    /**
     * @param  Engine  $engine
     * @param  DevDebugger  $devDebugger
     */
    public function __construct(Engine $engine, DevDebugger $devDebugger)
    {
        $this->engine = $engine;
        $this->devDebugger = $devDebugger;
    }

    /**
     * @param  string  $path
     * @param  array  $data
     * @return string
     */
    public function get($path, array $data = [])
    {
        $shortPath = ltrim(str_replace(base_path(), '', realpath($path)), '/');

        return $this->devDebugger->measure($shortPath, function () use ($path, $data) {
            return $this->engine->get($path, $data);
        });
    }

    /**
     * NOTE: This is done to support other Engine swap (example: Livewire).
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->engine->$name(...$arguments);
    }
}
