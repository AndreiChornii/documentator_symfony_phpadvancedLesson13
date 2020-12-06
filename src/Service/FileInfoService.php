<?php


namespace Documentor\Service;


class FileInfoService implements InfoServiceInterface
{
    /**
     * @var bool
     * @deprecated Not used anymore.
     */
    private $dryRun;

    /** @var string */
    private $filename;

    public function setFilename(string $filename)
    {
        $this->filename = $filename;
        return $this;
    }

    public function isDryRun(bool $dryRun)
    {
        $this->dryRun = $dryRun;
        return $this;
    }

    public function getInfo(): array
    {
        $reflectionClass = $this->getClass();

        $classMetaData = $this->getMetaData($reflectionClass->getDocComment());
        $methods = $this->getMethods($reflectionClass->getMethods());

        $info = [
            'class_name' => $reflectionClass->getName(),
            'class_data' => $classMetaData,
            'methods' => $methods
        ];

        return $info;
    }

    /**
     * @param \ReflectionMethod[] $methods
     * @return array
     */
    private function getMethods(array $methods): array
    {
        $data = [];
        foreach ($methods as $method) {
            $data[] = [
                'meta' => $this->getMetaData($method->getDocComment()),
                'name' => $method->getName(),
                'arguments' => $this->getParametersData($method->getParameters()),
                'return_type' => (string) $method->getReturnType()
            ];
        }

        return $data;
    }

    /**
     * @param \ReflectionParameter[] $parameters
     */
    private function getParametersData(array $parameters)
    {
        $data = [];
        foreach ($parameters as $parameter) {
            $data[] = [
                'name' => $parameter->getName(),
                'type' => (string) $parameter->getType(),
            ];
        }

        return $data;
    }

    private function getMetaData(string $comment): array
    {
        $regexp = '/@([a-z]+?)\s+(.*?)\n/mi';

        preg_match_all($regexp, $comment, $matches);

        $fields = [];
        $values = [];
        foreach ($matches[1] as $field) {
            $fields[] = $field;
        }

        foreach ($matches[2] as $value) {
            $values[] = $value;
        }

        $combined = array_combine($fields, $values);
        return $combined;
    }

    private function getClass(): \ReflectionClass
    {
        if (!file_exists($this->filename)) {
            throw new \RuntimeException('File not found');
        }

        include $this->filename;
        $classPath = explode('/', $this->filename);
        if (empty($classPath)) {
            throw new \RuntimeException('Invalid path');
        }
        $classPath = str_replace('.php', '', array_pop($classPath));
        return new \ReflectionClass($classPath);
    }
}