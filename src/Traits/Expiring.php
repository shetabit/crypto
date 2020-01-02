<?php

namespace Illuminate\Database\Eloquent;

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
    public function expired()
    {
        return ! is_null($this->{$this->getExpiredAtColumn()});
    }

    /**
     * Get the name of the "deleted at" column.
     *
     * @return string
     */
    public function getExpiredAtColumn()
    {
        return defined('static::EXPIRED_AT') ? static::EXPIRED_AT : 'expired_at';
    }

    /**
     * Get the fully qualified "deleted at" column.
     *
     * @return string
     */
    public function getQualifiedExpiredAtColumn()
    {
        return $this->qualifyColumn($this->getExpiredAtColumn());
    }

    /**
     * Determine if token has expired
     *
     * @return bool
     */
    public function hasExpired()
    {
        return $this->expired_at === null ? false : now()->gt($this->expired_at);
    }

    /**
     * Mark token as expired
     *
     * @return mixed
     */
    public function markAsExpired()
    {
        $this->forceFill(['expired_at' => now()])->save();

        return $this;
    }
}
