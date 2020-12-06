<?php


namespace Documentor\Service;


interface RenderInterface
{
    /**
     * Render report data.
     *
     * @param array $data
     * @return string
     */
    public function render(array $data);
}