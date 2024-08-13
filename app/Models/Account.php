<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use App\Enums\AccountTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AutoCode;

/**
 * 
 *
 * @property int $id
 * @property string $code
 * @property int $account_group_id
 * @property string $title
 * @property string $type
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AccountGroup $accountGroup
 * @method static \Illuminate\Database\Eloquent\Builder|Account filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Account filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Account filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder|Account restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder|Account sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Account sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAccountGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Account onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Account withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Account isActive()
 * @method static \Database\Factories\AccountFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Account extends Model
{
    use HasFactory;
    use Filterable;
    use Sortable;
    use SoftDeletes;
    use AutoCode;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'account_group_id',
        'title',
        'type',
        'is_active',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * @return array<string, mixed>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'type' => AccountTypeEnum::class,
        ];
    }

    /**
     * @return BelongsTo
     */
    public function accountGroup(): BelongsTo
    {
        return $this->belongsTo(AccountGroup::class);
    }

}
