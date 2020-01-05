<?php

namespace Shetabit\Crypto\Traits;

/**
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder withTrashed()
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder onlyTrashed()
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder withoutTrashed()
 */
trait Expiring
{
    /**
     * Boot the has expired trait for a model.
     *
     * @return void
     */
    public static function bootExpiring()
    {
        static::addGlobalScope(new ExpiringScope);
    }

    /**
     * Initialize the soft expiring trait for an instance.
     *
     * @return void
     */
    public function initializeExpiring()
    {
        $this->dates[] = $this->getExpiredAtColumn();
    }

    /**
     * Mark as expired
     *
     * @return bool
     */
    public function markAsExpired()
    {
        if (! $this->exists) {
            return;
        }

        $this->performExpiringOnModel();

        return true;
    }

    /**
     * Perform the actual expiring query on this model instance.
     *
     * @return mixed
     */
    protected function performExpiringOnModel()
    {
        return $this->runExpiring();
    }

    /**
     * Perform the actual expiring query on this model instance.
     *
     * @return void
     */
    protected function runExpiring()
    {
        $query = $this->setKeysForSaveQuery($this->newModelQuery());

        $time = $this->freshTimestamp();

        $columns = [$this->getExpiredAtColumn() => $this->fromDateTime($time)];

        $this->{$this->getExpiredAtColumn()} = $time;

        if ($this->timestamps && ! is_null($this->getUpdatedAtColumn())) {
            $this->{$this->getUpdatedAtColumn()} = $time;

            $columns[$this->getUpdatedAtColumn()] = $this->fromDateTime($time);
        }

        $query->update($columns);
    }

    /**
     * Determine if the model instance has been expired.
     *
     * @return bool
     */
    public function hasExpired()
    {
        $expiredAt = $this->{$this->getExpiredAtColumn()};

        return ! is_null($expiredAt) && now()->gt($this->expired_at);
    }

    /**
     * Get the name of the "expired at" column.
     *
     * @return string
     */
    public function getExpiredAtColumn()
    {
        return defined('static::EXPIRED_AT') ? static::EXPIRED_AT : 'expired_at';
    }

    /**
     * Get the fully qualified "expired at" column.
     *
     * @return string
     */
    public function getQualifiedExpiredAtColumn()
    {
        return $this->qualifyColumn($this->getExpiredAtColumn());
    }
}
