<?php

$this->commandLine()->set('exclude', ['Eloquent\Phony']);

Kahlan\Filter\Filters::apply($this, 'run', function (callable $chain) {
    Eloquent\Phony\Kahlan\install();

    return $chain();
});
