<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Account Group
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Account> $accounts
 * @property-read int|null $accounts_count
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountGroup isActive()
 * @method static \Database\Factories\AccountGroupFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class AccountGroup extends Model
{
    use HasFactory;
    use Filterable;
    use Sortable;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'is_active'
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_active' => true
    ];

    function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

}
