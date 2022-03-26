<?php

namespace FluxEco\Storage\Core\Ports\Database;

interface TableAsserters {
    public function assertColumnNameIsLowerThanMaxLength(string $columName);
}