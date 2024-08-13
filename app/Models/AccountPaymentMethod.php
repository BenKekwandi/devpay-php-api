<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use App\Traits\AutoCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property string $code
 * @property string $title
 * @property int $payment_method_id
 * @property int $account_id
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account $account
 * @property-read \App\Models\PaymentMethod $paymentmethod
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod filter(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod filterBy(array|string $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod filterFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod renamedFilterFields(array $renamedFilterFields)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod restrictedFilters(array|string $restrictedFilters)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod sort(?array $params = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod sortFields(array|string $fields)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod withoutTrashed()
 * @property string $remark
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PaymentMethod> $payments
 * @property-read int|null $payments_count
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountPaymentMethod whereRemark($value)
 * @method static \Database\Factories\AccountPaymentMethodFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */

class AccountPaymentMethod extends Model
{
    use HasFactory;
    use Filterable;
    use Sortable;
    use AutoCode;
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'title',
        'payment_method_id',
        'account_id',
        'remark',
        'is_active',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_active' => true,
    ];

    function payments(): HasMany
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
