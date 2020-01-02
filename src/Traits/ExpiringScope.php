<?php

namespace Illuminate\Database\Eloquent;

class ExpiringScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithExpired', 'WithoutExpired', 'OnlyExpired'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereNull($model->getQualifiedExpiredAtColumn());
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }

        $builder->onDelete(function (Builder $builder) {
            $column = $this->getExpiredAtColumn($builder);

            return $builder->update([
                $column => $builder->getModel()->freshTimestampString(),
            ]);
        });
    }

    /**
     * Get the "Expired at" column for the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return string
     */
    protected function getExpiredAtColumn(Builder $builder)
    {
        if (count((array) $builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedExpiredAtColumn();
        }

        return $builder->getModel()->getExpiredAtColumn();
    }

    /**
     * Add the with-expired extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return void
     */
    protected function addWithExpired(Builder $builder)
    {
        $builder->macro('withExpired', function (Builder $builder, $withExpired = true) {
            if (! $withExpired) {
                return $builder->withoutExpired();
            }

            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the without-expired extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     *
     * @return void
     */
    protected function addWithoutExpired(Builder $builder)
    {
        $builder->macro('withoutExpired', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNull(
                $model->getQualifiedExpiredAtColumn()
            );

            return $builder;
        });
    }

    /**
     * Add the only-expired extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     *
     * @return void
     */
    protected function addOnlyExpired(Builder $builder)
    {
        $builder->macro('onlyExpired', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNotNull(
                $model->getQualifiedExpiredAtColumn()
            );

            return $builder;
        });
    }
}
