<?php

namespace App;

use App;
use Illuminate\Database\Eloquent\Model;

class FavouriteApplicant extends Model
{

    protected $table = 'favourite_applicants';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Insert a shortlist row, tolerating legacy tables where `id` lacks AUTO_INCREMENT.
     */
    public static function addShortlist(int $userId, int $jobId, int $companyId): self
    {
        $existing = static::where('user_id', $userId)
            ->where('job_id', $jobId)
            ->where('company_id', $companyId)
            ->first();

        if ($existing) {
            return $existing;
        }

        $attrs = [
            'user_id'    => $userId,
            'job_id'     => $jobId,
            'company_id' => $companyId,
        ];

        try {
            return static::create($attrs);
        } catch (\Illuminate\Database\QueryException $e) {
            if (! static::isDuplicatePrimaryKey($e)) {
                throw $e;
            }

            $nextId = max(1, (int) static::max('id') + 1);

            return static::create(array_merge($attrs, ['id' => $nextId]));
        }
    }

    private static function isDuplicatePrimaryKey(\Illuminate\Database\QueryException $e): bool
    {
        $message = $e->getMessage();

        return strpos($message, 'Duplicate entry') !== false
            && strpos($message, "for key 'PRIMARY'") !== false;
    }

}
