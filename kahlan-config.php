<?php

$commandLine = $this->commandLine();
$commandLine->option('spec', 'default', 'test/suite');
$commandLine->set('include', []);
