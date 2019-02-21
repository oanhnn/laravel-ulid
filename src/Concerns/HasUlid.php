<?php

namespace Laravel\Ulid\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Ulid\Ulid;

trait HasUlid
{
    /**
     * Register a creating model event with the dispatcher.
     *
     * @param \Closure|string $callback
     * @return void
     */
    abstract public static function creating($callback);

    /**
     * Register a saving model event with the dispatcher.
     *
     * @param \Closure|string $callback
     * @return void
     */
    abstract public static function saving($callback);

    /**
     * Boot HasUlid trait
     */
    protected static function bootHasUlid()
    {

        static::creating(function (Model $model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Ulid::generate();
            }
        });

        static::saving(function (Model $model) {
            $originalKey = $model->getOriginal($model->getKeyName());
            if ($originalKey !== $model->getKey()) {
                $model->{$model->getKeyName()} = $originalKey;
            }
        });
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|array|\Laravel\Ulid\Ulid $ulid
     * @param  string|null $field
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeWithUlid(Builder $query, $ulid, $field = null): Builder
    {
        if ($field) {
            return static::scopeWithUlidRelation($query, $ulid, $field);
        }

        if ($ulid instanceof Ulid) {
            $ulid = (string)$ulid;
        }

        $ulid = (array)$ulid;

        return $query->whereKey($ulid);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|array|\Laravel\Ulid\Ulid $ulid
     * @param  string $field
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeWithUlidRelation(Builder $query, $ulid, string $field): Builder
    {
        if ($ulid instanceof Ulid) {
            $ulid = (string)$ulid;
        }
        $ulid = (array)$ulid;

        return $query->whereIn($field, $ulid);
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
