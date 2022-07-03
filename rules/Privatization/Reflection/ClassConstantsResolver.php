<?php

declare(strict_types=1);

namespace Rector\Privatization\Reflection;

use PHPStan\Reflection\ReflectionProvider;

final class ClassConstantsResolver
{
    /**
     * @var array<string, array<string, string>>
     */
    private array $cachedConstantNamesToValues = [];

    public function __construct(
        private readonly ReflectionProvider $reflectionProvider
    ) {
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getClassConstantNamesToValues(string $classWithConstants): ?array
    {
        $constantNamesToValues = null;
        if (isset($this->cachedConstantNamesToValues[$classWithConstants])) {
            return $this->cachedConstantNamesToValues[$classWithConstants];
        }

        if (! $this->reflectionProvider->hasClass($classWithConstants)) {
            return [];
        }

        $classReflection = $this->reflectionProvider->getClass($classWithConstants);
        $nativeReflection = $classReflection->getNativeReflection();

        $this->cachedConstantNamesToValues = $nativeReflection->getConstants();

        return $constantNamesToValues;
    }
}
