<?php
namespace Admin\Services;

class GamificationService {
    private $definitionsPath = __DIR__ . '/../../asset/docs/gamifikasi/gamifikasi_katalog.json';
    private $cacheKey = 'gamification_definitions';

    public function __construct() {
        // Ensure path exists
        if (!file_exists($this->definitionsPath)) {
            throw new \Exception('Gamification definition file not found at ' . $this->definitionsPath);
        }
    }

    /**
     * Load and parse definitions (JSON or YAML).
     * @return array
     */
    private function loadDefinitions(): array {
        $ext = strtolower(pathinfo($this->definitionsPath, PATHINFO_EXTENSION));
        $content = file_get_contents($this->definitionsPath);
        if ($ext === 'json') {
            $data = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON in gamification definition file: ' . json_last_error_msg());
            }
            return $data;
        } elseif ($ext === 'yaml' || $ext === 'yml') {
            if (!function_exists('yaml_parse')) {
                throw new \Exception('YAML support not available. Install yaml extension.');
            }
            $data = yaml_parse($content);
            if ($data === false) {
                throw new \Exception('Invalid YAML in gamification definition file.');
            }
            return $data;
        }
        throw new \Exception('Unsupported definition file format: ' . $ext);
    }

    /**
     * Get all activities, optionally cached.
     * @return array
     */
    public function getAllActivities(): array {
        if (function_exists('apcu_fetch')) {
            $cached = apcu_fetch($this->cacheKey, $success);
            if ($success) {
                return $cached;
            }
        }
        $activities = $this->loadDefinitions();
        if (function_exists('apcu_store')) {
            apcu_store($this->cacheKey, $activities, 300); // cache 5 minutes
        }
        return $activities;
    }

    /**
     * Get a single activity by its ID.
     * @param string $id
     * @return array|null
     */
    public function getActivityById(string $id): ?array {
        $activities = $this->getAllActivities();
        foreach ($activities as $act) {
            if (isset($act['id']) && $act['id'] === $id) {
                return $act;
            }
        }
        return null;
    }
}
?>
