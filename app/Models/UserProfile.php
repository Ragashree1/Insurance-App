<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profile';
    const CREATED_AT = 'create_date';
    const UPDATED_AT = null; 

    public function __construct($profileDetails = null)
    {
        parent::__construct();

        if ($profileDetails) {
            if (isset($profileDetails['name'])) {
                $this->name = $profileDetails['name'];
            }
            if (isset($profileDetails['description'])) {
                $this->description = $profileDetails['description'];
            }
            if (isset($profileDetails['status'])) {
                $this->status = $profileDetails['status'];
            }
        }
    }

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        //  
    ];

    public static function createUserProfile($profileDetails)
    {
        try {
            $profile = new UserProfile($profileDetails);
            $profile->save();
            return $profile;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function updateProfile($profileDetails)
    {
        try {
            if ($profileDetails) {
                if (isset($profileDetails['name'])) {
                    $this->name = $profileDetails['name'];
                }
                if (isset($profileDetails['description'])) {
                    $this->description = $profileDetails['description'];
                }
                if (isset($profileDetails['status'])) {
                    $this->status = $profileDetails['status'];
                }
            }

            $this->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    
}
