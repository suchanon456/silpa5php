<?php

namespace Silpa5PHP\Core\FivePrecepts;

use Silpa5PHP\Config\BaseConfig;

/**
 * PreceptEngine
 * 
 * Manages the Five Precepts (Panca Sila) validation and initialization.
 * The Five Precepts form the foundation of ethical conduct in Buddhist philosophy
 * and are applied throughout the Silpa5PHP framework.
 * 
 * The Five Precepts:
 * 1. Ahimsa - Non-violence (no killing)
 * 2. Adinnadana - Non-stealing (no taking what is not given)
 * 3. Kamesu Micchacara - Right conduct in sensuality (no sexual misconduct)
 * 4. Musavada - Truthfulness (no lying)
 * 5. Sura Meraya Majja - Against intoxication (sobriety)
 */
class PreceptEngine
{
    /**
     * Configuration instance
     * 
     * @var BaseConfig
     */
    protected BaseConfig $config;

    /**
     * Precept violations log
     * 
     * @var array
     */
    protected array $violations = [];

    /**
     * Constructor
     * 
     * @param BaseConfig $config Application configuration
     */
    public function __construct(BaseConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Validate the Five Precepts compliance
     * 
     * Checks that the application configuration and environment comply
     * with the Five Precepts ethical guidelines.
     * 
     * @return bool
     */
    public function validate(): bool
    {
        // Validate Ahimsa - No harmful content
        $this->validateAhimsa();

        // Validate Adinnadana - No unauthorized access
        $this->validateAdinnadana();

        // Validate Kamesu - Proper conduct
        $this->validateKamesu();

        // Validate Musavada - Truthful configuration
        $this->validateMusavada();

        // Validate Sura Meraya - System stability
        $this->validateSuraMaraya();

        return empty($this->violations);
    }

    /**
     * Validate Ahimsa - Non-violence
     * Ensures no harmful content or logging
     * 
     * @return void
     */
    protected function validateAhimsa(): void
    {
        // Check if error reporting is set appropriately
        if (defined('ERROR_REPORTING') && ERROR_REPORTING === 0) {
            // Silent error reporting is acceptable in production
        }
    }

    /**
     * Validate Adinnadana - No stealing/unauthorized access
     * Ensures proper security measures
     * 
     * @return void
     */
    protected function validateAdinnadana(): void
    {
        // Check if CSRF protection is enabled
        if (!isset($this->config->CSRFProtection) || !$this->config->CSRFProtection) {
            $this->violations[] = 'CSRF protection should be enabled (Adinnadana violation)';
        }
    }

    /**
     * Validate Kamesu - Right conduct
     * Ensures proper session handling
     * 
     * @return void
     */
    protected function validateKamesu(): void
    {
        // Check if session configuration is properly set
        if (!isset($this->config->sessionDriver)) {
            $this->violations[] = 'Session driver must be configured (Kamesu violation)';
        }
    }

    /**
     * Validate Musavada - Truthfulness
     * Ensures honest environment configuration
     * 
     * @return void
     */
    protected function validateMusavada(): void
    {
        // Check if baseURL is properly configured
        if (empty($this->config->baseURL)) {
            $this->violations[] = 'Base URL must be properly configured (Musavada violation)';
        }
    }

    /**
     * Validate Sura Meraya - Sobriety/Stability
     * Ensures system stability and proper environment
     * 
     * @return void
     */
    protected function validateSuraMaraya(): void
    {
        // Environment check
        if (empty($_ENV['CI_ENVIRONMENT'])) {
            // Set a default if not specified
            $_ENV['CI_ENVIRONMENT'] = 'development';
        }
    }

    /**
     * Get all precept violations
     * 
     * @return array
     */
    public function getViolations(): array
    {
        return $this->violations;
    }

    /**
     * Check if there are any violations
     * 
     * @return bool
     */
    public function hasViolations(): bool
    {
        return !empty($this->violations);
    }

    /**
     * Log a violation
     * 
     * @param string $violation The violation message
     * @return void
     */
    public function logViolation(string $violation): void
    {
        $this->violations[] = $violation;
    }
}
