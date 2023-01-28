<?php
declare(strict_types=1);
namespace WebShoppingApp\Controller;

class SessionsManager
{
    protected array $session;
    private bool $running = false;
    /**
     * @var mixed|null
     */

    public function __construct()
    {
        $this->startSafe();
    }

    public function isRunning(): bool
    {
        return $this->running;
    }

    public function clear(): void
    {
        $this->session = [];
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function startSafe(): bool
    {
        if ( $this->isRunning() ) return false;
        $this->clear();
        session_start();
        $this->session = &$_SESSION;
        $this->running = true;
        return $this->running;
    }

    public function __isset($name): bool
    {
        return isset($this->session[$name]);
    }

    public function __get(string $name)
    {
        return $this->session[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        $this->session[$name] = $value;
    }

    public function __toString(): string
    {
        $runningState = $this->running?'Yes':'No';
        $keys = array_keys($this->session);
        $keyList = array_reduce($keys, function($o, $k) {return $o .= $k.':';});
        return <<<STATS
           Running: {$runningState}
           SessionDataKeys: $keyList
        STATS;
    }
}