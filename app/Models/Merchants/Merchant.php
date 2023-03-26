<?php

namespace App\Models\Merchants;

use App\Constants\Status;
use App\Models\User;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\Merchants\MerchantFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Merchants\Merchant
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property double $lat
 * @property double $lng
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static MerchantFactory factory($count = null, $state = [])
 * @method static Builder|Merchant newModelQuery()
 * @method static Builder|Merchant newQuery()
 * @method static Builder|Merchant query()
 * @method static Builder|Merchant whereCreatedAt($value)
 * @method static Builder|Merchant whereId($value)
 * @method static Builder|Merchant whereLat($value)
 * @method static Builder|Merchant whereLng($value)
 * @method static Builder|Merchant whereName($value)
 * @method static Builder|Merchant whereSlug($value)
 * @method static Builder|Merchant whereStatus($value)
 * @method static Builder|Merchant whereUpdatedAt($value)
 * @property int $creator_id
 * @property int $updater_id
 * @property-read User $creator
 * @property-read User $updater
 * @method static Builder|Merchant whereCreatorId($value)
 * @method static Builder|Merchant whereUpdaterId($value)
 * @mixin Eloquent
 * @mixin \Eloquent
 */
class Merchant extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'lat',
        'lng',
        'status',
        'creator_id',
        'updater_id',
    ];

    protected $casts = [
        'lat' => 'double',
        'lng' => 'double',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updater_id', 'id');
    }

    public function statusLabel(): Attribute
    {
        return new Attribute(
            get: function () {
                return Status::getLabel($this->status);
            }
        );
    }

    public function isInactive(): bool
    {
        return $this->status == Status::INACTIVE;
    }

    public function isPending(): bool
    {
        return $this->status == Status::PENDING;
    }

    public function isActive(): bool
    {
        return $this->status == Status::ACTIVE;
    }

    public function isDeletable(): bool
    {
        return $this->isInactive() || $this->isPending();
    }

    public function setBlameables(int $blameable_id)
    {
        $this->setCreator($blameable_id);
        $this->setUpdater($blameable_id);
    }

    public function setCreator(int $creator_id) {
        $this->creator_id =  $creator_id;
    }

    public function setUpdater(int $updater_id)
    {
        $this->updater_id = $updater_id;
    }
}
